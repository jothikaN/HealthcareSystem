<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

if (isset($_GET['id'])) {
    $patientId = $_GET['id'];
    $stmt = $con->prepare("DELETE FROM patient_details WHERE id = ?");
    $stmt->bind_param("i", $patientId);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Patient record deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting patient: " . $stmt->error;
    }
    $stmt->close();
}
header("Location: admin_patient_details.php");
exit();
?>
