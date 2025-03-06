<?php
session_start();
require_once 'connect.php';  // This file should set up $con correctly

// Check if the logged-in user is an admin.
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

// Query all patients from the patient_details table.
$sql = "SELECT * FROM patient_details";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Patient Details</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .table thead th {
            text-align: center;
        }
        .btn {
            text-align: center;
        }
    </style>
</head>

<body>
<div class="container mt-5">
    <h1 class="mb-4">Patient Details</h1>
    <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Patient Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Blood Pressure (Latest)</th>
                    <th>Blood Sugar (Latest)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($patient = $result->fetch_assoc()): ?>
                <?php 
                $patient_id = $patient['user_id']; // adjust if your patient_details table uses a different key for linking readings

                // Fetch latest blood pressure reading for this patient
                $bp_sql = "SELECT systolic, diastolic, recorded_at FROM blood_pressure WHERE patient_id = ? ORDER BY recorded_at DESC LIMIT 1";
                $bp_stmt = $con->prepare($bp_sql);
                $bp_stmt->bind_param("i", $patient['user_id']);
                $bp_stmt->execute();
                $bp_result = $bp_stmt->get_result();
                $bp_reading = $bp_result->fetch_assoc();
                $bp_stmt->close();

                // Fetch latest blood sugar reading for this patient
                $bs_sql = "SELECT blood_sugar, type, recorded_at FROM blood_sugar WHERE patient_id = ? ORDER BY recorded_at DESC LIMIT 1";
                $bs_stmt = $con->prepare($bs_sql);
                $bs_stmt->bind_param("i", $patient['user_id']);
                $bs_stmt->execute();
                $bs_result = $bs_stmt->get_result();
                $bs_reading = $bs_result->fetch_assoc();
                $bs_stmt->close();

                // Determine blood sugar type text.
                if ($bs_reading) {
                    $typeText = ($bs_reading['type'] == 1) ? "Fasting" : "Post Prandial";
                }
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($patient['first_name'] . " " . $patient['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($patient['email']); ?></td>
                    <td><?php echo htmlspecialchars($patient['mobile_number']); ?></td>
                    <td>
                        <?php 
                        if ($bp_reading) {
                            echo "Systolic: " . htmlspecialchars($bp_reading['systolic']) . "<br>Diastolic: " . htmlspecialchars($bp_reading['diastolic']);
                        } else {
                            echo "N/A";
                        }
                        ?>
                    </td>
                    <td>
                        <?php 
                        if ($bs_reading) {
                            echo htmlspecialchars($bs_reading['blood_sugar']) . " (" . $typeText . ")";
                        } else {
                            echo "N/A";
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <!-- Delete button (calls process_patient_delete.php with the patient id) -->
                        <a href="process_patient_delete.php?id=<?php echo $patient['id']; ?>" class=" btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?');">Delete</a>
                        <!-- Send Email button (calls send_email_to_patient.php with the patient id) -->
                        <a href="send_email_to_patient.php?id=<?php echo $patient['id']; ?>" class=" btn-info btn-sm"> Email</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p>No patients found.</p>
    <?php endif; ?>
    <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<!-- Include jQuery, Bootstrap Bundle, and Toastr JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-bottom-right",
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000"
  };

  $(document).ready(function() {
      <?php if(isset($_SESSION['message'])): ?>
         toastr.success("<?php echo addslashes($_SESSION['message']); ?>");
         <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
  });
</script>
</body>
</html>
