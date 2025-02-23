<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Planner</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assests/css/styles.css" />
</head>

<body>
    <header>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <!-- Weather Planner -->
                <a class="navbar-brand" href="#">WEPLAN</a>

                <!-- Search City -->
                <form id="cityForm" method="GET" class="d-flex flex-grow-1 justify-content-center">
                    <label for="city" class="form-label"></label>
                    <input type="text" class="form-control" id="city" placeholder="Search city" aria-label="Search" aria-describedby="cityName">
                    <br />
                    <div id="form-text" class="text-warning"></div>
                    <button id="getWeatherBtn" type="submit" class="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </button>
                </form>


                <!-- City + Theme Toggle + User Dropdown -->
                <div id="city-name" class="d-flex align-items-center">
                    <!-- Show the city -->
                </div>

                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="btn me-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-highlights" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0m-8 5v1H4.5a.5.5 0 0 0-.093.009A7 7 0 0 1 3.1 13zm0-1H2.255a7 7 0 0 1-.581-1H8zm-6.71-2a7 7 0 0 1-.22-1H8v1zM1 8q0-.51.07-1H8v1zm.29-2q.155-.519.384-1H8v1zm.965-2q.377-.54.846-1H8v1zm2.137-2A6.97 6.97 0 0 1 8 1v1z" />
                    </svg>
                </button>

                <!-- User Avatar Dropdown -->
                <div class="dropdown d-flex gap-3">
                    <p class="user-name">Welcome</p>
                    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                        <!-- <img src="" alt="User Avatar" class="rounded-circle me-2"> -->
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
    </header>
    <!-- Main Dashboard -->
    <main>
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


        <section id="today" class="weather-showcase container-fluid">
            <div class="col row temp-col">
                <!-- Information -->
                <div id="current-weather" class="col">
                    <p id="current-time">Time</p>
                    <p>Temperature</p>
                    <h3 class="h3" id="current-temp"></h3>
                    <p id="current-description"></p>
                    <p id="current-pressure"></p>
                    <p id="current-humidity"></p>
                    <p id="current-wind"></p>
                    <p id="current-uv"></p>
                </div>

                <!-- Horly Forecast -->
                <div class="col">
                    <p>Hourly Forecast</p>
                    <!-- chart -->
                    <!-- icon -->
                    <p>Time</p>
                    <p>10&deg;C</p>
                </div>
            </div>
            <!-- Message -->
            <div class="col message-col">
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

        </section>

        <!-- Next 7 days -->
        <section id="next-days" class="weather-showcase container-fluid d-flex justify-content-between">
            <div class="card active">
                <p>Monday</p>

                <div class="icon-container">


                    <p class="temp">10&deg;C</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                    </svg>
                </div>
                <!-- icon -->

                <div class="card-content">
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <p>Monday</p>

                <div class="icon-container">


                    <p class="temp">10&deg;C</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                    </svg>
                </div>
                <!-- icon -->

                <div class="card-content">
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <p>Monday</p>

                <div class="icon-container">


                    <p class="temp">10&deg;C</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                    </svg>
                </div>
                <!-- icon -->

                <div class="card-content">
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <p>Monday</p>

                <div class="icon-container">


                    <p class="temp">10&deg;C</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                    </svg>
                </div>
                <!-- icon -->

                <div class="card-content">
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <p>Monday</p>

                <div class="icon-container">


                    <p class="temp">10&deg;C</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                    </svg>
                </div>
                <!-- icon -->

                <div class="card-content">
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <p>Monday</p>

                <div class="icon-container">


                    <p class="temp">10&deg;C</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                    </svg>
                </div>
                <!-- icon -->

                <div class="card-content">
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <p>Monday</p>

                <div class="icon-container">


                    <p class="temp">10&deg;C</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                    </svg>
                </div>
                <!-- icon -->

                <div class="card-content">
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                    <div class="row">
                        <span>hpa: 465</span>
                        <span>hpa: 465</span>
                    </div>
                </div>
            </div>

        </section>


        <!-- Task section -->

        <section id="task-container" class="container-fluid">

            <div class="col progress-col">
                <h3 class="h3">Progress bar</h3>
                <p><span>55</span> ouf of 100 tasks completed
                </p>
                <!-- Progress bar -->
                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" style="width: 25%">25%</div>
                </div>
            </div>

            <!-- Task list -->
            <div class="col">
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
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckbox">
                        <label class="form-check-label" for="thirdCheckbox">Third checkbox</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckbox">
                        <label class="form-check-label" for="thirdCheckbox">Third checkbox</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckbox">
                        <label class="form-check-label" for="thirdCheckbox">Third checkbox</label>
                    </li>
                </ul>
            </div>



        </section>

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