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
              <input class="form-check-input me-1" type="checkbox" value="" id="checkbox1">
              <label class="form-check-label" for="checkbox1">First checkbox</label>
            </div>
            <span>12/2/2025</span>
            <span>tag</span>
            <!-- icon delete and edit -->
          </li>
          <li class="list-group-item">
            <input class="form-check-input me-1" type="checkbox" value="" id="checkbox2">
            <label class="form-check-label" for="checkbox2">Second checkbox</label>
          </li>
          <li class="list-group-item">
            <input class="form-check-input me-1" type="checkbox" value="" id="checkbox3">
            <label class="form-check-label" for="checkbox3">Third checkbox</label>
          </li>
          <li class="list-group-item">
            <input class="form-check-input me-1" type="checkbox" value="" id="checkbox4">
            <label class="form-check-label" for="checkbox4">Fourth checkbox</label>
          </li>
          <li class="list-group-item">
            <input class="form-check-input me-1" type="checkbox" value="" id="checkbox5">
            <label class="form-check-label" for="checkbox5">Fifth checkbox</label>
          </li>
          <li class="list-group-item">
            <input class="form-check-input me-1" type="checkbox" value="" id="checkbox6">
            <label class="form-check-label" for="checkbox6">Sixth checkbox</label>
          </li>
        </ul>
      </div>



    </section>

  </main>


  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <!-- Include Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Include Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Custom Script -->
  <script>
    function togglePage(id) {
      $("#today, #next-days").each(function() {
        $(this).toggleClass("hidden", this.id !== id);
      });
      $(".nav-link").each(function() {
        $(this).toggleClass("active", $(this).data("target") === id);
      });
    }

    $(document).ready(function() {
      let hourlyForecastChart = null;

      // Theme toggles
      $("#theme-toggle").on("click", function() {
        const currentTheme = $("html").attr("data-theme");
        $("html").attr("data-theme", currentTheme === "light" ? "dark" : "light");
      });

      // Card hover animation expanding
      $(document).on("click", "#next-days .card", function() {
        $("#next-days .card").removeClass("active");
        $(this).addClass("active");
      });

      // Function to toggle visibility of sections and update active link
      togglePage('today');

      // Attach click events to nav-links
      $(".nav-link").on("click", function(e) {
        e.preventDefault();
        togglePage($(this).data("target"));
      });






      $('#weatherForm').on('submit', function(e) {
        e.preventDefault();
        const city = $('#city').val();
        if (city) {
          $.ajax({
            url: 'getWeatherapi.php',
            type: 'GET',
            data: {
              city: city
            },
            dataType: 'json',
            success: function(response) {
              if (response.error) {
                $('#weatherResult').html(`<div class="alert alert-warning">${response.error}</div>`);
              } else {
                $('#current-city').text(response.currentWeather.cityName);
                const localTime = response.currentWeather.localTime.split(' ');
                const currentHtml = generateWeatherHTML('today', 'Today', localTime[0], localTime[1], response.currentWeather, response.hourlyForecast);
                const forecastHtml = generateForecastHTML(response.fiveDayForecast);
                $('#weatherResult').html(currentHtml + forecastHtml);
                togglePage('today');
                createChart(response.hourlyForecast);
              }
            },
            error: function() {
              $('#weatherResult').html('<div class="alert alert-danger">Failed to fetch weather data.</div>');
            }
          });
        } else {
          $('#weatherResult').html('<div class="alert alert-warning">Please enter a city name.</div>');
        }
      });

      function generateWeatherHTML(id, title, date, time, weather, hourlyForecast) {
        return `
          <section id="${id}" class="weather-showcase container-fluid">
            <div class="col row temp-col">
              <div id="current-weather">
                <div class="d-flex justify-content-between">
                  <p>${title} (${date})</p>
                  <p>${time}</p>
                </div>
                <div class="">
                  <p class="temp">${weather.temperature}&deg;C</p>
                  <p>${weather.weatherDescription}</p>
                </div>
                <div class="weather-description d-flex">
                  <div class="flex-grow-1">
                  
                    <p>${generateWeatherIcon('bi-water')} ${weather.pressure} hPa</p>
                    <p>${generateWeatherIcon('bi-droplet-half')} ${weather.humidity}%</p>
                  </div>
                  <div class="flex-grow-1">
                    <p>${generateWeatherIcon('bi-wind')} ${weather.windSpeed} m/s</p>
                    <p>${generateWeatherIcon('bi-brightness-low')} ${weather.uvIndex}</p>
                  </div>
                </div>
              </div>
              <div class="col">
                <p>Hourly Forecast</p>
                <canvas id="hourlyForecastChart" aria-label="Hourly Forecast Line Chart" role="img"></canvas>
              </div>
            </div>
          </section>`;
      }

      function generateForecastHTML(forecast) {
        let forecastHtml = `<section id="next-days" class="weather-showcase hidden container-fluid d-flex justify-content-between">`;
        forecast.forEach(day => {
          forecastHtml += `
            <div class="card">
              <p>${day.day}</p>
              <div class="icon-container">
                <p class="temp">${day.temperature}&deg;C</p>
                ${generateWeatherIcon('bi-brightness-high')}
              </div>
              <div class="card-content d-flex justify-content-between">
                <div class="row">
                  <p>${generateWeatherIcon('bi-water')} ${day.pressure} hPa</p>
                  <p>${generateWeatherIcon('bi-droplet-half')} ${day.humidity}%</p>
                </div>
                <div class="row">
                  <p>${generateWeatherIcon('bi-wind')} ${day.windSpeed} m/s</p>
                  <p>${generateWeatherIcon('bi-brightness-low')} ${day.uvIndex}</p>
                </div>
              </div>
            </div>`;
        });
        forecastHtml += `</section>`;
        return forecastHtml;
      }

      function generateWeatherIcon(iconClass) {
        return `<i class="${iconClass}"></i>`;
      }

      function createChart(hourlyForecast) {
        const times = hourlyForecast.map(forecast => forecast.time);
        const temperatures = hourlyForecast.map(forecast => forecast.temperature);
        const labels = times.map((time, index) => time + "\n" + temperatures[index] + "°C");
        if (hourlyForecastChart) {
          hourlyForecastChart.destroy();
        }
        const ctx = document.getElementById('hourlyForecastChart').getContext('2d');
        hourlyForecastChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [{
              label: 'Temperature (°C)',
              data: temperatures,
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 3,
              pointBackgroundColor: 'rgba(75, 192, 192, 1)',
              pointBorderColor: '#fff',
              pointRadius: 5,
              pointHoverRadius: 7,
              fill: true
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            font: {
              family: 'inherit'
            },
            plugins: {
              title: {
                display: false,
              },
              legend: {
                display: false,
                position: 'top',

              }
            },
            scales: {
              y: {
                beginAtZero: false,
                title: {
                  display: false,
                },
                grid: {
                  display: false
                },
                ticks: {
                  display: false
                },
                border: {
                  display: false,
                }
              },
              x: {
                title: {
                  display: false,

                },
                grid: {
                  display: false
                },

                border: {
                  display: false,
                },
                ticks: {
                  display: true,
                  font: {

                    size: 12,
                  },
                  callback: function(value, index) {
                    return [times[index], temperatures[index] + "°C"];
                  },
                }
              }
            },
            animation: {
              duration: 1000,
              easing: 'easeInOutQuad'
            }
          }
        });
      }
    });
  </script>
</body>

</html>