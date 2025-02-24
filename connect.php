<?php

// Database connection details
$servername = "localhost";
$username = "root"; // Change if your MySQL username is different
$password = ""; // Change if you have set a MySQL password
$dbname = "healthcare_management_system";

// Create connection
$con = new mysqli($servername,$username,$password,$dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$con->commit();


?>