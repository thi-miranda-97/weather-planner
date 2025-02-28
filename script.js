$(document).ready(function () {
  let hourlyForecastChart = null;

  // Initial setup
  initializeUserState();
  attachEventHandlers();

  // Function to initialize user state
  function initializeUserState() {
    const username = localStorage.getItem("username");
    const currentTheme = $("body").attr("data-theme");
    const themeIcon =
      currentTheme === "light" ? "bi-brightness-high" : "bi-moon";
    $("#themee-icon").removeClass("bi-sun bi-moon").addClass(themeIcon);

    if (username) {
      $("#user-name").text(username);
      $("#sign-in-btn").addClass("d-none");
      $("#sign-out-btn").removeClass("d-none");
      $("#task-section").show();
      fetchUserPreferences();
      fetchTasks();
    } else {
      $("#user-name").text("Guest");
      $("#sign-in-btn").removeClass("d-none");
      $("#sign-out-btn").addClass("d-none");
      $("#task-section").hide();
    }
  }

  // Function to attach event handlers
  function attachEventHandlers() {
    $("#sign-in-btn").click(showAuthModal);
    $("#toggleAuth").click(toggleAuthMode);
    $("#authForm").submit(handleAuthFormSubmission);
    $("#sign-out-btn").click(handleSignOut);
    $("#addTaskBtn").click(showAddTaskModal);
    $("#taskForm").submit(handleTaskFormSubmission);
    $(document).on("click", ".editTaskBtn", handleEditTask);
    $(document).on("click", ".deleteTaskBtn", handleDeleteTask);
    $("#authModal").on("shown.bs.modal", removeAriaHidden);
    $("#authModal").on("hidden.bs.modal", addAriaHidden);
    $("#weatherForm").on("submit", handleWeatherFormSubmission);
    $("#theme-toggle").on("click", toggleTheme);
    $(document).on("click", "#next-days .card", handleCardClick);
    $(".nav-link").on("click", handleNavLinkClick);
  }

  // Event handler functions
  function showAuthModal() {
    $("#authModal").modal("show");
  }

  function toggleAuthMode(e) {
    e.preventDefault();
    const isSignIn = $("#authAction").val() === "signin";
    $("#authAction").val(isSignIn ? "signup" : "signin");
    $("#authModalLabel").text(isSignIn ? "Sign Up" : "Sign In");
    $("#signup-fields").toggleClass("d-none");
    $("#authForm button").text(isSignIn ? "Sign Up" : "Sign In");
    $(this).text(
      isSignIn
        ? "Already have an account? Sign In"
        : "Don't have an account? Sign Up"
    );
  }

  function handleAuthFormSubmission(e) {
    e.preventDefault();
    const action = $("#authAction").val();
    const username = $("#username").val();
    const email = $("#email").val();
    const password = $("#password").val();
    $.ajax({
      url: "user_auth.php",
      type: "POST",
      data: { action, username, email, password },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          localStorage.setItem("username", response.username);
          $("#user-name").text(response.username);
          $("#sign-in-btn").addClass("d-none");
          $("#sign-out-btn").removeClass("d-none");
          $("#authModal").modal("hide");
          $("#task-section").show();
          $("#taskList").show();
          fetchUserPreferences();
        } else {
          alert(response.message);
        }
      },
    });
  }

  function handleSignOut() {
    $.post(
      "user_auth.php",
      { action: "signout" },
      function (response) {
        if (response.status === "success") {
          localStorage.removeItem("username");
          $("#user-name").text("Guest");
          $("#sign-in-btn").removeClass("d-none");
          $("#sign-out-btn").addClass("d-none");
          $("#task-section").hide();
          $("#taskList").empty();
          $("#current-city").text("");
          $("#weatherResult").empty();
          $("#weather-message").addClass("d-none");
          $("#weather-message-1").text("");
          $("#weather-message-2").text("");
          $("body").attr("data-theme", "light");
        } else {
          alert(response.message);
        }
      },
      "json"
    );
  }

  function showAddTaskModal() {
    $("#taskForm")[0].reset();
    $("#taskId").val("");
    $("#taskModal").modal("show");
  }

  function handleTaskFormSubmission(e) {
    e.preventDefault();
    const taskId = $("#taskId").val();
    const taskName = $("#taskName").val();
    const dueDate = $("#dueDate").val();
    const taskTag = $("#taskTag").val();
    const action = taskId ? "update" : "add";
    $.post(
      "tasks.php",
      { action, taskId, taskName, dueDate, taskTag },
      function (response) {
        if (response.status === "success") {
          $("#taskModal").modal("hide");
          fetchTasks();
        } else {
          alert(response.message);
        }
      },
      "json"
    );
  }

  function handleEditTask() {
    const taskId = $(this).data("task-id");
    $.post(
      "tasks.php",
      { action: "fetch", taskId },
      function (response) {
        if (response.status === "success") {
          const task = response.task;
          if (task) {
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
  }

  function handleDeleteTask() {
    const taskId = $(this).data("task-id");
    if (confirm("Are you sure you want to delete this task?")) {
      $.post(
        "tasks.php",
        { action: "delete", taskId },
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
  }

  function removeAriaHidden() {
    $(this).removeAttr("aria-hidden");
    $(this).removeAttr("inert");
  }

  function addAriaHidden() {
    $(this).attr("aria-hidden", "true");
    $(this).attr("inert", "");
  }

  function handleWeatherFormSubmission(e) {
    e.preventDefault();
    const city = $("#city").val();
    fetchWeather(city);
  }

  function toggleTheme() {
    const currentTheme = $("body").attr("data-theme");
    const newTheme = currentTheme === "light" ? "dark" : "light";
    $("body").attr("data-theme", newTheme);

    const themeIcon = newTheme === "light" ? "bi-sun" : "bi-moon";
    $("#theme-icon").removeClass("bi-sun bi-moon").addClass(themeIcon);

    $.post(
      "user_auth.php",
      { action: "update_preferences", theme: newTheme },
      function (response) {
        if (response.status !== "success") {
          alert("Failed to save theme preference.");
        }
      },
      "json"
    );
  }

  function handleCardClick() {
    $("#next-days .card").removeClass("active");
    $(this).addClass("active");
  }

  function handleNavLinkClick(e) {
    e.preventDefault();
    togglePage($(this).data("target"));
  }

  // Fetch tasks for the user
  function fetchTasks() {
    $.post(
      "tasks.php",
      { action: "fetch" },
      function (response) {
        if (response.status === "success") {
          $("#taskList").empty();
          let totalTasks = response.tasks.length;
          let completedTasks = 0;

          response.tasks.forEach(function (task) {
            if (task.completed) {
              completedTasks++;
            }
            const taskItem = `
            <li class="list-group-item align-items-center" id="task-${task.id}">
              <div>
                <input class="form-check-input me-1" type="checkbox" value="" id="checkbox-${
                  task.id
                }" ${task.completed ? "checked" : ""}>
                <label class="form-check-label" for="checkbox-${task.id}">${
              task.task
            }</label>
              </div>
              <span>${task.due_date}</span>
              <span>${task.tag}</span>
              <div class="btn-group">
                <button class="btn btn-info editTaskBtn" data-task-id="${
                  task.id
                }">Edit</button>
                <button class="btn btn-danger deleteTaskBtn" data-task-id="${
                  task.id
                }">Delete</button>
              </div>
            </li>`;
            $("#taskList").append(taskItem);
          });

          // Update progress bar and text
          let progressPercentage =
            totalTasks > 0 ? (completedTasks / totalTasks) * 100 : 0;
          $(".progress-bar")
            .css("width", `${progressPercentage}%`)
            .text(`${Math.round(progressPercentage)}%`);
          $("#progress-text").text(
            `${completedTasks} out of ${totalTasks} tasks completed`
          );
        } else {
          alert(response.message);
        }
      },
      "json"
    );
  }

  $(document).on("change", ".form-check-input", function () {
    const taskId = $(this).attr("id").split("-")[1];
    const completed = $(this).is(":checked") ? 1 : 0;

    $.post(
      "tasks.php",
      { action: "update_completion", taskId: taskId, completed: completed },
      function (response) {
        if (response.status === "success") {
          fetchTasks();
        } else {
          alert(response.message);
        }
      },
      "json"
    );
  });

  // Fetch user preferences (city and theme)
  function fetchUserPreferences() {
    $.post(
      "user_auth.php",
      { action: "get_preferences" },
      function (response) {
        if (response.status === "success") {
          $("#current-city").text(response.city);
          $("body").attr("data-theme", response.theme);
          fetchWeather(response.city);
          fetchTasks();
        } else {
          console.error("Failed to fetch user preferences:", response.message);
        }
      },
      "json"
    );
  }

  // Fetch weather for a given city
  function fetchWeather(city) {
    if (city) {
      $("#loading").removeClass("d-none");
      $.ajax({
        url: "getWeatherapi.php",
        type: "GET",
        data: { city },
        dataType: "json",
        success: function (response) {
          $("#loading").addClass("d-none");
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

            const weatherMessages = generateWeatherMessage(
              response.currentWeather
            );
            if (weatherMessages.length > 0) {
              $("#weather-message").removeClass("d-none");
              $("#weather-message-1").text(weatherMessages[0] || "");
              $("#weather-message-2").text(weatherMessages[1] || "");
            } else {
              $("#weather-message").addClass("d-none");
              $("#weather-message-1").text("");
              $("#weather-message-2").text("");
            }

            $.post(
              "user_auth.php",
              { action: "save_city", city: response.currentWeather.cityName },
              function (saveResponse) {
                if (saveResponse.status !== "success") {
                  console.error("Failed to save city:", saveResponse.message);
                }
              },
              "json"
            );
          }
        },
        error: function () {
          $("#loading").addClass("d-none");
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
  }

  // Utility functions
  function togglePage(id) {
    $("#today, #next-days").each(function () {
      $(this).toggleClass("hidden", this.id !== id);
    });
    $(".nav-link").each(function () {
      $(this).toggleClass("active", $(this).data("target") === id);
    });
  }

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
        <div id="weather-message" class="d-none">
            <div id="weather-message-1"></div>
           <div id="weather-message-2"></div>
        </div>
    
      </section>`;
  }

  function generateForecastHTML(forecast) {
    let forecastHtml = `<section id="next-days" class="weather-showcase hidden container-fluid d-flex justify-content-between">`;
    forecast.forEach((day) => {
      const weatherCondition =
        day.weatherDescription?.toLowerCase() || "default";
      const weatherIcon = generateWeatherIcon(weatherCondition);
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
        default: "var(--background-color)",
      };
      const backgroundColor =
        weatherColors[weatherCondition] || weatherColors["default"];
      forecastHtml += `
        <div class="card" style="background-color: ${backgroundColor};">
          <p>${day.day}</p>
          <div class="icon-container">
            <div>
              <p class="temp">${day.temperature}&deg;C</p>
              <p style="text-align: center;">${day.weatherDescription}</p>
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

  function generateWeatherMessage(weather) {
    let messages = [];

    // Check for high UV index
    if (weather.uvIndex >= 5) {
      messages.push(
        "High UV index detected. Cover your body and use sunscreen."
      );
    }

    // Check for rain
    if (weather.weatherDescription.toLowerCase().includes("rain")) {
      messages.push("It's raining. Don't forget your umbrella!");
    }
    if (weather.weatherDescription.toLowerCase().includes("snow")) {
      messages.push(
        "Snow Incoming! ☃️ Heavy snowfall is expected today. Drive carefully and wear warm layers!"
      );
    }
    if (weather.weatherDescription.toLowerCase().includes("fog")) {
      messages.push(
        "Fog Advisory! 🌫️ Low visibility on the roads. Drive carefully and use fog lights if needed."
      );
    }

    // Check for high temperature
    if (weather.temperature > 30) {
      messages.push(
        "It's hot outside. Stay hydrated and avoid prolonged sun exposure."
      );
    }

    // Check for low temperature
    if (weather.temperature < 10) {
      messages.push("It's cold outside. Dress warmly and stay cozy!");
    }

    // Check for strong winds
    if (weather.windSpeed > 10) {
      messages.push("Strong winds detected. Be cautious outdoors.");
    }

    if (messages.length === 0) {
      messages.push(
        "The weather is good today. It's a great day for outdoor activities!"
      );
    }

    // Ensure there are at least two messages
    if (messages.length < 2) {
      messages.push(
        "Mild and Cozy! 🌤️ Not too hot, not too cold—just the right weather to relax outside."
      );
    }

    return messages;
  }

  // Initial fetch of tasks
  fetchTasks();
});
