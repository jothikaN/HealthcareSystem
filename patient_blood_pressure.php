<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is logged in and has a 'user' role
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Pressure Check | Healthcare Portal</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        /* Background Image Styling */
        body {
            background: url('assets/img/patientdasboard/s1.jpg') no-repeat center center/cover;
            position: relative;
        }
        /* Overlay to improve readability */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Dark overlay */
            z-index: 1;
        }
        /* Centered Form Styling */
        .container {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 450px;
            width: 100%;
        }
        h1, label, p {
            color:rgb(51, 132, 70); /* Green text */
            font-weight: bold;
        }
        .form-control {
            border-radius: 30px;
            padding: 12px;
            border: 2px solid #28a745; /* Green border */
        }
        .btn-primary {
            width: 100%;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            background-color: #28a745;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        .btn-secondary {
            width: 100%;
            margin-top: 10px;
            border-radius: 10px;
            background-color:rgb(213, 49, 49);
            border: none;
            color: white;
        }
        .btn-secondary:hover {
            background-color:rgb(144, 33, 31);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h1>Blood Pressure Check</h1>
            <p class="text-muted">Enter your blood pressure readings below:</p>
            <form action="process_patient_bp.php" method="post">
                <div class="mb-3">
                    <label for="systolic" class="form-label">Systolic (mm Hg):</label>
                    <input type="number" id="systolic" name="systolic" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="diastolic" class="form-label">Diastolic (mm Hg):</label>
                    <input type="number" id="diastolic" name="diastolic" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit Readings</button>
                <a href="patient_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </form>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
