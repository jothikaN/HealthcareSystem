<?php
session_start();
require_once 'connect.php';  // Assumes $con is defined

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the user is logged in as a patient.
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
        header("Location: signin.php");
        exit();
    }
    
    // Retrieve patient data from session and form POST
    $patient_id  = $_SESSION['user_id'];
    $blood_sugar = $_POST['blood_sugar'];
    $type        = $_POST['type']; // 1 = Fasting, 2 = Post Prandial

    // Compute the status based on thresholds from blood_sugar_data table.
    $queryStatus = "SELECT status FROM blood_sugar_data WHERE ? BETWEEN min_value AND max_value AND type = ? LIMIT 1";
    $stmtStatus = $con->prepare($queryStatus);
    if (!$stmtStatus) {
        die("Prepare failed (status query): " . $con->error);
    }
    // Bind parameters: "d" for blood_sugar (decimal) and "i" for type.
    $stmtStatus->bind_param("di", $blood_sugar, $type);
    $stmtStatus->execute();
    $resultStatus = $stmtStatus->get_result();
    
    if ($resultStatus->num_rows > 0) {
        $rowStatus = $resultStatus->fetch_assoc();
        $status = $rowStatus['status'];
    } else {
        $status = "Undefined";
    }
    $stmtStatus->close();
    
    // Prepare the INSERT statement; recorded_at is set automatically using NOW()
    $sql = "INSERT INTO blood_sugar (patient_id, blood_sugar, status, recorded_at, type)
            VALUES (?, ?, ?, NOW(), ?)";
    
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Prepare failed (insert query): " . $con->error);
    }
    
    // patient_id: integer, blood_sugar: double, status: string, type: integer
    // If patient_id is an integer and blood_sugar is a double, the format should be "idsi"
    $stmt->bind_param("idsi", $patient_id, $blood_sugar, $status, $type);
    
    if ($stmt->execute()) {
        // After successful insertion, send email

        // Retrieve the patient's email and name from session
        $to         = $_SESSION['email'];  // Make sure your login script sets this
        $first_name = $_SESSION['name'];   // Similarly, store the patient's name
        
        $subject = "Your Blood Sugar Reading Result";
        $message = "Hello " . $first_name . ",\n\n" .
                   "Thank you for submitting your blood sugar reading.\n" .
                   "Your recorded blood sugar is " . $blood_sugar . " mg/dL, which is considered: " . $status . ".\n\n" .
                   "If you have any questions, please contact our support team.\n\n" .
                   "Best regards,\nYour Healthcare Team";
        $headers = "From: no-reply@yourdomain.com\r\n" .
                   "Reply-To: support@yourdomain.com\r\n" .
                   "X-Mailer: PHP/" . phpversion();
        
        // Send email
        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['message'] = "Your reading was submitted and an email has been sent.";
        } else {
            $_SESSION['message'] = "Reading submitted, but email could not be sent.";
            error_log("Failed to send email to $to");
        }
        
        header("Location: patient_dashboard.php");
        exit();
    } else {
        echo "Error executing statement: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Invalid request method.";
}

$con->close();
?>
