<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Health | Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/gijgo.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/animated-headline.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Toastr CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


</head>
<body>
<header>
    <?php include_once("menu.php"); ?>
</header>
    <!-- Slider Area Start-->
    <div class="slider-area">
        <div class="slider-active dot-style">
            <!-- Slider Single -->
            <div class="single-slider d-flex align-items-center slider-height">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-7 col-lg-8 col-md-10">
                            <div class="hero-wrapper">
                                <div class="hero__caption">
                                    <h1>Healthy Life.</h1>
                                    <div class="container h-100">
                                        <div class="row d-flex justify-content-center align-items-center h-100">
                                            <div class="col-lg-12 col-xl-11">
                                                <div class="card text-black" style="border-radius: 25px;">
                                                    <div class="card-body p-md-5">
                                                        <div class="row justify-content-center">
                                                            <div class="col-md-13 col-lg-6 col-xl-10 order-4 order-lg-1">
                                                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">
                                                                    Sign In</p>
                                                                <form class="mx-1 mx-md-6" action="signinconnection.php" method="POST">
                                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                                        <div class="form-outline flex-fill mb-2">
                                                                            <input type="email" id="email" name="email" placeholder="email" required class="form-control" />
                                                                            <label class="form-label" for="email"><h3>Your Email</h3></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                                        <div class="form-outline flex-fill mb-2">
                                                                            <input type="password" id="password" name="password" placeholder="password" required class="form-control" />
                                                                            <label class="form-label" for="password"><h3>Password</h3></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex justify-content-center mx-6 mb-5 mb-lg-6">
                                                                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-10 col-lg-6 col-xl-4 d-flex align-items-center order-1 order-lg-2">
                                                                <img src="assets/authentication image/signup.jpg" class="img-fluid" alt="Signup page illustration">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Slider Area End -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>
