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
        $min_value = $_POST['min_value'];
        $max_value = $_POST['max_value'];
        $status    = trim($_POST['status']);
        $type      = $_POST['type']; // 1 for fasting, 2 for post prandial

        $stmt = $con->prepare("INSERT INTO blood_sugar_data (min_value, max_value, status, type) VALUES (?, ?, ?, ?)");
        // Use format "ddsi": double, double, string, integer
        $stmt->bind_param("ddsi", $min_value, $max_value, $status, $type);
        $stmt->execute();
        header("Location: admin_blood_sugar.php");
        exit;
    } elseif ($option == 'edit') {
        $id        = $_POST['id'];
        $min_value = $_POST['min_value'];
        $max_value = $_POST['max_value'];
        $status    = trim($_POST['status']);
        $type      = $_POST['type']; // Blood sugar type

        $stmt = $con->prepare("UPDATE blood_sugar_data SET min_value = ?, max_value = ?, status = ?, type = ? WHERE id = ?");
        // Format: "ddsii": double, double, string, integer, integer
        $stmt->bind_param("ddsii", $min_value, $max_value, $status, $type, $id);
        $stmt->execute();
        header("Location: admin_blood_sugar.php");
        exit;
    }
}

// Process GET request for Delete
if ($option == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $con->prepare("DELETE FROM blood_sugar_data WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin_blood_sugar.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Blood Sugar Data Management</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h1>Blood Sugar Data Management</h1>
  <?php if ($option == 'add'): ?>
      <h2>Add New Record</h2>
      <form method="post">
          <div class="form-group">
              <label>Minimum Value</label>
              <input type="number" step="0.01" name="min_value" class="form-control" required>
          </div>
          <div class="form-group">
              <label>Maximum Value</label>
              <input type="number" step="0.01" name="max_value" class="form-control" required>
          </div>
          <div class="form-group">
              <label>Status</label>
              <input type="text" name="status" class="form-control" required>
          </div>
          <div class="form-group">
              <label>Type</label>
              <select name="type" class="form-control" required>
                  <option value="1">Fasting</option>
                  <option value="2">Post Prandial</option>
              </select>
          </div>
          <button type="submit" class="btn btn-primary">Add Record</button>
      </form>
      <a href="admin_blood_sugar.php" class="btn btn-secondary mt-3">Back</a>
  <?php elseif ($option == 'edit' && isset($_GET['id'])):
          $id = $_GET['id'];
          $stmt = $con->prepare("SELECT * FROM blood_sugar_data WHERE id = ?");
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
              <label>Minimum Value</label>
              <input type="number" step="0.01" name="min_value" class="form-control" value="<?php echo $record['min_value']; ?>" required>
          </div>
          <div class="form-group">
              <label>Maximum Value</label>
              <input type="number" step="0.01" name="max_value" class="form-control" value="<?php echo $record['max_value']; ?>" required>
          </div>
          <div class="form-group">
              <label>Status</label>
              <input type="text" name="status" class="form-control" value="<?php echo $record['status']; ?>" required>
          </div>
          <div class="form-group">
              <label>Type</label>
              <select name="type" class="form-control" required>
                  <option value="1" <?php if ($record['type'] == 1) echo "selected"; ?>>Fasting</option>
                  <option value="2" <?php if ($record['type'] == 2) echo "selected"; ?>>Post Prandial</option>
              </select>
          </div>
          <button type="submit" class="btn btn-primary">Update Record</button>
      </form>
      <a href="admin_blood_sugar.php" class="btn btn-secondary mt-3">Back</a>
  <?php else: ?>
      <a href="admin_blood_sugar.php?option=add" class="btn btn-success mb-3">Add New Record</a>
      <?php
      $result = $con->query("SELECT * FROM blood_sugar_data");
      ?>
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Minimum Value(mg/dl)</th>
                  <th>Maximum Value(mg/dl)</th>
                  <th>Status</th>
                  <th>Type</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo $row['min_value']; ?></td>
                      <td><?php echo $row['max_value']; ?></td>
                      <td><?php echo $row['status']; ?></td>
                      <td>
                          <?php 
                          if ($row['type'] == 1) {
                              echo "Fasting";
                          } elseif ($row['type'] == 2) {
                              echo "Post Prandial";
                          }
                          ?>
                      </td>
                      <td>
                          <a href="admin_blood_sugar.php?option=edit&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                          <a href="admin_blood_sugar.php?option=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
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
