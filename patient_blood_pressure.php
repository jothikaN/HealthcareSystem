<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Check if the user is logged in and has a 'user' role
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Patient Blood Pressure Check</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Link to Bootstrap CSS (adjust the path if needed) -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <h1>Blood Pressure Check</h1>
    <p>Please enter your blood pressure readings:</p>
    <form action="process_patient_bp.php" method="post">
      <div class="form-group">
        <label for="systolic">Systolic (mm Hg):</label>
        <input type="number" id="systolic" name="systolic" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="diastolic">Diastolic (mm Hg):</label>
        <input type="number" id="diastolic" name="diastolic" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit Readings</button>
    </form>
    <!-- Back Button to return to the Patient Dashboard -->
    <a href="patient_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
  </div>
  <!-- Optional JavaScript; include Bootstrap Bundle with Popper -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
