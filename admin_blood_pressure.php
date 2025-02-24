<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit;
}

require_once 'connect.php'; // Assumes $con is defined

$option = isset($_GET['option']) ? $_GET['option'] : '';

// Process POST requests for Add or Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($option == 'add') {
        $systolic_min   = $_POST['systolic_min'];
        $systolic_max   = $_POST['systolic_max'];
        $diastolic_min  = $_POST['diastolic_min'];
        $diastolic_max  = $_POST['diastolic_max'];
        $status         = trim($_POST['status']);

        $stmt = $con->prepare("INSERT INTO blood_pressure_data (systolic_min, systolic_max, diastolic_min, diastolic_max, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiis", $systolic_min, $systolic_max, $diastolic_min, $diastolic_max, $status);
        $stmt->execute();
        header("Location: admin_blood_pressure.php");
        exit;
    } elseif ($option == 'edit') {
        $id             = $_POST['id'];
        $systolic_min   = $_POST['systolic_min'];
        $systolic_max   = $_POST['systolic_max'];
        $diastolic_min  = $_POST['diastolic_min'];
        $diastolic_max  = $_POST['diastolic_max'];
        $status         = trim($_POST['status']);

        $stmt = $con->prepare("UPDATE blood_pressure_data SET systolic_min = ?, systolic_max = ?, diastolic_min = ?, diastolic_max = ?, status = ? WHERE id = ?");
        $stmt->bind_param("iiiisi", $systolic_min, $systolic_max, $diastolic_min, $diastolic_max, $status, $id);
        $stmt->execute();
        header("Location: admin_blood_pressure.php");
        exit;
    }
}

// Process GET request for Delete
if ($option == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $con->prepare("DELETE FROM blood_pressure_data WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin_blood_pressure.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Blood Pressure Data Management</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h1>Blood Pressure Data Management</h1>
  <?php if ($option == 'add'): ?>
      <h2>Add New Record</h2>
      <form method="post">
          <div class="form-group">
              <label>Systolic Min(mm Hg)</label>
              <input type="number" name="systolic_min" class="form-control" required>
          </div>
          <div class="form-group">
              <label>Systolic Max (mm Hg)</label>
              <input type="number" name="systolic_max" class="form-control" required>
          </div>
          <div class="form-group">
              <label>Diastolic Min (mm Hg)</label>
              <input type="number" name="diastolic_min" class="form-control" required>
          </div>
          <div class="form-group">
              <label>Diastolic Max (mm Hg)</label>
              <input type="number" name="diastolic_max" class="form-control" required>
          </div>
          <div class="form-group">
              <label>Status</label>
              <input type="text" name="status" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary">Add Record</button>
      </form>
      <a href="admin_blood_pressure.php" class="btn btn-secondary mt-3">Back</a>
  <?php elseif ($option == 'edit' && isset($_GET['id'])):
          $id = $_GET['id'];
          $stmt = $con->prepare("SELECT * FROM blood_pressure_data WHERE id = ?");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $result = $stmt->get_result();
          $record = $result->fetch_assoc();
          if (!$record) {
              echo "<div class='alert alert-danger'>Record not found</div>";
          }
  ?>
      <h2>Edit Record</h2>
      <form method="post">
          <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
          <div class="form-group">
              <label>Systolic Min</label>
              <input type="number" name="systolic_min" class="form-control" value="<?php echo $record['systolic_min']; ?>" required>
          </div>
          <div class="form-group">
              <label>Systolic Max</label>
              <input type="number" name="systolic_max" class="form-control" value="<?php echo $record['systolic_max']; ?>" required>
          </div>
          <div class="form-group">
              <label>Diastolic Min</label>
              <input type="number" name="diastolic_min" class="form-control" value="<?php echo $record['diastolic_min']; ?>" required>
          </div>
          <div class="form-group">
              <label>Diastolic Max</label>
              <input type="number" name="diastolic_max" class="form-control" value="<?php echo $record['diastolic_max']; ?>" required>
          </div>
          <div class="form-group">
              <label>Status</label>
              <input type="text" name="status" class="form-control" value="<?php echo $record['status']; ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Update Record</button>
      </form>
      <a href="admin_blood_pressure.php" class="btn btn-secondary mt-3">Back</a>
  <?php else: ?>
      <a href="admin_blood_pressure.php?option=add" class="btn btn-success mb-3">Add New Record</a>
      <?php
      $result = $con->query("SELECT * FROM blood_pressure_data");
      ?>
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Systolic Min</th>
                  <th>Systolic Max</th>
                  <th>Diastolic Min</th>
                  <th>Diastolic Max</th>
                  <th>Status</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo $row['systolic_min']; ?></td>
                      <td><?php echo $row['systolic_max']; ?></td>
                      <td><?php echo $row['diastolic_min']; ?></td>
                      <td><?php echo $row['diastolic_max']; ?></td>
                      <td><?php echo $row['status']; ?></td>
                      <td>
                          <a href="admin_blood_pressure.php?option=edit&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                          <a href="admin_blood_pressure.php?option=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                      </td>
                  </tr>
              <?php endwhile; ?>
          </tbody>
      </table>
      <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Back</a>

  <?php endif; ?>
</div>
</body>
</html>
