<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>



<!--? Header Start -->
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
</head>

<body>
    <div class="header-area">
        <div class="main-header header-sticky">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-xl-2 col-lg-2 col-md-1">
                        <div class="logo">
                            <a href="index.html"><img src="assets/img/logo/logo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10">
                        <div class="menu-main d-flex align-items-center justify-content-end">
                            <!-- Main-menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="about.php">About</a></li>
                                        <li><a href="services.php">Services</a>
                                            <ul class="submenu">
                                                <li><a href="index.php?pg=bloodsugardetails.php&option=add">Blood Sugar
                                                        Details</a></li>
                                                <li><a href="index.php?pg=bloodpressuredetails.php&option=add">Blood
                                                        Pressure Details</a></li>
                                                <li><a href="index.php?pg=foodtable.php&option=add">foodtable</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="blog.php">Blog</a>
                                            <ul class="submenu">
                                                <li><a href="index.php?pg=patient.php&option=add">Patient</a></li>
                                                <li><a href="index.php?pg=staff.php&option=add">Staff</a></li>
                                                <li><a
                                                        href="index.php?pg=staffdestination.php&option=add">Staffdestination</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="suggestion.php">Suggestion</a>
                                            <ul class="submenu">
                                                <li><a href="index.php?pg=medicaldetails.php&option=add">Medical
                                                        Details</a>
                                                </li>
                                                <li><a href="index.php?pg=maintainsuggestiondetails.php&option=add">Maintain
                                                        Suggestion Details</a></li>
                                                <li><a href="index.php?pg=systemsuggestion.php&option=add">System
                                                        Suggestion</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="contact.php">Contact</a></li>
                                        <li><a href="">Create Account</a>
                                            <ul class="submenu">
                                                <li><a href="Signup.php">Sign Up</a></li>
                                                <li><a href="Signin.php">Sign In</a></li>

                                        </li>
                                    </ul>
                                    </li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--? Slider Area Start-->
    <div class="slider-area">
        <div class="slider-active dot-style">
            <!-- Slider Single -->
            <div class="single-slider d-flex align-items-center slider-height">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-7 col-lg-8 col-md-10 ">
                            <div class="hero-wrapper">


                                <div class="hero__caption">
                                    <h1>
                                        <center>Healthy Life.</center>
                                    </h1>


                                    <div class="container h-100">
                                        <div class="row d-flex justify-content-center align-items-center h-100">
                                            <div class="col-lg-8 col-xl-10">
                                                <div class="card text-black" style="border-radius: 25px;">
                                                    <div class="card-body p-md-3">
                                                        <div class="row justify-content-center">

                                                            <div class="col-md-6 col-lg-4 col-xl-10 order-4 order-lg-1">

                                                                <p
                                                                    class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">
                                                                    Sign Up</p>

                                                                <form class="mx-1 mx-md-6" action="signupconnection.php"
                                                                    method="POST">

                                                                    <div
                                                                        class="d-flex flex-row align-items-center mb-4">
                                                                        <i class="fas fa-user fa-lg me-2 fa-fw"></i>
                                                                        <div data-mdb-input-init
                                                                            class="form-outline flex-fill mb-2">
                                                                            <input type="text" id="name" name="name"
                                                                                placeholder="Name" required
                                                                                class="form-control" />
                                                                            <label class="form-label" for="name"><h3>Your
                                                                                Name</h3></label>
                                                                        </div>
                                                                    </div>

                                                                    <div
                                                                        class="d-flex flex-row align-items-center mb-4">
                                                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                                        <div data-mdb-input-init
                                                                            class="form-outline flex-fill mb-2">
                                                                            <input type="email" id="mail" name="email"
                                                                                placeholder="Email" required
                                                                                class="form-control" />
                                                                            <label class="form-label" for="mail"><h3>Your
                                                                                Email</h3></label>
                                                                        </div>
                                                                    </div>

                                                                    <div
                                                                        class="d-flex flex-row align-items-center mb-4">
                                                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                                        <div data-mdb-input-init
                                                                            class="form-outline flex-fill mb-2">
                                                                            <input type="password" id="password"
                                                                                name="password" placeholder="Password"
                                                                                required class="form-control" />
                                                                            <label class="form-label"
                                                                                for="password"><h3>Password</h3></label>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                              <p>You have already an account sign in here. <a href="signin.php"><u>Sign in</u></a></p> 
                                                             
                                                            </div>
                                                                    <div
                                                                        class="d-flex justify-content-center mx-6 mb-5 mb-lg-6">
                                                                        <button type="submit" data-mdb-button-init
                                                                            data-mdb-ripple-init
                                                                            class="btn btn-primary btn-lg">Register</button>
                                                                    </div>

                                                                </form>

                                                            </div>
                                                            <div
                                                                class="col-md-10 col-lg-6 col-xl-3 d-flex align-items-center order-1 order-lg-1">
                                                                <img src="assets/authentication image/signup.jpg"
                                                                    class="img-fluid" alt="Signup page illustration">
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

</body>

</html>
<!-- Header End -->