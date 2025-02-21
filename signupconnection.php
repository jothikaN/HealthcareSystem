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

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $conn->real_escape_string(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($name) && !empty($email) && !empty($password)) {
        $check_stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            echo "Email already registered!";
            // Redirect to signin.php
            header("Location: signin.php");
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                // Redirect to signin.php
                header("Location: signin.php");
                exit(); // Prevent further execution
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $check_stmt->close();
    } else {
        echo "Please fill in all fields.";
    }
}
