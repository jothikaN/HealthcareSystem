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

// Collect form data with error handling
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : null;
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : null;
$age = isset($_POST['age']) ? $_POST['age'] : null;
$mobile_number = isset($_POST['mobile_number']) ? $_POST['mobile_number'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$address = isset($_POST['address']) ? $_POST['address'] : null;
$nic_no = isset($_POST['nic_no']) ? $_POST['nic_no'] : null;
$dob = isset($_POST['dob']) ? $_POST['dob'] : null;
$hiredate = isset($_POST['hiredate']) ? $_POST['hiredate'] : null;
$gender = isset($_POST['gender']) ? $_POST['gender'] : null;
$role = isset($_POST['role']) ? $_POST['role'] : null;

// Insert data using prepared statements
$sql = "INSERT INTO staff (first_name, last_name, age, mobile_number, email, address, nic_no, dob, hiredate, gender, role)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind parameters
    $stmt->bind_param(
      "ssissssssss",
        $first_name, $last_name, $age, $mobile_number, $email, $address,
        $nic_no, $dob, $hiredate, $gender, $role
    );

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