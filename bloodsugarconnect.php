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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if $con is defined
    if (!isset($con)) {
        die("Database connection error.");
    }

    // Form data fetch
    $sugar_range = mysqli_real_escape_string($con, $_POST['sugar_range']);
    $types = mysqli_real_escape_string($con, $_POST['types']);
    $level_type = mysqli_real_escape_string($con, $_POST['level_type']);

   

    // Insert Query
    $sqlInsert = "INSERT INTO blood_sugar_details (types, level_type, sugar_range, patient_id) 
                  VALUES ('$types', '$level_type', '$range', '$patient_id')";

    if (mysqli_query($con, $sqlInsert)) {
        echo "<script>alert('Data inserted successfully!'); window.location.href='index.php?pg=bloodsugardetails.php&option=view';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "'); window.history.back();</script>";
    }

    // Close Connection
    mysqli_close($con);
} else {
    echo "<script>window.location.href='index.php';</script>";
}
