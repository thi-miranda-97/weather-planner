<?php
error_reporting(E_ALL); // Report all errors
ini_set('display_errors', 1); // Display errors
session_start();
header('Content-Type: application/json');

require 'db.php';

$response = ['status' => 'error', 'message' => 'Invalid action'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $username = $_POST['username'] ?? '';
  $city = $_POST['city'] ?? '';
  $theme = $_POST['theme'] ?? 'light';

  if (empty($action)) {
    $response['message'] = 'Action is required';
    echo json_encode($response);
    exit;
  }

  if ($action === 'signin') {
    if (empty($email) || empty($password)) {
      $response['message'] = 'Email and password are required';
      echo json_encode($response);
      exit;
    }

    // Fetch user from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
      // Successful sign-in
      $_SESSION['user'] = $user['username'];
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['city'] = $user['city'];
      $_SESSION['theme'] = $user['theme'];
      $response = [
        'status' => 'success',
        'username' => $user['username'],
        'city' => $user['city'],
        'theme' => $user['theme']
      ];
    } else {
      $response['message'] = 'Invalid email or password';
    }
  } elseif ($action === 'signup') {
    if (empty($username) || empty($email) || empty($password)) {
      $response['message'] = 'Username, email, and password are required';
      echo json_encode($response);
      exit;
    }

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->fetch_assoc()) {
      $response['message'] = 'Email already exists';
      echo json_encode($response);
      exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, city, theme) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $hashedPassword, $city, $theme);
    if ($stmt->execute()) {
      $_SESSION['user'] = $username;
      $_SESSION['user_id'] = $conn->insert_id;
      $_SESSION['city'] = $city;
      $_SESSION['theme'] = $theme;
      $response = [
        'status' => 'success',
        'username' => $username,
        'city' => $city,
        'theme' => $theme
      ];
    } else {
      $response['message'] = 'Failed to create account';
    }
  } elseif ($action === 'signout') {
    session_unset();
    session_destroy();
    $response = ['status' => 'success'];
  } elseif ($action === 'update_preferences') {
    // Update user preferences (city and theme)
    $userId = $_SESSION['user_id'] ?? null;
    if ($userId) {
      $city = $_POST['city'] ?? '';
      $theme = $_POST['theme'] ?? 'light';

      // Update the user's preferences in the database
      $stmt = $conn->prepare("UPDATE users SET city = ?, theme = ? WHERE id = ?");
      $stmt->bind_param("ssi", $city, $theme, $userId);
      if ($stmt->execute()) {
        $_SESSION['city'] = $city; // Update session data
        $_SESSION['theme'] = $theme; // Update session data
        $response = [
          'status' => 'success',
          'city' => $city,
          'theme' => $theme
        ];
      } else {
        $response['message'] = 'Failed to update preferences';
      }
    } else {
      $response['message'] = 'User not authenticated';
    }
  } elseif ($action === 'get_preferences') {
    // Fetch user preferences (city and theme)
    $userId = $_SESSION['user_id'] ?? null;
    if ($userId) {
      $stmt = $conn->prepare("SELECT city, theme FROM users WHERE id = ?");
      $stmt->bind_param("i", $userId);
      $stmt->execute();
      $result = $stmt->get_result();
      $preferences = $result->fetch_assoc();
      if ($preferences) {
        $response = [
          'status' => 'success',
          'city' => $preferences['city'],
          'theme' => $preferences['theme']
        ];
      } else {
        $response['message'] = 'Failed to fetch preferences';
      }
    } else {
      $response['message'] = 'User not authenticated';
    }
  } elseif ($action === 'save_city') {
    // Save the searched city to user preferences
    $userId = $_SESSION['user_id'] ?? null;
    if ($userId) {
      $city = $_POST['city'] ?? '';
      if (!empty($city)) {
        // Update the user's city in the database
        $stmt = $conn->prepare("UPDATE users SET city = ? WHERE id = ?");
        $stmt->bind_param("si", $city, $userId);
        if ($stmt->execute()) {
          $_SESSION['city'] = $city; // Update session data
          $response = ['status' => 'success', 'city' => $city];
        } else {
          $response['message'] = 'Failed to save city';
        }
      } else {
        $response['message'] = 'City is required';
      }
    } else {
      $response['message'] = 'User not authenticated';
    }
  } else {
    $response['message'] = 'Invalid action';
  }
} else {
  $response['message'] = 'Invalid request method';
}

echo json_encode($response);
