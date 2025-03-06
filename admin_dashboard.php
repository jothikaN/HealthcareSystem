<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit;
}

// Example data, you can replace this with actual counts from the database
$bloodSugarCount = 120; // Replace with actual query to count records
$bloodPressureCount = 150; // Replace with actual query to count records
$patientChartCount = 200; // Replace with actual query to count records
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Link to Bootstrap CSS for styling -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- FontAwesome for Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    .card-icon {
      font-size: 3rem;
    }
    .card-body h5 {
      font-size: 1.5rem;
      font-weight: bold;
    }
    .card-body p {
      font-size: 1.2rem;
    }
    .card {
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .btn-custom {
      width: 100%;
      text-align: center;
      padding: 10px;
      font-size: 1.2rem;
      margin-bottom: 10px;
    }
    .sidebar .btn-outline-primary {
      width: 100%;
      text-align: center;
      margin-bottom: 15px;
      font-size: 1.2rem;
    }
    /* Modal Popup Table Width */
    .modal-dialog {
      max-width: 90%;
    }
    /* Mobile Responsiveness */
    @media (max-width: 768px) {
      .card-body h5 {
        font-size: 1.2rem;
      }
      .card-body p {
        font-size: 1rem;
      }
      .card-icon {
        font-size: 2rem;
      }
    }
  </style>
</head>
<header>
    <?php include_once("menu.php"); ?>
</header>
<body>
  <div class="container-fluid mt-5">
    <div class="row">
      <!-- Sidebar Section -->
      <div class="col-md-3 sidebar">
        <div class="card mb-3">
          <div class="card-body">
            <h5>Manage Data</h5>
            <div>
              <a href="#" class="btn btn-outline-primary mb-2 btn-custom" data-bs-toggle="modal" data-bs-target="#bloodSugarModal">
                <i class="fas fa-tint"></i> Blood Sugar
              </a>
              <a href="#" class="btn btn-outline-primary mb-2 btn-custom" data-bs-toggle="modal" data-bs-target="#bloodPressureModal">
                <i class="fas fa-heartbeat"></i> Blood Pressure
              </a>
              <a href="#" class="btn btn-outline-primary mb-2 btn-custom" data-bs-toggle="modal" data-bs-target="#patientDetailsModal">
                <i class="fas fa-user-injured"></i> Patient Chart
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Main Content Section -->
      <div class="col-md-9">
        <h1>Welcome, Admin!</h1>
        <p>Choose an option below to manage the data:</p>

        <!-- Data Counts Section with Icons -->
        <div class="row">
          <!-- Blood Sugar Count -->
          <div class="col-lg-4 col-md-6 mb-3">
            <div class="card text-center">
              <div class="card-body">
                <div class="card-icon text-primary">
                  <i class="fas fa-tint"></i>
                </div>
                <h5 class="card-title">Blood Sugar</h5>
                <p class="card-text"><?php echo $bloodSugarCount; ?> Records</p>
              </div>
            </div>
          </div>

          <!-- Blood Pressure Count -->
          <div class="col-lg-4 col-md-6 mb-3">
            <div class="card text-center">
              <div class="card-body">
                <div class="card-icon text-danger">
                  <i class="fas fa-heartbeat"></i>
                </div>
                <h5 class="card-title">Blood Pressure</h5>
                <p class="card-text"><?php echo $bloodPressureCount; ?> Records</p>
              </div>
            </div>
          </div>

          <!-- Patient Chart Count -->
          <div class="col-lg-4 col-md-6 mb-3">
            <div class="card text-center">
              <div class="card-body">
                <div class="card-icon text-success">
                  <i class="fas fa-user-injured"></i>
                </div>
                <h5 class="card-title">Patient Charts</h5>
                <p class="card-text"><?php echo $patientChartCount; ?> Records</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Blood Sugar Data -->
  <div class="modal fade" id="bloodSugarModal" tabindex="-1" aria-labelledby="bloodSugarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bloodSugarModalLabel">Manage Blood Sugar Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <iframe src="admin_blood_sugar.php" width="100%" height="600px" frameborder="0"></iframe>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Blood Pressure Data -->
  <div class="modal fade" id="bloodPressureModal" tabindex="-1" aria-labelledby="bloodPressureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bloodPressureModalLabel">Manage Blood Pressure Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <iframe src="admin_blood_pressure.php" width="100%" height="600px" frameborder="0"></iframe>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Patient Details -->
  <div class="modal fade" id="patientDetailsModal" tabindex="-1" aria-labelledby="patientDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="patientDetailsModalLabel">Manage Patient Chart</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <iframe src="admin_patient_details.php" width="100%" height="600px" frameborder="0"></iframe>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
