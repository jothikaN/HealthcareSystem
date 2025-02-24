<?php
session_start();
require_once 'connect.php';  // Assumes $con is defined

// Check if the user is logged in (adjust role check as needed)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: signin.php");
    exit();
}

// Check if an ID is provided
if (isset($_GET['id'])) {
    $recordId = $_GET['id'];
    $userId   = $_SESSION['user_id'];

    // Optionally, ensure that the record belongs to this user:
    $stmt = $con->prepare("DELETE FROM blood_pressure WHERE id = ? AND patient_id = ?");
    $stmt->bind_param("ii", $recordId, $userId);
    if ($stmt->execute()) {
        header("Location: patient_dashboard.php");  // Redirect after deletion
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "No record ID specified.";
}

$con->close();
?>
