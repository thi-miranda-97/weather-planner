<?php
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root";        // Your database username (default is 'root' for local servers)
$password = "";            // Your database password (leave empty if using XAMPP/MAMP)
$dbname = "weather_planner"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  echo "Failed to connect DB" . $conn->connect_error;
}
