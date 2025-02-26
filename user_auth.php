<?php
session_start();
header('Content-Type: application/json'); // Ensure response is JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'];

  if ($action === 'signup') {
    // Sign Up Logic
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
      $_SESSION['user'] = $username;
      echo json_encode(['status' => 'success', 'username' => $username]);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Signup failed']);
    }
  }

  if ($action === 'signin') {
    // Sign In Logic
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user'] = $user['username'];
      echo json_encode(['status' => 'success', 'username' => $user['username']]);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    }
  }

  if ($action === 'signout') {
    // Sign Out Logic
    session_destroy();
    echo json_encode(['status' => 'success']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
