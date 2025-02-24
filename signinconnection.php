<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'connect.php'; // This file defines $con

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM `user` WHERE email = '$email'";
    $result = $con->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: patient_dashboard.php");
            }
            exit; // Ensure script stops executing after the redirect
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
}
?>
