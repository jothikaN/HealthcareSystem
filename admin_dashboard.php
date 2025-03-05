<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Link to Bootstrap CSS for styling; update the path if needed -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<header>
    <?php include_once("menu.php"); ?>
</header>
<body>
  <div class="container mt-5">
    <h1>Welcome, Admin!</h1>
    <p>Choose an option below to manage the data:</p>
    <div class="btn-group mt-3" role="group">
      <a href="admin_blood_sugar.php" class="btn btn-primary">Manage Blood Sugar Data</a>
      <a href="admin_blood_pressure.php" class="btn btn-secondary">Manage Blood Pressure Data</a>
      <a href="admin_patient_details.php" class="btn btn-secondary">Manage Patients Chart</a>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
