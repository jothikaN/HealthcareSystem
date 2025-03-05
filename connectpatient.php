<?php
session_start();
require_once 'connect.php'; // Assumes $con is defined

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// If the request is POST, handle form submission (insert or update)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if this is an edit operation
    if (isset($_GET['option']) && $_GET['option'] == 'edit' && isset($_GET['id'])) {
        // EDIT: Update existing patient details
        $id            = $_POST['id'];  // hidden field in the edit form
        $first_name    = $_POST['first_name'];
        $last_name     = $_POST['last_name'];
        $age           = $_POST['age'];
        $mobile_number = $_POST['mobile_number'];
        $email         = $_POST['email'];
        $address       = $_POST['address'];
        $nic_no        = $_POST['nic_no'];
        $dob           = $_POST['dob'];
        $weight        = $_POST['weight'];
        $height        = $_POST['height'];
        $gender        = $_POST['gender'];
        
        $sql = "UPDATE patient_details SET first_name = ?, last_name = ?, age = ?, mobile_number = ?, email = ?, address = ?, nic_no = ?, dob = ?, weight = ?, height = ?, gender = ? WHERE id = ? AND user_id = ?";
        $stmt = $con->prepare($sql);
        if (!$stmt) {
            die("Error preparing statement: " . $con->error);
        }
        // Binding: user_id and age are integers, weight and height are doubles, others are strings.
        // Adjust types as per your table schema.
        $stmt->bind_param("ssisssssssii", $first_name, $last_name, $age, $mobile_number, $email, $address, $nic_no, $dob, $weight, $height, $gender, $id, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Your details have been updated.";
        } else {
            $_SESSION['error_message'] = "Error updating details: " . $stmt->error;
        }
        $stmt->close();
        header("Location: patient_dashboard.php");
        exit();
    } else {
        // INSERT: Add new patient details
        $first_name    = $_POST['first_name'];
        $last_name     = $_POST['last_name'];
        $age           = $_POST['age'];
        $mobile_number = $_POST['mobile_number'];
        $email         = $_POST['email'];
        $address       = $_POST['address'];
        $nic_no        = $_POST['nic_no'];
        $dob           = $_POST['dob'];
        $weight        = $_POST['weight'];
        $height        = $_POST['height'];
        $gender        = $_POST['gender'];
        
        $sql = "INSERT INTO patient_details 
                (user_id, first_name, last_name, age, mobile_number, email, address, nic_no, dob, gender, weight, height)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        if (!$stmt) {
            die("Error preparing statement: " . $con->error);
        }
        $stmt->bind_param("ississssssdd", $user_id, $first_name, $last_name, $age, $mobile_number, $email, $address, $nic_no, $dob, $gender, $weight, $height);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Your details have been saved.";
        } else {
            $_SESSION['error_message'] = "Error inserting details: " . $stmt->error;
        }
        $stmt->close();
        header("Location: patient_dashboard.php");
        exit();
    }
} else {
    // If GET request and option=edit is set, display the edit form pre-filled with patient details.
    if (isset($_GET['option']) && $_GET['option'] == 'edit' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $con->prepare("SELECT * FROM patient_details WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $patientData = $result->fetch_assoc();
        } else {
            die("Patient details not found.");
        }
        $stmt->close();
        ?>
        <!doctype html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <title>Edit Your Details</title>
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" href="assets/css/bootstrap.min.css">
          <link rel="stylesheet" href="assets/css/style.css">
        </head>
        <body>
          <div class="container mt-5">
            <h1>Edit Your Details</h1>
            <form action="connectpatient.php?option=edit&id=<?php echo $id; ?>" method="POST">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo htmlspecialchars($patientData['first_name']); ?>" required>
              </div>
              <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($patientData['last_name']); ?>" required>
              </div>
              <!-- Repeat form fields for other details -->
              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($patientData['email']); ?>" required>
              </div>
              <div class="form-group">
                <label for="mobile_number">Mobile Number:</label>
                <input type="text" id="mobile_number" name="mobile_number" class="form-control" value="<?php echo htmlspecialchars($patientData['mobile_number']); ?>" required>
              </div>
              <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" class="form-control" value="<?php echo htmlspecialchars($patientData['age']); ?>" required>
              </div>
              <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($patientData['address']); ?>" required>
              </div>
              <div class="form-group">
                <label for="nic_no">NIC No:</label>
                <input type="text" id="nic_no" name="nic_no" class="form-control" value="<?php echo htmlspecialchars($patientData['nic_no']); ?>" required>
              </div>
              <div class="form-group">
                <label for="dob">DOB:</label>
                <input type="date" id="dob" name="dob" class="form-control" value="<?php echo htmlspecialchars($patientData['dob']); ?>" required>
              </div>
              <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="text" id="weight" name="weight" class="form-control" value="<?php echo htmlspecialchars($patientData['weight']); ?>" required>
              </div>
              <div class="form-group">
                <label for="height">Height:</label>
                <input type="text" id="height" name="height" class="form-control" value="<?php echo htmlspecialchars($patientData['height']); ?>" required>
              </div>
              <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" class="form-control" required>
                  <option value="male" <?php if($patientData['gender'] == 'male') echo 'selected'; ?>>Male</option>
                  <option value="female" <?php if($patientData['gender'] == 'female') echo 'selected'; ?>>Female</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Update Details</button>
            </form>
            <a href="patient_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
          </div>
        </body>
        </html>
        <?php
        exit();
    }
}
?>
