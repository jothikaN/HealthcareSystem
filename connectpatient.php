<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Change if your MySQL username is different
$password = ""; // Change if you have set a MySQL password
$dbname = "healthcare_management_system";

// Create connection
$conn = new mysqli('localhost','root','','healthcare_management_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$age = $_POST['age'];
$mobile_number = $_POST['mobile_number'];
$email = $_POST['email'];
$address = $_POST['address'];
$nic_no = $_POST['nic_no'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$weight = $_POST['weight'];
$height = $_POST['height'];

// Insert data using prepared statements
$sql = "INSERT INTO patient (first_name,last_name,age, mobile_number,email,address, nic_no, dob, gender,weight,height)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind parameters
    $stmt->bind_param("ssiisssssdd", $first_name, $last_name, $age, $mobile_number, $email, $address, $nic_no, $dob, $gender, $weight, $height);

    // Execute the query
    if ($stmt->execute()) {
        echo "New record inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close the connection
$conn->close();

?>