<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'connect.php'; // Ensure this file correctly initializes $con

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Invalid email format!";
        $_SESSION['message_type'] = "error";
        header("Location: signin.php");
        exit();
    }

    // Check database connection
    if (!$con) {
        $_SESSION['message'] = "Database connection error!";
        $_SESSION['message_type'] = "error";
        header("Location: signin.php");
        exit();
    }

    // Prepare statement
    $sql = "SELECT * FROM `user` WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            $_SESSION['message'] = "Login successful! Welcome, " . htmlspecialchars($user['name']);
            $_SESSION['message_type'] = "success"; 

            // Redirect based on role
            $redirect_page = ($user['role'] === 'admin') ? "admin_dashboard.php" : "patient_dashboard.php";
            header("Location: $redirect_page");
            exit();
        } else {
            $_SESSION['message'] = "Invalid Password.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "User not found!";
        $_SESSION['message_type'] = "error";
    }

    // Close statement
    $stmt->close();

    // Redirect to signin page with message
    header("Location: signin.php");
    exit();
}
?>
