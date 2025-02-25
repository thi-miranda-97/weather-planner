<?php
header('Content-Type: application/json'); // Set response header to JSON

if (isset($_GET['city'])) {
  $city = urlencode($_GET['city']); // Encode city name for URL
  $apiKey = '60c7bc4a1c0bb5305afa7174fb72b061'; // Replace with your OpenWeatherMap API key
  $apiUrl = "https://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$apiKey}&units=metric";

  // Fetch weather data
  $response = file_get_contents($apiUrl);
  if ($response === FALSE) {
    echo json_encode(['error' => 'Failed to fetch weather data.']);
    exit;
  }

  $weatherData = json_decode($response, true);

  if ($weatherData['cod'] == 200) {

    // Extract current weather and forecast data
    $currentWeather = [
      'cityName' => $weatherData['city']['name'],
      'localTime' => date('Y/m/d H:i'),
      'temperature' => $weatherData['list'][0]['main']['temp'],
      'weatherDescription' => $weatherData['list'][0]['weather'][0]['description'],
      'pressure' => $weatherData['list'][0]['main']['pressure'],
      'humidity' => $weatherData['list'][0]['main']['humidity'],
      'windSpeed' => $weatherData['list'][0]['wind']['speed']
    ];

    // Extract hourly forecast for the next 4 hours
    $hourlyForecast = [];
    for ($i = 0; $i < 4; $i++) { // Next 4 hours
      $hourlyForecast[] = [
        'time' => date('H:i', strtotime($weatherData['list'][$i]['dt_txt'])), // Time in HH:MM format
        'temperature' => $weatherData['list'][$i]['main']['temp'] // Temperature in °C
      ];
    }


    // Fetch UV index (requires latitude and longitude)
    $lat = $weatherData['city']['coord']['lat'];
    $lon = $weatherData['city']['coord']['lon'];
    $uvUrl = "https://api.openweathermap.org/data/2.5/uvi?lat={$lat}&lon={$lon}&appid={$apiKey}";
    $uvResponse = file_get_contents($uvUrl);
    if ($uvResponse === FALSE) {
      $currentWeather['uvIndex'] = 'N/A'; // UV index not available
    } else {
      $uvData = json_decode($uvResponse, true);
      $currentWeather['uvIndex'] = $uvData['value']; // UV index value
    }




    // Extract tomorrow's weather
    $tomorrowWeather = [
      'date' => date('Y-m-d', strtotime('+1 day')),
      'temperature' => $weatherData['list'][8]['main']['temp'], // 24 hours later
      'weatherDescription' => $weatherData['list'][8]['weather'][0]['description'],
      'pressure' => $weatherData['list'][8]['main']['pressure'],
    ];

    // Extract 7-day forecast
    $fiveDayForecast = [];
    for ($i = 0; $i < count($weatherData['list']); $i += 8) { // Every 24 hours (8 intervals of 3 hours)
      $fivenDayForecast[] = [
        'date' => date('Y-m-d', strtotime($weatherData['list'][$i]['dt_txt'])),
        'temperature' => $weatherData['list'][$i]['main']['temp'],
        'weatherDescription' => $weatherData['list'][$i]['weather'][0]['description'],
        'pressure' => $weatherData['list'][$i]['main']['pressure'],
        'windSpeed' => $weatherData['list'][$i]['wind']['speed'],
        'humidity' => $weatherData['list'][$i]['main']['humidity'],
      ];
    }

    // Prepare response
    $result = [
      'currentWeather' => $currentWeather,
      'tomorrowWeather' => $tomorrowWeather,
      'sevenDayForecast' => $fivenDayForecast,
      'hourlyForecast' => $hourlyForecast,
    ];
    echo json_encode($result); // Return JSON data
  } else {
    echo json_encode(['error' => 'City not found.']);
  }
} else {
  echo json_encode(['error' => 'Please enter a city name.']);
}
