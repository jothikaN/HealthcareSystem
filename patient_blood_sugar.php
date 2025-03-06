<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Sugar Check | Healthcare Portal</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        /* Background Image Styling */
        body {
            background: url('assets/img/patientdasboard/s1.jpg') no-repeat center center/cover;
            position: relative;
            font-family: Arial, sans-serif;
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
            color: rgb(51, 132, 70); /* Green text */
            font-weight: bold;
        }

        .form-control {
            border-radius: 30px;
            padding: 12px;
            border: 2px solid #28a745; /* Green border */
            width: 100%;
        }

        .form-control:focus {
            border-color: #218838;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
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
            background-color: rgb(213, 49, 49);
            border: none;
            color: white;
        }

        .btn-secondary:hover {
            background-color: rgb(144, 33, 31);
        }

        /* Improve dropdown visibility */
        select.form-control {
            width: 100%;
            height: auto;
            padding: 12px;
            font-size: 16px;
            color: #495057;
            background-color: white;
            border-radius: 30px;
            border: 2px solid #28a745;
        }

        select.form-control:focus {
            border-color: #218838;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h1>Blood Sugar Check</h1>
            <p class="text-muted">Enter your blood sugar level below:</p>
            <form action="process_patient_sugar.php" method="post">
                <div class="mb-3">
                    <label for="blood_sugar" class="form-label">Blood Sugar (mg/dL):</label>
                    <input type="number" step="0.01" id="blood_sugar" name="blood_sugar" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type:</label>
                    <select id="type" name="type" class="form-control" required>
                        <option value="1">Fasting</option>
                        <option value="2">Post Prandial</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit Reading</button>
                <a href="patient_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </form>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
