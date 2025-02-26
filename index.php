<?php
session_start();
$username = isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest';
?>


<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Weather App</title>
  <!-- Include Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="./assests/css/styles.css" />


</head>

<body>
  <!-- Modal for Sign Up & Sign In -->
  <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="h2 modal-title" id="authModalLabel">Sign In</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="authForm" method="POST" action="user_auth.php">
            <input type="hidden" id="authAction" value="signin">

            <div class="mb-3 d-none" id="signup-fields">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" autocomplete="username">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required autocomplete="email">
            </div>

            <div class="mb-5">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Sign In</button>

          </form>

          <p class="text-center mt-3">
            <a href="#" id="toggleAuth">Don't have an account? Sign Up</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Header -->
  <header>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid d-flex align-items-center justify-content-between">
        <!-- Weather Planner -->
        <a class="navbar-brand" href="#">WEPLAN</a>

        <!-- Search City -->
        <form id="weatherForm" method="GET" class="d-flex  justify-content-center">

          <div class="input-group flex-grow-1">
            <label for="city" class="form-label"></label>
            <input type="text" class="form-control" id="city" name="city" placeholder="e.g., London" required>


            <button id="getWeatherBtn" type="submit" class="btn btn-outline-secondary">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
              </svg>
            </button>
          </div>

          <div id="form-text" class="text-warning"></div>
        </form>


        <div class="d-flex gap-5">
          <!-- City + Theme Toggle + User Dropdown -->
          <div id="city-name" class="d-flex gap-2 justify-content-center align-items-center">
            <!-- Show the city -->
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
              <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
            </svg>
            <h2 class="h2" id="current-city"></h2>
          </div>

          <!-- Theme Toggle Button -->
          <button id="theme-toggle" class="btn me-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-highlights" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0m-8 5v1H4.5a.5.5 0 0 0-.093.009A7 7 0 0 1 3.1 13zm0-1H2.255a7 7 0 0 1-.581-1H8zm-6.71-2a7 7 0 0 1-.22-1H8v1zM1 8q0-.51.07-1H8v1zm.29-2q.155-.519.384-1H8v1zm.965-2q.377-.54.846-1H8v1zm2.137-2A6.97 6.97 0 0 1 8 1v1z" />
            </svg>
          </button>

          <!-- User Avatar Dropdown -->
          <div class="dropdown d-flex gap-3">

            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button"
              id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">

              <!-- <img src="" alt="User Avatar" class="rounded-circle me-2"> -->
              <span id="user-name"><?php echo $username; ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="#">Profile</a></li>
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><button id="sign-in-btn" class="dropdown-item">Sign In</button></li>
              <li><button id="sign-out-btn" class="dropdown-item d-none">Sign Out</button></li>
            </ul>
          </div>
        </div>
      </div>

    </nav>
  </header>

  <main>
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#today" data-target="today">Today</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#next-days" data-target="next-days">Next 5 Days</a>
      </li>
    </ul>
    <article id="weatherResult"></article>


    <!-- Task Section (only visible to authenticated users) -->
    <?php if (isset($_SESSION['user'])): ?>
      <section id="task-section" class="container-fluid">

        <div class="col progress-col">

          <p><span>55</span> ouf of 100 tasks completed
          </p>
          <!-- Progress bar -->
          <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" style="width: 25%">25%</div>
          </div>
        </div>

        <!-- Task list -->
        <div class="col task-col">
          <div class="d-flex justify-content-between align-items-center mb-5">
            <h3 class="h3">My Tasks</h3>
            <button class="btn btn-success w-25" id="addTaskBtn">+ Add Task</button>
          </div>
          <ul id="taskList" class="list-group">

            <!-- Render dynamically in AJAX -->
          </ul>
        </div>
      </section>

      <!-- Add/Edit Task Modal -->
      <div class="modal fade" id="taskModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add/Edit Task</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <form id="taskForm">
                <input type="hidden" id="taskId">
                <div class="mb-3">
                  <label for="taskName" class="form-label">Task</label>
                  <input type="text" class="form-control" id="taskName" required>
                </div>
                <div class="mb-3">
                  <label for="dueDate" class="form-label">Due Date</label>
                  <input type="date" class="form-control" id="dueDate">
                </div>
                <div class="mb-3">
                  <label for="taskTag" class="form-label">Tag</label>
                  <input type="text" class="form-control" id="taskTag">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>


    <?php else: ?>
      <p>Please sign in to view your tasks.</p>
    <?php endif; ?>

  </main>


  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <!-- Include Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Include Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Custom Script -->
  <script src="script.js"></script>
</body>

</html>