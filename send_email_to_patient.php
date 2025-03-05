<?php
session_start();
require_once 'connect.php';  // Assumes $con is defined

// Ensure admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

// Get patient id from GET parameter
if (!isset($_GET['id'])) {
    $_SESSION['message'] = "No patient id provided.";
    header("Location: admin_patient_details.php");
    exit();
}

$patientId = $_GET['id'];

// Fetch patient details
$stmt = $con->prepare("SELECT email, first_name, last_name FROM patient_details WHERE id = ?");
$stmt->bind_param("i", $patientId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $_SESSION['message'] = "Patient not found.";
    header("Location: admin_patient_details.php");
    exit();
}
$patient = $result->fetch_assoc();
$stmt->close();

// If form is submitted, process sending email with attachment
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject = $_POST['subject'];
    $messageText = $_POST['message'];

    // Generate a boundary string
    $boundary = md5(time());

    // Headers
    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Reply-To: support@yourdomain.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n\r\n";

    // Message Body (plain text part)
    $body = "--{$boundary}\r\n";
    $body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $messageText . "\r\n\r\n";

    // Handle file attachment if provided and no error
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['attachment']['tmp_name'];
        $fileName = $_FILES['attachment']['name'];
        $fileSize = $_FILES['attachment']['size'];
        $fileType = $_FILES['attachment']['type'];
        
        // Verify file extension (should be PDF)
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            $_SESSION['message'] = "Attachment must be a PDF file.";
            header("Location: send_email_to_patient.php?id=" . $patientId);
            exit();
        }
        
        // Read the file content and encode it
        $fileContent = chunk_split(base64_encode(file_get_contents($fileTmpPath)));

        // Add attachment to message body
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: application/pdf; name=\"{$fileName}\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"{$fileName}\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $fileContent . "\r\n\r\n";
    }

    // End the MIME message
    $body .= "--{$boundary}--";

    // Send email using PHP mail()
    if (mail($patient['email'], $subject, $body, $headers)) {
        $_SESSION['message'] = "Email sent successfully to " . $patient['email'];
    } else {
        $_SESSION['message'] = "Failed to send email.";
    }

    header("Location: admin_patient_details.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Email to Patient</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Send Email to Patient</h1>
    <p>
        Patient: <strong><?php echo htmlspecialchars($patient['first_name'] . " " . $patient['last_name']); ?></strong>
        (<em><?php echo htmlspecialchars($patient['email']); ?></em>)
    </p>
    <form action="send_email_to_patient.php?id=<?php echo $patientId; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" class="form-control" value="Important Health Update" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="6" class="form-control" required>
Hello <?php echo htmlspecialchars($patient['first_name']); ?>,

Please review your latest health readings on our system.

Best regards,
Your Healthcare Team
            </textarea>
        </div>
        <div class="form-group">
            <label for="attachment">Attach PDF (optional):</label>
            <input type="file" id="attachment" name="attachment" class="form-control-file" accept=".pdf">
        </div>
        <button type="submit" class="btn btn-primary">Send Email</button>
        <a href="admin_patient_details.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- jQuery, Bootstrap JS, and Toastr JS -->
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
