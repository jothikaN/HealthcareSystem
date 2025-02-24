<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Verify the user is logged in as a patient
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Patient Blood Sugar Check</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Link to Bootstrap CSS (adjust path as necessary) -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Blood Sugar Check</h1>
    <p>Please enter your blood sugar level (mg/dL) and select the type:</p>
    <form action="process_patient_sugar.php" method="post">
      <div class="form-group">
        <label for="blood_sugar">Blood Sugar (mg/dL):</label>
        <input type="number" step="0.01" id="blood_sugar" name="blood_sugar" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="type">Type:</label>
        <select id="type" name="type" class="form-control" required>
          <option value="1">Fasting</option>
          <option value="2">Post Prandial</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Submit Reading</button>
    </form>
    <!-- Back Button to return to the Patient Dashboard -->
    <a href="patient_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
  </div>
  <!-- Optional JavaScript; include Bootstrap Bundle with Popper -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
