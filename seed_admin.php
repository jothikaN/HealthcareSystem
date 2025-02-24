<?php
echo "Script running";
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'connect.php'; // Make sure this file defines $con

$adminUsername = 'admin';
$adminEmail    = 'admin@example.com';
$adminPassword = password_hash('Admin@123', PASSWORD_DEFAULT);
$adminRole     = 'admin';

// Use $con instead of $conn
$checkAdminQuery = "SELECT * FROM `user` WHERE email = '$adminEmail' LIMIT 1";
$checkAdmin      = $con->query($checkAdminQuery);

if ($checkAdmin->num_rows === 0) {
    $insertAdmin = "INSERT INTO `user` (name, email, password, role)
                    VALUES ('$adminUsername', '$adminEmail', '$adminPassword', '$adminRole')";
    if ($con->query($insertAdmin)) {
        echo "<br>Admin user created successfully!";
    } else {
        echo "<br>Error: " . $con->error;
    }
} else {
    echo "<br>Admin already exists!";
}
?>
