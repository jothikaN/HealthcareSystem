<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once 'connect.php';  // Assumes $con is set

// Check if the user is logged in as a patient.
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: signin.php");
    exit();
}

$userId = $_SESSION['user_id'];


// Query to check if patient details already exist.
$query = "SELECT * FROM patient_details WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$patientExists = ($result->num_rows > 0);
if ($patientExists) {
    $patientData = $result->fetch_assoc();
}


// Check if deletion is requested
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
  $recordId = $_GET['id'];
  $userId   = $_SESSION['user_id'];
  
  $stmt = $con->prepare("DELETE FROM blood_pressure WHERE id = ? AND patient_id = ?");
  $stmt->bind_param("ii", $recordId, $userId);
  if ($stmt->execute()) {
      header("Location: patient_dashboard.php");
      exit();
  } else {
      echo "Error deleting record: " . $stmt->error;
  }
  $stmt->close();
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Patient Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Link to Bootstrap CSS (update path as needed) -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>

    
    <?php if (!$patientExists): ?>
      <!-- Patient has not submitted their details. Show the form. -->
      <h2>Enter Your Details</h2>
      <form action="connectpatient.php" method="POST" class="mt-4">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
        <div class="form-group">
          <label for="first_name">First Name:</label>
          <input type="text" id="first_name" name="first_name" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="last_name">Last Name:</label>
          <input type="text" id="last_name" name="last_name" class="form-control" required>
        </div>
        <!-- Add other fields as needed, e.g., email, mobile, age, address, NIC, DOB, weight, height, gender -->
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="mobile_number">Mobile Number:</label>
          <input type="text" id="mobile_number" name="mobile_number" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="age">Age:</label>
          <input type="number" id="age" name="age" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="address">Address:</label>
          <input type="text" id="address" name="address" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="nic_no">NIC No:</label>
          <input type="text" id="nic_no" name="nic_no" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="dob">DOB:</label>
          <input type="date" id="dob" name="dob" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="weight">Weight:</label>
          <input type="text" id="weight" name="weight" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="height">Height:</label>
          <input type="text" id="height" name="height" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="gender">Gender:</label>
          <select id="gender" name="gender" class="form-control" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    <?php else: ?>
      <!-- Patient has already submitted their details. Show the details in a view mode with an option to edit. -->
      <h2>Your Details</h2>
      <div class="card mt-4">
        <div class="card-body">
          <p><strong>First Name:</strong> <?php echo htmlspecialchars($patientData['first_name']); ?></p>
          <p><strong>Last Name:</strong> <?php echo htmlspecialchars($patientData['last_name']); ?></p>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($patientData['email']); ?></p>
          <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($patientData['mobile_number']); ?></p>
          <p><strong>Age:</strong> <?php echo htmlspecialchars($patientData['age']); ?></p>
          <p><strong>Address:</strong> <?php echo htmlspecialchars($patientData['address']); ?></p>
          <p><strong>NIC No:</strong> <?php echo htmlspecialchars($patientData['nic_no']); ?></p>
          <p><strong>DOB:</strong> <?php echo htmlspecialchars($patientData['dob']); ?></p>
          <p><strong>Weight:</strong> <?php echo htmlspecialchars($patientData['weight']); ?></p>
          <p><strong>Height:</strong> <?php echo htmlspecialchars($patientData['height']); ?></p>
          <p><strong>Gender:</strong> <?php echo htmlspecialchars($patientData['gender']); ?></p>
          <a href="index.php?pg=patient_dashboard.php&option=edit&bstaffId=' . $sqlRow['id'] . '" class="btn btn-primary btn-sm">Edit</a>
        </div>
      </div>
    <?php endif; ?>

    <!-- Two Buttons for Checking Health Data -->
    <div class="mt-5">
      <h3>Check Your Health Readings</h3>
      <div class="btn-group">
        <a href="patient_blood_pressure.php" class="btn btn-info">Check Blood Pressure</a>
        <a href="patient_blood_sugar.php" class="btn btn-info">Check Blood Sugar</a>
      </div>
    </div>


<!-- Display Logged-in User's Blood Pressure Records -->
<div class="mt-5">
  <h3>Your Blood Pressure Records</h3>
  <?php
  // Query blood pressure data for the logged-in user
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
            </tr></thead>";
      echo "<tbody>";
      while ($rowBP = $resultBP->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($rowBP['recorded_at']) . "</td>";
          echo "<td>" . htmlspecialchars($rowBP['systolic']) . "</td>";
          echo "<td>" . htmlspecialchars($rowBP['diastolic']) . "</td>";

          // Compute status by comparing readings against thresholds in blood_pressure_data
          $systolic = $rowBP['systolic'];
          $diastolic = $rowBP['diastolic'];
          $stmtThreshold = $con->prepare("SELECT status FROM blood_pressure_data WHERE ? BETWEEN systolic_min AND systolic_max AND ? BETWEEN diastolic_min AND diastolic_max LIMIT 1");
          $stmtThreshold->bind_param("dd", $systolic, $diastolic);
          $stmtThreshold->execute();
          $resultThreshold = $stmtThreshold->get_result();
          if ($resultThreshold->num_rows > 0) {
              $thresholdData = $resultThreshold->fetch_assoc();
              $computedStatus = $thresholdData['status'];
          } else {
              $computedStatus = "Not determined";
          }
          $stmtThreshold->close();

          echo "<td>" . htmlspecialchars($computedStatus) . "</td>";
        
          // Delete link: points to process_bp_delete.php with the record id
          echo "<td>
                  <a href='process_bp_delete.php?id=" . htmlspecialchars($rowBP['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                    Delete
                  </a>
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


<!-- Display Logged-in User's Blood Sugar Records -->
<div class="mt-5">
  <h3>Your Blood Sugar Records</h3>
  <?php
  require_once 'connect.php'; // Ensure database connection

  // Query blood sugar data for the logged-in user
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
            </tr></thead>";
      echo "<tbody>";
      
      while ($rowBS = $resultBS->fetch_assoc()) {
          $bloodSugar = $rowBS['blood_sugar'];
          $type = ($rowBS['type'] == 1) ? "Fasting" : "Post Prandial"; // Determine type

          // Fetch the corresponding status based on the blood sugar level
          $queryStatus = "SELECT status FROM blood_sugar_data 
                          WHERE min_value <= ? AND max_value >= ? AND type = ?";
          $stmtStatus = $con->prepare($queryStatus);
          $stmtStatus->bind_param("dii", $bloodSugar, $bloodSugar, $rowBS['type']);
          $stmtStatus->execute();
          $resultStatus = $stmtStatus->get_result();
          $statusRow = $resultStatus->fetch_assoc();
          $status = $statusRow ? htmlspecialchars($statusRow['status']) : "Unknown";

          echo "<tr>";
          echo "<td>" . htmlspecialchars($rowBS['recorded_at']) . "</td>";
          echo "<td>" . htmlspecialchars($rowBS['blood_sugar']) . "</td>";
          echo "<td>" . htmlspecialchars($type) . "</td>";
          echo "<td>" . $status . "</td>";
          
          // Delete link: points to process_bs_delete.php with the record id
          echo "<td>
                  <a href='process_bs_delete.php?id=" . htmlspecialchars($rowBS['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                    Delete
                  </a>
                </td>";
          echo "</tr>";

          $stmtStatus->close();
      }

      echo "</tbody></table>";
  } else {
      echo "<p>No blood sugar records found.</p>";
  }

  $stmtBS->close();
  ?>
</div>


    <!-- Optional: Back Button to go to a main page -->
    <div class="mt-3">
      <a href="index.php" class="btn btn-secondary">Back</a>
    </div>
  </div>

  <!-- Optional JavaScript; include Bootstrap Bundle with Popper -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
