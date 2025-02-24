<?php
session_start();
require_once 'connect.php'; // Assumes $con is defined

// Check if the user is logged in as a patient
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: signin.php");
    exit();
}

// Check if a record ID is provided in the URL
if (isset($_GET['id'])) {
    $recordId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    // Prepare a statement to delete the record only if it belongs to the logged-in user
    $stmt = $con->prepare("DELETE FROM blood_sugar WHERE id = ? AND patient_id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }
    $stmt->bind_param("ii", $recordId, $userId);

    if ($stmt->execute()) {
        // Redirect to the blood sugar records view page after successful deletion
        header("Location: patient_dashboard.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No record ID provided.";
}

$con->close();
?>
