<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "healthcare_management_system";

// Create connection
$conn = new mysqli('localhost','root','','healthcare_management_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form data fetch
    $diastolic_range = $_POST['diastolic_range'];
    $systolic_range = $_POST['systolic_range'];

    // Prepare SQL statement (Fix: Use backticks for column names)
    $stmt = $conn->prepare("INSERT INTO blood_pressure_details (`diastolic_range`, `systolic_range`) VALUES (?, ?)");

    // Bind Parameters (Fix: Two parameters needed)
    $stmt->bind_param("ss", $diastolic_range, $systolic_range);

    // Execute Query
    if ($stmt->execute()) {
        echo "<script>alert('Data inserted successfully!'); window.location.href='index.php?pg=bloodpressuredetails.php&option=view';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    // Close Statement & Connection
    $stmt->close();
    $conn->close();
} else {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}
?>