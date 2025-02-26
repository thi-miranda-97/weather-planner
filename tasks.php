<?php
header('Content-Type: application/json');

require 'db.php';
session_start();

// Ensure the user is authenticated
if (!isset($_SESSION['user_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
  exit;
}

$userId = $_SESSION['user_id'];

// Get the action type from the POST data
$action = isset($_POST['action']) ? $_POST['action'] : null;

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

  default:
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    break;
}

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

function addTask($userId)
{
  global $conn;
  $task = $_POST['taskName'];
  $dueDate = $_POST['dueDate'];
  $tag = $_POST['taskTag'];

  // Debugging statements
  error_log("Adding task: $task, Due Date: $dueDate, Tag: $tag");

  $sql = "INSERT INTO tasks (user_id, task, completed, due_date, tag, created_at) VALUES (?, ?, 0, ?, ?, NOW())";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("isss", $userId, $task, $dueDate, $tag);
  if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Task added successfully']);
  } else {
    error_log("Error adding task: " . $stmt->error); // Debugging
    echo json_encode(['status' => 'error', 'message' => 'Error adding task: ' . $stmt->error]);
  }
}
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

function updateTask($userId)
{
  global $conn;
  $taskId = $_POST['taskId'];
  $task = $_POST['taskName'];
  $dueDate = $_POST['dueDate'];
  $tag = $_POST['taskTag'];
  $completed = isset($_POST['completed']) ? 1 : 0;

  $sql = "UPDATE tasks SET task = ?, due_date = ?, tag = ?, completed = ? WHERE id = ? AND user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssiii", $task, $dueDate, $tag, $completed, $taskId, $userId);
  if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Task updated successfully']);
  } else {
    error_log("Error updating task: " . $stmt->error); // Debugging
    echo json_encode(['status' => 'error', 'message' => 'Error updating task: ' . $stmt->error]);
  }
}

function deleteTask($userId)
{
  global $conn;
  $taskId = $_POST['taskId'];
  $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $taskId, $userId);
  if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Task deleted successfully']);
  } else {
    error_log("Error deleting task: " . $stmt->error); // Debugging
    echo json_encode(['status' => 'error', 'message' => 'Error deleting task: ' . $stmt->error]);
  }
}
