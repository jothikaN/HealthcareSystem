<?php
session_start();
require_once 'connect.php';  // Assumes $con is defined

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the user is logged in as a patient.
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
        header("Location: signin.php");
        exit();
    }
    
    $patient_id = $_SESSION['user_id'];
    $systolic   = $_POST['systolic'];
    $diastolic  = $_POST['diastolic'];
    
    // Compute the status by comparing with thresholds in blood_pressure_data table.
    // This query assumes the patient's reading must fall between systolic_min and systolic_max
    // and between diastolic_min and diastolic_max for a particular threshold.
    $queryStatus = "SELECT status FROM blood_pressure_data 
                    WHERE ? BETWEEN systolic_min AND systolic_max 
                      AND ? BETWEEN diastolic_min AND diastolic_max
                    LIMIT 1";
    $stmtStatus = $con->prepare($queryStatus);
    if (!$stmtStatus) {
        die("Prepare failed (status query): " . $con->error);
    }
    // Assuming systolic and diastolic are integers; if not, use "d" for double.
    $stmtStatus->bind_param("ii", $systolic, $diastolic);
    $stmtStatus->execute();
    $resultStatus = $stmtStatus->get_result();
    if ($resultStatus->num_rows > 0) {
        $rowStatus = $resultStatus->fetch_assoc();
        $status = $rowStatus['status'];
    } else {
        $status = "Undefined";
    }
    $stmtStatus->close();
    
    // Prepare the INSERT statement; recorded_at is set using NOW()
    $sql = "INSERT INTO blood_pressure (patient_id, systolic, diastolic, status, recorded_at)
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Prepare failed (insert query): " . $con->error);
    }
    
    // Bind parameters: "i" for patient_id, "i" for systolic, "i" for diastolic, "s" for status.
    $stmt->bind_param("iiis", $patient_id, $systolic, $diastolic, $status);
    
    if ($stmt->execute()) {
        // After successful insertion, send an email with the blood pressure reading and computed status
        
        // Retrieve the patient's email and name from session (make sure these are set in your login script)
        $to = $_SESSION['email'];
        $first_name = $_SESSION['name'];
        
        $subject = "Your Blood Pressure Reading Result";
        $message = "Hello " . $first_name . ",\n\n" .
                   "Thank you for submitting your blood pressure reading.\n" .
                   "Your recorded blood pressure is:\n" .
                   "Systolic: " . $systolic . " mm Hg\n" .
                   "Diastolic: " . $diastolic . " mm Hg\n\n" .
                   "Based on our records, your status is: " . $status . ".\n\n" .
                   "If you have any questions, please contact our support team.\n\n" .
                   "Best regards,\nYour Healthcare Team";
        $headers = "From: no-reply@yourdomain.com\r\n" .
                   "Reply-To: support@yourdomain.com\r\n" .
                   "X-Mailer: PHP/" . phpversion();
        
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
