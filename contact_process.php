<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "healthcare_management_system";

// Create connection
$conn = new mysqli('localhost','root','','healthcare_management_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Initialize a variable to store the notification message
    $notification = "";

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $message = $_POST['message'];

    // Sanitize input to prevent SQL injection
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $city = $conn->real_escape_string($city);
    $message = $conn->real_escape_string($message);

    // Insert data into the database
    $sql = "INSERT INTO contact (name, email, city, message) VALUES ('$name', '$email', '$city', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Set success notification
        $notification = "Your message has been sent and saved successfully!";
    } else {
        // Set error notification
        $notification = "Error: " . $sql . "<br>" . $conn->error;
}

}
// Close connection
$conn->close();
?>