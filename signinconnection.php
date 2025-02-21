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
if ($_SERVER["REQUEST_METHOD"] == "POST")
   
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($name) && !empty($email) && !empty($password)) {
        // Check if email already exists
        $check_stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            echo "Email already registered!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            echo "Hashed Password (Before Saving): $hashed_password<br>"; // Debugging Output

            // Save user data into the database
            $stmt = $conn->prepare("INSERT INTO user ( email, password) VALUES ( ?, ?)");
            $stmt->bind_param("ss" , $email, $hashed_password);

            if ($stmt->execute()) {
                echo "Signup successful! You can now log in.";
                header("Location: signin.php");
                exit(); // Ensure no further code executes after redirect
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
      
    }


$conn->close();
?>