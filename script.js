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
            const localTime = response.currentWeather.localTime.split("|");

            const currentHtml = generateWeatherHTML(
              "today",
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

  function generateWeatherHTML(id, date, time, weather, hourlyForecast) {
    return `
  <section id="${id}" class="weather-showcase container-fluid">
    <div class="col row temp-col">
      <div id="current-weather">
        <div class="d-flex gap-2">
          <p>${date}</p>
          <p>${time}</p>
        </div>
        <div>
          <p class="temp">${weather.temperature}&deg;C</p>
          <p>${weather.weatherDescription}</p>
        </div>
        <div class="weather-description d-flex">
          <div class="flex-grow-1">
            <p><i class="bi bi-water"></i> ${weather.pressure} hPa</p>
            <p><i class="bi bi-droplet-half"></i> ${weather.humidity}%</p>
          </div>
          <div class="flex-grow-1">
            <p><i class="bi bi-wind"></i> ${weather.windSpeed} m/s</p>
            <p><i class="bi bi-brightness-low"></i> ${weather.uvIndex}</p>
          </div>
        </div>
      </div>
      <div class="col">
        <h3 style="text-align: center;">Forecast</h3>
        <canvas id="hourlyForecastChart" aria-label="Hourly Forecast Line Chart" role="img"></canvas>
      </div>
    </div>
  </section>`;
  }

  function generateForecastHTML(forecast) {
    let forecastHtml = `<section id="next-days" class="weather-showcase hidden container-fluid d-flex justify-content-between">`;

    forecast.forEach((day) => {
      let weatherCondition = day.weatherDescription?.toLowerCase() || "default";
      let weatherIcon = generateWeatherIcon(weatherCondition);

      // Mapping weather conditions to CSS variables
      const weatherColors = {
        "clear sky": "var(--blue)",
        "few clouds": "var(--blue)",
        "scattered clouds": "var(--yellow)",
        "broken clouds": "var(--yellow)",
        "shower rain": "var(--green)",
        "light rain": "var(--green)",
        rain: "var(--green)",
        thunderstorm: "var(--green)",
        snow: "var(--red)",
        mist: "var(--red)",
        default: "var(--background-color)", // Fallback to default theme background
      };

      // Use CSS variables for background color
      let backgroundColor =
        weatherColors[weatherCondition] || weatherColors["default"];

      forecastHtml += `
        <div class="card" style="background-color: ${backgroundColor};">
          <p>${day.day}</p>
          <div class="icon-container">
            <div>
              <p class="temp">${day.temperature}&deg;C</p>
              <p  style="text-align: center;">${day.weatherDescription}</p>
            </div>
            ${weatherIcon}
          </div>
          <div class="card-content">
            <div class="row">
              <p><i class="bi bi-water"></i> ${day.pressure} hPa</p>
              <p><i class="bi bi-droplet-half"></i> ${day.humidity}%</p>
            </div>
            <div class="row">
              <p><i class="bi bi-wind"></i> ${day.windSpeed} m/s</p>
              <p><i class="bi bi-brightness-low"></i> ${day.uvIndex}</p>
            </div>
          </div>
        </div>`;
    });

    forecastHtml += `</section>`;
    return forecastHtml;
  }

  function generateWeatherIcon(condition) {
    const iconMap = {
      "clear sky": "bi-brightness-high",
      "few clouds": "bi-cloud-sun",
      "scattered clouds": "bi-clouds",
      "broken clouds": "bi-cloud-haze2",
      "shower rain": "bi-cloud-drizzle",
      "light rain": "bi-cloud-drizzle",
      rain: "bi-cloud-rain",
      thunderstorm: "bi-cloud-lightning",
      snow: "bi-cloud-snow",
      mist: "bi-cloud-fog",
    };

    // Default to 'bi-cloud' if no match found
    return `<i class="bi ${
      iconMap[condition] || "bi-cloud"
    }" style="font-size: 6.4rem;"></i>`;
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
      data: {
        action,
        username,
        email,
        password,
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          localStorage.setItem("username", response.username);
          $("#user-name").text(response.username);
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
      {
        action: "signout",
      },
      function (response) {
        if (response.status === "success") {
          localStorage.removeItem("username");
          $("#user-name").text("Guest");
          $("#sign-in-btn").removeClass("d-none");
          $("#sign-out-btn").addClass("d-none");
        }
      },
      "json"
    );
  });

  // Open Add Task Modal when Add Task button is clicked
  $("#addTaskBtn").on("click", function () {
    $("#taskForm")[0].reset();
    $("#taskId").val("");
    $("#taskModal").modal("show");
  });

  // Fetch tasks for the user
  function fetchTasks() {
    $.post(
      "tasks.php",
      { action: "fetch" },
      function (response) {
        if (response.status === "success") {
          $("#taskList").empty();
          response.tasks.forEach(function (task) {
            const taskItem = `
            <li class="list-group-item align-items-center" id="task-${task.id}">
            <div>
                <input class="form-check-input me-1" type="checkbox" value="" id="checkbox1">
                <label class="form-check-label" for="checkbox-${task.id}">${task.task}</label>
              </div>
              
              <span>${task.due_date}</span>
              <span>${task.tag}</span>
              
              <div class="btn-group">
                <button class="btn btn-info editTaskBtn" data-task-id="${task.id}">Edit</button>
                <button class="btn btn-danger deleteTaskBtn" data-task-id="${task.id}">Delete</button>
              </div>
            </li>`;
            $("#taskList").append(taskItem);
          });
        } else {
          alert(response.message);
        }
      },
      "json"
    );
  }

  // Handle Task Form Submission
  $("#taskForm").submit(function (e) {
    e.preventDefault();
    const taskId = $("#taskId").val();
    const taskName = $("#taskName").val();
    const dueDate = $("#dueDate").val();
    const taskTag = $("#taskTag").val();

    const action = taskId ? "update" : "add";

    console.log("Submitting task:", {
      action,
      taskId,
      taskName,
      dueDate,
      taskTag,
    }); // Debugging

    $.post(
      "tasks.php",
      {
        action: action,
        taskId: taskId,
        taskName: taskName,
        dueDate: dueDate,
        taskTag: taskTag,
      },
      function (response) {
        console.log("Server response:", response); // Debugging
        if (response.status === "success") {
          $("#taskModal").modal("hide");
          fetchTasks();
        } else {
          alert(response.message);
        }
      },
      "json"
    );
  });

  // Edit task (Event Delegation)
  $(document).on("click", ".editTaskBtn", function () {
    const taskId = $(this).data("task-id");
    console.log("Fetching task with ID:", taskId);
    $.post(
      "tasks.php",
      { action: "fetch", taskId: taskId },
      function (response) {
        console.log("Server response:", response); // Debugging
        if (response.status === "success") {
          const task = response.task;
          if (task) {
            console.log(task.id);
            $("#taskId").val(task.id);

            $("#taskName").val(task.task);
            $("#dueDate").val(task.due_date);
            $("#taskTag").val(task.tag);
            $("#taskModal").modal("show");
          } else {
            alert("Task not found.");
          }
        } else {
          alert(response.message);
        }
      },
      "json"
    );
  });

  // Delete task (Event Delegation)
  $(document).on("click", ".deleteTaskBtn", function () {
    const taskId = $(this).data("task-id");

    if (confirm("Are you sure you want to delete this task?")) {
      $.post(
        "tasks.php",
        { action: "delete", taskId: taskId },
        function (response) {
          if (response.status === "success") {
            $(`#task-${taskId}`).remove();
          } else {
            alert(response.message);
          }
        },
        "json"
      );
    }
  });

  // Initial fetch of tasks
  fetchTasks();
});
