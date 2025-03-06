<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once 'connect.php';  // Assumes $con is defined


// Check if the user is logged in as a patient.
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
  header("Location: signin.php");
  exit();
}

$userId = $_SESSION['user_id'];

// Handle edit form submission (POST) if in edit mode
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['option']) && $_GET['option'] === 'edit') {
  $editId        = $_POST['id']; // Hidden field from the edit form
  $first_name    = $_POST['first_name'];
  $last_name     = $_POST['last_name'];
  $email         = $_POST['email'];
  $mobile_number = $_POST['mobile_number'];
  $age           = $_POST['age'];
  $address       = $_POST['address'];
  $nic_no        = $_POST['nic_no'];
  $dob           = $_POST['dob'];
  $weight        = $_POST['weight'];
  $height        = $_POST['height'];
  $gender        = $_POST['gender'];

  $updateSql = "UPDATE patient_details
                  SET first_name = ?, last_name = ?, email = ?, mobile_number = ?, age = ?, address = ?, nic_no = ?, dob = ?, weight = ?, height = ?, gender = ?
                  WHERE id = ? AND user_id = ?";
  $stmtUpdate = $con->prepare($updateSql);
  if (!$stmtUpdate) {
    die("Error preparing update statement: " . $con->error);
  }
  $stmtUpdate->bind_param(
    "ssssisssddsii",
    $first_name,
    $last_name,
    $email,
    $mobile_number,
    $age,
    $address,
    $nic_no,
    $dob,
    $weight,
    $height,
    $gender,
    $editId,
    $userId
  );
  if ($stmtUpdate->execute()) {
    $_SESSION['message'] = "Your details have been updated successfully.";
  } else {
    $_SESSION['message'] = "Error updating details: " . $stmtUpdate->error;
  }
  $stmtUpdate->close();
  header("Location: patient_dashboard.php");
  exit();
}

// Check if patient details exist (for display)
$query = "SELECT * FROM patient_details WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$patientExists = ($result->num_rows > 0);
if ($patientExists) {
  $patientData = $result->fetch_assoc();
}
$stmt->close();

// If GET indicates "edit" mode, fetch record for editing
$showEditForm = false;
if (isset($_GET['option']) && $_GET['option'] === 'edit' && isset($_GET['bstaffId'])) {
  $editId = $_GET['bstaffId'];
  $stmtEdit = $con->prepare("SELECT * FROM patient_details WHERE id = ? AND user_id = ?");
  $stmtEdit->bind_param("ii", $editId, $userId);
  $stmtEdit->execute();
  $editResult = $stmtEdit->get_result();
  if ($editResult->num_rows > 0) {
    $patientDataToEdit = $editResult->fetch_assoc();
    $showEditForm = true;
  }
  $stmtEdit->close();
}

// Optional: Handle deletion for blood pressure records (if needed)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
  $recordId = $_GET['id'];
  $stmtDel = $con->prepare("DELETE FROM blood_pressure WHERE id = ? AND patient_id = ?");
  $stmtDel->bind_param("ii", $recordId, $userId);
  if ($stmtDel->execute()) {
    header("Location: patient_dashboard.php");
    exit();
  } else {
    echo "Error deleting record: " . $stmtDel->error;
  }
  $stmtDel->close();
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Patient Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS and Custom CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <style>
    body {
      background-color: #f5f7fa;
      font-family: 'Poppins', sans-serif;
      color: #333;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 30px;
    }

    h1 {
      color: #1a4708;
      font-size: 2.5rem;
      text-align: center;
      margin-bottom: 30px;
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      margin-bottom: 30px;
      overflow: hidden;
    }

    .card-header {
      background: linear-gradient(135deg, #1a4708, #2b6e12);
      color: #fff;
      font-size: 1.5rem;
      text-align: center;
      padding: 20px;
      font-weight: bold;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: 600;
      color: #333;
      font-size: 1rem;
    }

    .form-control {
      border: 2px solid #ddd;
      border-radius: 10px;
      padding: 12px 20px;
      font-size: 1rem;
      width: 100%;
      transition: 0.3s;
    }

    .form-control:focus {
      border-color: #1a4708;
      box-shadow: 0 0 10px rgba(26, 71, 8, 0.3);
    }

    .btn-primary {
      background-color: #1a4708;
      border: none;
      padding: 12px 25px;
      font-size: 1.1rem;
      border-radius: 25px;
      text-transform: uppercase;
      font-weight: 600;
      transition: 0.3s ease-in-out;
    }

    .btn-primary:hover {
      background-color: #2b6e12;
      transform: translateY(-5px);
    }

    .btn-secondary {
      background-color: #6c757d;
      border: none;
      padding: 12px 25px;
      font-size: 1.1rem;
      border-radius: 25px;
      text-transform: uppercase;
      font-weight: 600;
      transition: 0.3s ease-in-out;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
      transform: translateY(-5px);
    }

    .table {
      border-radius: 12px;
      overflow: hidden;
      background: #fff;
      margin-top: 30px;
      width: 100%;
      table-layout: auto;
      border-collapse: collapse;
    }

    .table thead th {
      background-color: #1a4708;
      color: white;
      font-size: 1.1rem;
      text-transform: uppercase;
      padding: 15px;
      border: 1px solid #ddd;
    }

    .table tbody tr:hover {
      background-color: #e9f5e6;
      transition: 0.3s;
    }

    .badge-status {
      font-size: 0.9rem;
      padding: 6px 12px;
      border-radius: 8px;
      font-weight: bold;
      color: #fff;
    }

    .toast {
      background: #1a4708;
      color: white;
      border-radius: 12px;
      padding: 15px;
      font-size: 1.1rem;
    }

    .toast-body {
      font-size: 1rem;
      text-align: center;
    }

    .row {
      margin-bottom: 15px;
    }

    /* Responsive Table */
    @media (max-width: 768px) {
      .table {
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
      }

      .table thead {
        display: none;
      }

      .table tbody tr {
        display: block;
        margin-bottom: 10px;
      }

      .table tbody td {
        display: block;
        text-align: right;
        padding: 10px;
        position: relative;
        border: 1px solid #ddd;
        font-size: 0.9rem;
      }

      .table tbody td:before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        top: 10px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.9rem;
        color: #1a4708;
      }

      .card-header {
        font-size: 1.3rem;
      }

      .form-control {
        font-size: 0.9rem;
        padding: 10px 15px;
      }

      .btn-primary,
      .btn-secondary {
        font-size: 1rem;
        padding: 10px 20px;
      }

      .container {
        padding: 20px;
      }

      h1 {
        font-size: 2rem;
      }

      .col-md-6 {
        width: 100%;
        padding: 0 15px;
      }
    }

    /* For smaller mobile screens */
    @media (max-width: 480px) {
      .form-control {
        font-size: 0.8rem;
        padding: 8px 12px;
      }

      .btn-primary,
      .btn-secondary {
        font-size: 0.9rem;
        padding: 8px 18px;
      }

      h1 {
        font-size: 1.8rem;
      }

      .form-group {
        margin-bottom: 15px;
      }

      .table td {
        font-size: 0.8rem;
        padding: 8px;
      }

    }
  </style>
</head>

<body>
  <header>
    <?php include_once("menu.php"); ?>
  </header>
  <div class="container mt-5">
    <h1 class="mb-4 text-center">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>

    <?php if ($showEditForm && !empty($patientDataToEdit)): ?>
      <!-- Edit Form -->
      <div class="card mb-4">
        <div class="card-header">Edit Your Details</div>
        <div class="card-body">
          <form action="patient_dashboard.php?option=edit&bstaffId=<?php echo $patientDataToEdit['id']; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $patientDataToEdit['id']; ?>">
            <div class="row">
              <!-- Left Column -->
              <div class="col-md-6 col-sm-12 mb-3">
                <div class="form-group">
                  <label for="first_name"><i class="bi bi-person-fill"></i> First Name</label>
                  <input type="text" class="form-control" id="first_name" name="first_name" required value="<?php echo htmlspecialchars($patientDataToEdit['first_name']); ?>">
                </div>
                <div class="form-group">
                  <label for="last_name"><i class="bi bi-person"></i> Last Name</label>
                  <input type="text" class="form-control" id="last_name" name="last_name" required value="<?php echo htmlspecialchars($patientDataToEdit['last_name']); ?>">
                </div>
                <div class="form-group">
                  <label for="email"><i class="bi bi-envelope-fill"></i> Email</label>
                  <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($patientDataToEdit['email']); ?>">
                </div>
                <div class="form-group">
                  <label for="mobile_number"><i class="bi bi-phone-fill"></i> Mobile Number</label>
                  <input type="text" class="form-control" id="mobile_number" name="mobile_number" required value="<?php echo htmlspecialchars($patientDataToEdit['mobile_number']); ?>">
                </div>
                <div class="form-group">
                  <label for="age"><i class="bi bi-calendar-check-fill"></i> Age</label>
                  <input type="number" class="form-control" id="age" name="age" required value="<?php echo htmlspecialchars($patientDataToEdit['age']); ?>">
                </div>
              </div>

              <!-- Right Column -->
              <div class="col-md-6 col-sm-12 mb-3">
                <div class="form-group">
                  <label for="address"><i class="bi bi-house-door-fill"></i> Address</label>
                  <input type="text" class="form-control" id="address" name="address" required value="<?php echo htmlspecialchars($patientDataToEdit['address']); ?>">
                </div>
                <div class="form-group">
                  <label for="nic_no"><i class="bi bi-credit-card-2-front-fill"></i> NIC No</label>
                  <input type="text" class="form-control" id="nic_no" name="nic_no" required value="<?php echo htmlspecialchars($patientDataToEdit['nic_no']); ?>">
                </div>
                <div class="form-group">
                  <label for="dob"><i class="bi bi-calendar-event-fill"></i> DOB</label>
                  <input type="date" class="form-control" id="dob" name="dob" required value="<?php echo htmlspecialchars($patientDataToEdit['dob']); ?>">
                </div>
                <div class="form-group">
                  <label for="weight"><i class="bi bi-weight"></i> Weight</label>
                  <input type="text" class="form-control" id="weight" name="weight" required value="<?php echo htmlspecialchars($patientDataToEdit['weight']); ?>">
                </div>
                <div class="form-group">
                  <label for="height"><i class="bi bi-rulers"></i> Height</label>
                  <input type="text" class="form-control" id="height" name="height" required value="<?php echo htmlspecialchars($patientDataToEdit['height']); ?>">
                </div>
                <div class="form-group">
                  <label for="gender"><i class="bi bi-gender-ambiguous"></i> Gender</label>
                  <select class="form-control" id="gender" name="gender" required>
                    <option value="male" <?php if ($patientDataToEdit['gender'] === 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($patientDataToEdit['gender'] === 'female') echo 'selected'; ?>>Female</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Buttons -->
            <div class="form-group text-center mt-4">
              <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle-fill"></i> Update</button>
              <a href="patient_dashboard.php" class="btn btn-secondary ml-2"><i class="bi bi-x-circle-fill"></i> Cancel</a>
            </div>
          </form>
        </div>
      </div>

    <?php elseif (!$patientExists): ?>
      <!-- New Details Form -->
      <div class="card mb-4">
        <div class="card-header">Enter Your Details</div>
        <div class="card-body">
          <form action="connectpatient.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
            <div class="form-row">
              <div class="form-group col-md-6 col-sm-12 mb-3">
                <label for="first_name"><i class="bi bi-person-fill"></i> First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" required>
              </div>
              <div class="form-group col-md-6 col-sm-12 mb-3">
                <label for="last_name"><i class="bi bi-person"></i> Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" required>
              </div>
              <div class="form-group col-md-6 col-sm-12 mb-3">
                <label for="email"><i class="bi bi-envelope-fill"></i> Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
              </div>
              <div class="form-group col-md-6 col-sm-12 mb-3">
                <label for="mobile_number"><i class="bi bi-phone-fill"></i> Mobile Number:</label>
                <input type="text" id="mobile_number" name="mobile_number" class="form-control" required>
              </div>
              <div class="form-group col-md-6 col-sm-12 mb-3">
                <label for="dob"><i class="bi bi-calendar-event-fill"></i> DOB:</label>
                <input type="date" id="dob" name="dob" class="form-control" required>
              </div>
              <div class="form-group col-md-6 col-sm-12 mb-3">
                <label for="gender"><i class="bi bi-gender-ambiguous"></i> Gender:</label>
                <select id="gender" name="gender" class="form-control" required>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle-fill"></i> Submit</button>
          </form>
        </div>
      </div>



      <?php else: ?>
      <!-- Display existing details -->
      <div class="card mb-4">
        <div class="card-header">👤 Patient Details</div>
        <div class="card-body">
          <div class="row">
            <!-- Left Column -->
            <div class="col-md-6 col-sm-12 mb-3">
              <p><strong>👤 First Name:</strong> <?php echo htmlspecialchars($patientData['first_name']); ?></p>
              <p><strong>👤 Last Name:</strong> <?php echo htmlspecialchars($patientData['last_name']); ?></p>
              <p><strong>✉️ Email:</strong> <?php echo htmlspecialchars($patientData['email']); ?></p>
              <p><strong>📞 Mobile Number:</strong> <?php echo htmlspecialchars($patientData['mobile_number']); ?></p>
              <p><strong>🎂 Age:</strong> <?php echo htmlspecialchars($patientData['age']); ?></p>
              <p><strong>⚤ Gender:</strong> <?php echo htmlspecialchars($patientData['gender']); ?></p>
            </div>

            <!-- Right Column -->
            <div class="col-md-6 col-sm-12 mb-3">
              <p><strong>📍 Address:</strong> <?php echo htmlspecialchars($patientData['address']); ?></p>
              <p><strong>🆔 NIC No:</strong> <?php echo htmlspecialchars($patientData['nic_no']); ?></p>
              <p><strong>📅 DOB:</strong> <?php echo htmlspecialchars($patientData['dob']); ?></p>
              <p><strong>⚖️ Weight:</strong> <?php echo htmlspecialchars($patientData['weight']); ?></p>
              <p><strong>📏 Height:</strong> <?php echo htmlspecialchars($patientData['height']); ?></p>
              <div class="text-center mt-4">
                <a href="patient_dashboard.php?option=edit&bstaffId=<?php echo $patientData['id']; ?>" class="btn btn-primary btn-sm">
                  ✏️ Edit
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php endif; ?>



    <!-- Buttons for checking health readings -->
    <div class="mt-5 text-center">
      <h3>Check Your Health Readings</h3>
      <div class="btn-group d-block d-md-flex justify-content-center w-100">
        <a href="patient_blood_pressure.php" class="btn btn-info mb-2 mb-md-0 mr-md-2">Check Blood Pressure</a>
        <a href="patient_blood_sugar.php" class="btn btn-info mb-2 mb-md-0">Check Blood Sugar</a>
      </div>
    </div>


    <!-- Display Blood Pressure Records -->
    <div class="mt-5">
      <h3>Your Blood Pressure Records</h3>
      <?php
      $queryBP = "SELECT * FROM blood_pressure WHERE patient_id = ?";
      $stmtBP = $con->prepare($queryBP);
      $stmtBP->bind_param("i", $userId);
      $stmtBP->execute();
      $resultBP = $stmtBP->get_result();

      if ($resultBP->num_rows > 0) {
        echo "<table class='table table-bordered'>";
        echo "<thead><tr>
                  <th>Recorded At</th>
                  <th>Systolic</th>
                  <th>Diastolic</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr></thead><tbody>";
        while ($rowBP = $resultBP->fetch_assoc()) {
          $systolicVal = $rowBP['systolic'];
          $diastolicVal = $rowBP['diastolic'];

          // Fetch status based on thresholds
          $stmtThreshold = $con->prepare("SELECT status FROM blood_pressure_data WHERE ? BETWEEN systolic_min AND systolic_max AND ? BETWEEN diastolic_min AND diastolic_max LIMIT 1");
          $stmtThreshold->bind_param("dd", $systolicVal, $diastolicVal);
          $stmtThreshold->execute();
          $resultThreshold = $stmtThreshold->get_result();

          $computedStatus = "Not determined";
          if ($resultThreshold->num_rows > 0) {
            $thresholdData = $resultThreshold->fetch_assoc();
            $computedStatus = $thresholdData['status'];
          }
          $stmtThreshold->close();

          // Assign badge class based on status
          $badgeClass = "secondary";
          if (stripos($computedStatus, "normal") !== false) {
            $badgeClass = "success";
          } elseif (stripos($computedStatus, "pre") !== false) {
            $badgeClass = "warning";
          } elseif (stripos($computedStatus, "diabetes") !== false || stripos($computedStatus, "hypertension") !== false) {
            $badgeClass = "danger";
          }

          echo "<tr>";
          echo "<td>" . htmlspecialchars($rowBP['recorded_at']) . "</td>";
          echo "<td>" . htmlspecialchars($rowBP['systolic']) . "</td>";
          echo "<td>" . htmlspecialchars($rowBP['diastolic']) . "</td>";
          echo "<td><span class='badge badge-$badgeClass badge-status'>" . htmlspecialchars($computedStatus) . "</span></td>";
          echo "<td>
                      <a href='process_bp_delete.php?id=" . htmlspecialchars($rowBP['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                  </td>";
          echo "</tr>";
        }
        echo "</tbody></table>";
      } else {
        echo "<p>No blood pressure records found.</p>";
      }
      $stmtBP->close();
      ?>
    </div>

    <!-- Display Blood Sugar Records -->
    <div class="mt-5">
      <h3>Your Blood Sugar Records</h3>
      <?php
      $queryBS = "SELECT id, recorded_at, blood_sugar, type FROM blood_sugar WHERE patient_id = ?";
      $stmtBS = $con->prepare($queryBS);
      $stmtBS->bind_param("i", $userId);
      $stmtBS->execute();
      $resultBS = $stmtBS->get_result();

      if ($resultBS->num_rows > 0) {
        echo "<table class='table table-bordered'>";
        echo "<thead><tr>
                  <th>Recorded At</th>
                  <th>Blood Sugar (mg/dL)</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr></thead><tbody>";
        while ($rowBS = $resultBS->fetch_assoc()) {
          $bloodSugar = $rowBS['blood_sugar'];
          $typeVal = $rowBS['type'];
          $typeText = ($typeVal == 1) ? "Fasting" : "Post Prandial";

          // Fetch status based on thresholds
          $queryStatus = "SELECT status FROM blood_sugar_data WHERE min_value <= ? AND max_value >= ? AND type = ? LIMIT 1";
          $stmtStatus = $con->prepare($queryStatus);
          $stmtStatus->bind_param("dii", $bloodSugar, $bloodSugar, $typeVal);
          $stmtStatus->execute();
          $resultStatus = $stmtStatus->get_result();

          $computedStatus = "Unknown";
          if ($resultStatus->num_rows > 0) {
            $statusRow = $resultStatus->fetch_assoc();
            $computedStatus = htmlspecialchars($statusRow['status']);
          }
          $stmtStatus->close();

          // Assign badge class based on status
          $badgeClass = "secondary";
          if (stripos($computedStatus, "normal") !== false) {
            $badgeClass = "success";
          } elseif (stripos($computedStatus, "pre") !== false) {
            $badgeClass = "warning";
          } elseif (stripos($computedStatus, "diabetes") !== false) {
            $badgeClass = "danger";
          }

          echo "<tr>";
          echo "<td>" . htmlspecialchars($rowBS['recorded_at']) . "</td>";
          echo "<td>" . htmlspecialchars($rowBS['blood_sugar']) . "</td>";
          echo "<td>" . htmlspecialchars($typeText) . "</td>";
          echo "<td><span class='badge badge-$badgeClass badge-status'>" . $computedStatus . "</span></td>";
          echo "<td>
                      <a href='process_bs_delete.php?id=" . htmlspecialchars($rowBS['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                  </td>";
          echo "</tr>";
        }
        echo "</tbody></table>";
      } else {
        echo "<p>No blood sugar records found.</p>";
      }
      $stmtBS->close();
      ?>
    </div>

    <!-- Back Button -->
    <div class="mt-3 text-center">
      <a href="index.php" class="btn btn-secondary">Back</a>
    </div>
  </div>

  <!-- Scripts -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery and Toastr JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-bottom-right",
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };

    $(document).ready(function() {
      <?php if (isset($_SESSION['message'])): ?>
        toastr.success("<?php echo addslashes($_SESSION['message']); ?>");
        <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
    });
  </script>
</body>

</html>