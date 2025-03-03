# Weather-Planner 🌦️

**Weather-Planner** is a full-stack web application that combines weather forecasting with task management. Users can search for weather conditions in any city, view detailed forecasts, and manage their tasks based on the weather. Built with **PHP**, **JavaScript**, **jQuery**, **Bootstrap**, and **MySQL**, this project demonstrates my skills in front-end and back-end development, API integration, and database management.

---

## Features ✨

### Weather Features

- **Search for Weather**: Enter a city name to get real-time weather data, including temperature, humidity, wind speed, and UV index.
- **5-Day Forecast**: View a detailed 5-day weather forecast with interactive charts.
- **Weather Alerts**: Get dynamic weather-related messages (e.g., "High UV index detected. Use sunscreen!").

### Task Management Features

- **Add Tasks**: Create tasks with a title, due date, and tag.
- **Edit/Delete Tasks**: Update or remove tasks as needed.
- **Task Progress**: Track your task completion progress with a visual progress bar.
- **User Authentication**: Sign up, log in, and manage your tasks securely.

---

## Technologies Used

- **Front-End**: HTML, CSS, JavaScript, jQuery, Bootstrap
- **Back-End**: PHP, MySQL
- **APIs**: OpenWeather API (for weather data)
- **Other Tools**: Chart.js (for weather charts), Git (for version control)

---

## Screenshots

### Home Page

---

## Installation

### Prerequisites

- A web server (e.g., XAMPP, WAMP, or Laravel Homestead). I used XAMPP
- PHP 7.0 or higher
- MySQL
- OpenWeather API key (get it from [OpenWeather](https://openweathermap.org/api))

### Steps

1. **Clone the Repository**:

   ```bash
   git clone https://github.com/your-username/weather-planner.git
   cd weather-planner
   ```

2. **Set Up the Database**:

   - Import the `weather_planner.sql` file (located in the `database` folder) into your MySQL server.
   - Update the database credentials in `db.php`:
     ```php
     $host = 'localhost';
     $dbname = 'weather_planner';
     $username = 'your-db-username';
     $password = 'your-db-password';
     ```

3. **Set Up the OpenWeather API**:

   - Replace the placeholder in `getWeatherapi.php` with your OpenWeather API key:
     ```php
     $apiKey = 'your-openweather-api-key';
     ```

4. **Run the Application**:
   - Move the project folder to your web server's root directory (e.g., `htdocs` for XAMPP).
   - Open your browser and navigate to:  
     `http://localhost/weather-planner/index.php`

---

## How It Works

### Weather Search

- Enter a city name in the search bar to fetch real-time weather data and a 5-day forecast.
- Weather data is displayed using interactive charts powered by Chart.js.

### Task Management

- Sign up or log in to manage your tasks.
- Add, edit, or delete tasks with due dates and tags.
- Track your progress with a visual progress bar.

### User Authentication

- Users can sign up, log in, and log out securely.
- User data (e.g., tasks, preferences) is stored in a MySQL database.

---

## Future Enhancements

- **Weather-Based Task Suggestions**: Automatically suggest tasks based on weather conditions (e.g., "It's sunny! Schedule an outdoor activity.").
- **Mobile App**: Develop a mobile version of the app using React Native or Flutter.
- **Email Notifications**: Send weather alerts and task reminders via email.

---

## Contributing

Contributions are welcome! If you'd like to contribute, please follow these steps:

1. Fork the repository.
2. Create a new branch:
   ```bash
   git checkout -b feature/your-feature
   ```
3. Commit your changes:
   ```bash
   git commit -m 'Add some feature'
   ```
4. Push to the branch:
   ```bash
   git push origin feature/your-feature
   ```
5. Open a pull request.

---

## License

This project is licensed under the MIT License. See the (LICENSE) file for details.

---

## Contact 📧

If you have any questions or feedback, feel free to reach out:

- **Email**: thimiranda97@gmail.com
