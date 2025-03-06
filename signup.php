<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Health Portal</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(to right, #f8f9fa, #e3f2fd);
            padding: 20px; /* Ensure space on smaller screens */
        }
        .signup-container {
            display: flex;
            flex-direction: row;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
        }
        .signup-left {
            flex: 1;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .signup-left img {
            width: 100%;
            max-width: 400px;
            height: auto;
        }
        .signup-right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .signup-right h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 30px;
            padding: 12px;
        }
        .btn-primary {
            width: 100%;
            border-radius: 10px;
            padding: 25px;
            font-size: 16px;
            font-weight: bold;
            background-color: #007bff;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .text-center a {
            color: #007bff;
            font-weight: bold;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .signup-container {
                flex-direction: column;
                text-align: center;
            }
            .signup-left {
                order: -1; /* Move image above form */
                padding: 10px;
            }
            .signup-left img {
                max-width: 300px;
            }
            .signup-right {
                padding: 20px;
            }
            .btn-primary {
                padding: 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <!-- Left side with GIF -->
        <div class="signup-left">
            <img src="https://media.giphy.com/media/9LWavPUfVpQaa9RCHB/giphy.gif" alt="Sign Up Animation">
        </div>
        
        <!-- Right side with form -->
        <div class="signup-right">
            <h2>Create an Account</h2>
            <form action="signupconnection.php" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Sign Up</button>
                <p class="text-center mt-3">Already have an account? <a href="signin.php">Sign in</a></p>
            </form>
        </div>
    </div>
</body>
</html>
