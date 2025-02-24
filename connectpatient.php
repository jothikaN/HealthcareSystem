<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'connect.php'; // Ensure this file sets up $con correctly

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Collect form data
$first_name    = $_POST['first_name'];
$last_name     = $_POST['last_name'];
$age           = $_POST['age'];
$mobile_number = $_POST['mobile_number'];
$email         = $_POST['email'];
$address       = $_POST['address'];
$nic_no        = $_POST['nic_no'];
$dob           = $_POST['dob'];
$gender        = $_POST['gender'];
$weight        = $_POST['weight'];
$height        = $_POST['height'];

// INSERT query that includes the user_id column
$sql = "INSERT INTO patient_details (user_id, first_name, last_name, age, mobile_number, email, address, nic_no, dob, gender, weight, height)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare statement
$stmt = $con->prepare($sql);

if ($stmt) {
    // Bind parameters:
    // "i" for user_id (integer), "s" for strings, "i" for age, "d" for weight and height (double)
    $stmt->bind_param("ississssssdd", $user_id, $first_name, $last_name, $age, $mobile_number, $email, $address, $nic_no, $dob, $gender, $weight, $height);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record inserted successfully.";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $con->error;
}

// Close the database connection
$con->close();
?>
 