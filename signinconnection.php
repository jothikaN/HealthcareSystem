<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'connect.php'; // This file defines $con

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM `user` WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            
            $_SESSION['message'] = "Login successful! Welcome, " . $user['name'];
            $_SESSION['message_type'] = "success"; // Used for Toastr type
            
            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: patient_dashboard.php");
            }
            exit;
        } else {
            $_SESSION['message'] = "Invalid Password.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "User not found!";
        $_SESSION['message_type'] = "error";
    }
    $stmt->close();
    header("Location: login.php");
    exit;
}
?>
