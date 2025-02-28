<?php
header('Content-Type: application/json'); // Ensure the response is JSON
session_start();
require 'db.php'; // Include your database connection file

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'Welcome to WEPLAN, please sign in to continue']);
  exit;
}

$userId = $_SESSION['user_id'];

// Get the action type from the POST data
$action = $_POST['action'] ?? null;

// Handle the task actions
switch ($action) {
  case 'fetch':
    if (isset($_POST['taskId'])) {
      // Fetch a specific task for editing
      fetchTask($userId, $_POST['taskId']);
    } else {
      // Fetch all tasks for the user
      fetchTasks($userId);
    }
    break;

  case 'add':
    addTask($userId);
    break;

  case 'update':
    updateTask($userId);
    break;

  case 'delete':
    deleteTask($userId);
    break;

  case 'update_completion':
    updateTaskCompletion($userId);
    break;

  default:
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    break;
}

/**
 * Fetch all tasks for the user
 */
function fetchTasks($userId)
{
  global $conn;
  $sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();
  $tasks = [];
  while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
  }
  echo json_encode(['status' => 'success', 'tasks' => $tasks]);
}

/**
 * Add a new task for the user
 */
function addTask($userId)
{
  global $conn;

  // Validate input data
  $task = trim($_POST['taskName'] ?? '');
  $dueDate = trim($_POST['dueDate'] ?? '');
  $tag = trim($_POST['taskTag'] ?? '');

  if (empty($task)) {
    echo json_encode(['status' => 'error', 'message' => 'Task name is required']);
    return;
  }

  // Insert the task into the database
  $sql = "INSERT INTO tasks (user_id, task, completed, due_date, tag, created_at) VALUES (?, ?, 0, ?, ?, NOW())";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("isss", $userId, $task, $dueDate, $tag);

  if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Task added successfully']);
  } else {
    error_log("Error adding task: " . $stmt->error); // Log the error
    echo json_encode(['status' => 'error', 'message' => 'Error adding task']);
  }
}

/**
 * Fetch a specific task for editing
 */
function fetchTask($userId, $taskId)
{
  global $conn;
  $sql = "SELECT * FROM tasks WHERE user_id = ? AND id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $userId, $taskId);
  $stmt->execute();
  $result = $stmt->get_result();
  $task = $result->fetch_assoc();

  if ($task) {
    echo json_encode(['status' => 'success', 'task' => $task]);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Task not found']);
  }
}

/**
 * Update an existing task
 */
function updateTask($userId)
{
  global $conn;

  // Validate input data
  $taskId = $_POST['taskId'] ?? null;
  $task = trim($_POST['taskName'] ?? '');
  $dueDate = trim($_POST['dueDate'] ?? '');
  $tag = trim($_POST['taskTag'] ?? '');
  $completed = isset($_POST['completed']) ? 1 : 0;

  if (empty($task)) {
    echo json_encode(['status' => 'error', 'message' => 'Task name is required']);
    return;
  }

  // Update the task in the database
  $sql = "UPDATE tasks SET task = ?, due_date = ?, tag = ?, completed = ? WHERE id = ? AND user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssiii", $task, $dueDate, $tag, $completed, $taskId, $userId);

  if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Task updated successfully']);
  } else {
    error_log("Error updating task: " . $stmt->error); // Log the error
    echo json_encode(['status' => 'error', 'message' => 'Error updating task']);
  }
}

/**
 * Delete a task
 */
function deleteTask($userId)
{
  global $conn;

  // Validate input data
  $taskId = $_POST['taskId'] ?? null;

  if (empty($taskId)) {
    echo json_encode(['status' => 'error', 'message' => 'Task ID is required']);
    return;
  }

  // Delete the task from the database
  $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $taskId, $userId);

  if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Task deleted successfully']);
  } else {
    error_log("Error deleting task: " . $stmt->error); // Log the error
    echo json_encode(['status' => 'error', 'message' => 'Error deleting task']);
  }
}

/**
 * Update task completion status
 */
function updateTaskCompletion($userId)
{
  global $conn;

  // Validate input data
  $taskId = $_POST['taskId'] ?? null;
  $completed = $_POST['completed'] ?? null;

  if (is_null($taskId) || is_null($completed)) {
    echo json_encode(['status' => 'error', 'message' => 'Task ID and completion status are required']);
    return;
  }

  // Update the task completion status in the database
  $sql = "UPDATE tasks SET completed = ? WHERE id = ? AND user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iii", $completed, $taskId, $userId);

  if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
  } else {
    error_log("Error updating task completion status: " . $stmt->error); // Log the error
    echo json_encode(['status' => 'error', 'message' => 'Failed to update task completion status']);
  }
}
