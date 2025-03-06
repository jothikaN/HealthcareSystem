<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Healthcare System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #e8f5e9; /* Light green background */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            width: 90%;
            max-width: 950px;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
        }
        .login-image {
            flex: 1;
            background: url('https://media.giphy.com/media/Vu1i8D1Cq4tR9huzRH/giphy.gif?cid=ecf05e4787cec4qr2jj25dbn47q4us4dizr2a65buymew9to&ep=v1_gifs_search&rid=giphy.gif&ct=g') no-repeat center center;
            background-size: cover;
            min-height: 350px;
        }
        .login-form {
            flex: 1;
            padding: 40px;
            text-align: center;
        }
        .login-form h2 {
            color: #2e7d32; /* Dark Green */
            margin-bottom: 20px;
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #c8e6c9;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #2e7d32;
            box-shadow: 0 0 5px rgba(46, 125, 50, 0.5);
        }
        .btn-green {
            background-color: #2e7d32; /* Dark Green */
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        .btn-green:hover {
            background-color: #1b5e20;
        }
        .forgot-password {
            font-size: 14px;
            display: block;
            margin-top: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .login-image {
                height: 200px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Left Side GIF -->
        <div class="login-image"></div>
        
        <!-- Right Side Form -->
        <div class="login-form">
            <h2>Welcome Back</h2>
            <p>Please login to continue</p>

            <form action="signinconnection.php" method="POST">
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-green w-100">Login</button>
                <a href="#" class="forgot-password">Forgot password?</a>
            </form>
        </div>
    </div>

    <!-- jQuery and Toastr Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        <?php 
        session_start();
        if (isset($_SESSION['message'])): ?>
            toastr.<?= $_SESSION['message_type'] ?>("<?= $_SESSION['message'] ?>");
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>
    </script>

</body>
</html>
