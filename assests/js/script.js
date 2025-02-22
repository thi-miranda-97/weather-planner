$(document).ready(function () {
    let city = "New York"; // Default city

    function fetchWeather(city) {
        $.ajax({
            url: "api/getWeather.php",
            method: "GET",
            data: { city: city },
            success: function (response) {
                if (response.error) {
                    $("#weather").html(`<p class="text-danger">${response.error}</p>`);
                } else {
                    let temp = response.main.temp;
                    let condition = response.weather[0].description;
                    let icon = response.weather[0].icon;
                    
                    $("#weather").html(`
                        <h3>Weather in ${city}</h3>
                        <p>${condition}, ${temp}°C</p>
                        <img src="https://openweathermap.org/img/wn/${icon}.png" alt="Weather Icon">
                    `);
                }
            }
        });
    }

    // Fetch weather on page load
    fetchWeather(city);

    // Change city on user input
    $("#search-btn").click(function () {
        let newCity = $("#city-input").val().trim();
        if (newCity) fetchWeather(newCity);
    });
});
