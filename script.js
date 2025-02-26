function togglePage(id) {
  $("#today, #next-days").each(function () {
    $(this).toggleClass("hidden", this.id !== id);
  });
  $(".nav-link").each(function () {
    $(this).toggleClass("active", $(this).data("target") === id);
  });
}

$(document).ready(function () {
  let hourlyForecastChart = null;

  // Theme toggles
  $("#theme-toggle").on("click", function () {
    const currentTheme = $("html").attr("data-theme");
    $("html").attr("data-theme", currentTheme === "light" ? "dark" : "light");
  });

  // Card hover animation expanding
  $(document).on("click", "#next-days .card", function () {
    $("#next-days .card").removeClass("active");
    $(this).addClass("active");
  });

  // Function to toggle visibility of sections and update active link
  togglePage("today");

  // Attach click events to nav-links
  $(".nav-link").on("click", function (e) {
    e.preventDefault();
    togglePage($(this).data("target"));
  });

  $("#weatherForm").on("submit", function (e) {
    e.preventDefault();
    const city = $("#city").val();
    if (city) {
      $.ajax({
        url: "getWeatherapi.php",
        type: "GET",
        data: {
          city: city,
        },
        dataType: "json",
        success: function (response) {
          if (response.error) {
            $("#weatherResult").html(
              `<div class="alert alert-warning">${response.error}</div>`
            );
          } else {
            $("#current-city").text(response.currentWeather.cityName);
            const localTime = response.currentWeather.localTime.split(" ");
            const currentHtml = generateWeatherHTML(
              "today",
              "Today",
              localTime[0],
              localTime[1],
              response.currentWeather,
              response.hourlyForecast
            );
            const forecastHtml = generateForecastHTML(response.fiveDayForecast);
            $("#weatherResult").html(currentHtml + forecastHtml);
            togglePage("today");
            createChart(response.hourlyForecast);
          }
        },
        error: function () {
          $("#weatherResult").html(
            '<div class="alert alert-danger">Failed to fetch weather data.</div>'
          );
        },
      });
    } else {
      $("#weatherResult").html(
        '<div class="alert alert-warning">Please enter a city name.</div>'
      );
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
              
                <p>${generateWeatherIcon(
                  "bi-water"
                )} ${weather.pressure} hPa</p>
                <p>${generateWeatherIcon(
                  "bi-droplet-half"
                )} ${weather.humidity}%</p>
              </div>
              <div class="flex-grow-1">
                <p>${generateWeatherIcon(
                  "bi-wind"
                )} ${weather.windSpeed} m/s</p>
                <p>${generateWeatherIcon(
                  "bi-brightness-low"
                )} ${weather.uvIndex}</p>
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
    forecast.forEach((day) => {
      forecastHtml += `
        <div class="card">
          <p>${day.day}</p>
          <div class="icon-container">
            <p class="temp">${day.temperature}&deg;C</p>
            ${generateWeatherIcon("bi-brightness-high")}
          </div>
          <div class="card-content d-flex justify-content-between">
            <div class="row">
              <p>${generateWeatherIcon("bi-water")} ${day.pressure} hPa</p>
              <p>${generateWeatherIcon("bi-droplet-half")} ${day.humidity}%</p>
            </div>
            <div class="row">
              <p>${generateWeatherIcon("bi-wind")} ${day.windSpeed} m/s</p>
              <p>${generateWeatherIcon("bi-brightness-low")} ${day.uvIndex}</p>
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
    const times = hourlyForecast.map((forecast) => forecast.time);
    const temperatures = hourlyForecast.map((forecast) => forecast.temperature);
    const labels = times.map(
      (time, index) => time + "\n" + temperatures[index] + "°C"
    );
    if (hourlyForecastChart) {
      hourlyForecastChart.destroy();
    }
    const ctx = document.getElementById("hourlyForecastChart").getContext("2d");
    hourlyForecastChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Temperature (°C)",
            data: temperatures,
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 3,
            pointBackgroundColor: "rgba(75, 192, 192, 1)",
            pointBorderColor: "#fff",
            pointRadius: 5,
            pointHoverRadius: 7,
            fill: true,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        font: {
          family: "inherit",
        },
        plugins: {
          title: {
            display: false,
          },
          legend: {
            display: false,
            position: "top",
          },
        },
        scales: {
          y: {
            beginAtZero: false,
            title: {
              display: false,
            },
            grid: {
              display: false,
            },
            ticks: {
              display: false,
            },
            border: {
              display: false,
            },
          },
          x: {
            title: {
              display: false,
            },
            grid: {
              display: false,
            },

            border: {
              display: false,
            },
            ticks: {
              display: true,
              font: {
                size: 12,
              },
              callback: function (_, index) {
                return [times[index], temperatures[index] + "°C"];
              },
            },
          },
        },
        animation: {
          duration: 1000,
          easing: "easeInOutQuad",
        },
      },
    });
  }

  // Show the modal when clicking Sign In
  $("#sign-in-btn").click(function () {
    $("#authModal").modal("show");
  });

  // Toggle between Sign In and Sign Up
  $("#toggleAuth").click(function (e) {
    e.preventDefault();
    let isSignIn = $("#authAction").val() === "signin";

    $("#authAction").val(isSignIn ? "signup" : "signin");
    $("#authModalLabel").text(isSignIn ? "Sign Up" : "Sign In");
    $("#signup-fields").toggleClass("d-none");
    $("#authForm button").text(isSignIn ? "Sign Up" : "Sign In");
    $(this).text(
      isSignIn
        ? "Already have an account? Sign In"
        : "Don't have an account? Sign Up"
    );
  });

  // Handle form submission (Sign In / Sign Up)
  $("#authForm").submit(function (e) {
    e.preventDefault();

    let action = $("#authAction").val();
    let username = $("#username").val();
    let email = $("#email").val();
    let password = $("#password").val();

    $.ajax({
      url: "user_auth.php",
      type: "POST",
      data: { action, username, email, password },
      dataType: "json",
      success: function (response) {
        console.log("Response received:", response);
        if (response.status === "success") {
          $("#username").text(response.username);
          // $(".user-name").text(`Welcome ${response.username}`);
          $("#sign-in-btn").addClass("d-none");
          $("#sign-out-btn").removeClass("d-none");
          $("#authModal").modal("hide");
        } else {
          alert(response.message);
        }
      },
    });
  });

  // Handle Sign Out
  $("#sign-out-btn").click(function () {
    $.post(
      "user_auth.php",
      { action: "signout" },
      function (response) {
        if (response.status === "success") {
          $("#username").text("Welcome");
          $(".user-name").text("Welcome");
          $("#sign-in-btn").removeClass("d-none");
          $("#sign-out-btn").addClass("d-none");
        }
      },
      "json"
    );
  });
});
