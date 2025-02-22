<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Planner</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/styles.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <!-- Weather Planner -->
            <a class="navbar-brand" href="#">Weather Planner</a>

            <!-- Search Bar -->
            <form class="d-flex flex-grow-1 justify-content-center" role="search">
                <input class="form-control w-50 me-2" type="search" placeholder="Search city" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <!-- City + Theme Toggle + User Dropdown -->
            <div class="d-flex align-items-center">
                <!-- Show the city -->
                <div id="location" class="me-3">📍 New York, USA</div>

                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="btn btn-outline-dark me-3">🌙 Dark Mode</button>

                <!-- User Avatar Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://via.placeholder.com/40" alt="User Avatar" class="rounded-circle me-2">
                        <span id="username">Guest</span>
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

    <!-- navs and tabs -->
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Today</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Tomorrow</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Next 7 days</a>
        </li>
    </ul>

    <!-- Main Dashboard -->
    <main>
        <section id="today" class="container-fluid active">
            <div class="row">
                <div class="col-9 row">
                    <!-- Information -->
                    <div class="col bg-warning">
                        <p>Time</p>
                        <p>Temperature</p>
                        <h3 class="h3">10&deg;C</h3>
                        <p>Party Cloudy</p>
                        <p>hpa</p>
                        <p>%</p>
                        <p>wind</p>
                    </div>

                    <!-- Horly Forecast -->
                    <div class="col-8">
                        <p>Hourly Forecast</p>
                        <!-- chart -->
                        <!-- icon -->
                        <p>Time</p>
                        <p>10&deg;C</p>
                    </div>
                </div>
                <!-- Message -->
                <div class="col">
                    <div>
                        <!-- icon -->
                        <p>7 UV</p>
                        <p>Stay hydrated!</p>
                    </div>

                    <div>
                        <!-- icon -->
                        <p>7 UV</p>
                        <p>Stay hydrated!</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Next 7 days -->
        <section id="next-days" class="d-flex justify-content-between">
            <div>
                <p>Mon</p>
                <!-- icon -->
                <p>10&deg;C</p>
            </div>
            <div>
                <p>Mon</p>
                <!-- icon -->
                <p>10&deg;C</p>
            </div>
            <div>
                <p>Mon</p>
                <!-- icon -->
                <p>10&deg;C</p>
            </div>
            <div>
                <p>Mon</p>
                <!-- icon -->
                <p>10&deg;C</p>
            </div>

        </section>


        <!-- Task section -->

        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h3 class="h3">Progress bar</h3>
                    <p><span>55</span> ouf of 100 tasks completed
                    </p>
                    <!-- Progress bar -->
                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 25%">25%</div>
                    </div>
                </div>

                <!-- Task list -->
                <div class="col-8">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <input class="form-check-input me-1" type="checkbox" value="" id="firstCheckbox">
                                <label class="form-check-label" for="firstCheckbox">First checkbox</label>
                            </div>

                            <span>12/2/2025</span>
                            <span>tag</span>
                            <!-- icon delete and edit -->
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" id="secondCheckbox">
                            <label class="form-check-label" for="secondCheckbox">Second checkbox</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckbox">
                            <label class="form-check-label" for="thirdCheckbox">Third checkbox</label>
                        </li>
                    </ul>
                </div>
            </div>


        </div>

    </main>
    <!-- Footer -->

    <!-- jQuery & Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="./js/script.js"></script>
</body>

</html>