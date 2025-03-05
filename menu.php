<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Header Start -->
<div class="header-area">
    <div class="main-header header-sticky">
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-xl-2 col-lg-2 col-md-1">
                    <div class="logo">
                        <a href="index.php"><img src="assets/img/logo/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-10 col-md-10">
                    <div class="menu-main d-flex align-items-center justify-content-end">
                        <!-- Main-menu -->
                        <div class="main-menu f-right d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                 
                                    <li><a href="about.php">About</a></li>
                                    <li><a href="services.php">Services</a>
                                        <ul class="submenu">
                                            <li><a href="index.php?pg=bloodsugardetails.php&option=view">Blood Sugar Details</a></li>
                                            <li><a href="index.php?pg=bloodpressuredetails.php&option=add">Blood Pressure Details</a></li>
                                            <li><a href="index.php?pg=foodtable.php&option=add">Food Table</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="blog.php">Blog</a>
                                        <ul class="submenu">
                                            <li><a href="index.php?pg=patient_dashboard.php&option=add">Patient</a></li>
                                            <li><a href="index.php?pg=staff.php&option=add">Staff</a></li>
                                            <li><a href="index.php?pg=staffdestination.php&option=add">Staffdestination</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.php">Contact</a></li>

                                    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['name']) && isset($_SESSION['role'])): ?>
                                        <!-- Display Dashboard based on Role -->
                                        <?php if ($_SESSION['role'] === 'admin'): ?>
                                            <li><a href="admin_dashboard.php">Ad_Dashboard</a></li>
                                        <?php elseif ($_SESSION['role'] === 'user'): ?>
                                            <li><a href="patient_dashboard.php">Dashboard</a></li>
                                        <?php endif; ?>
                                        
                                        <li>
                                            <a href="#">
                                                Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>
                                            </a>
                                        </li>
                                        <li><a href="logout.php">Sign Out</a></li>
                                    <?php else: ?>
                                        <!-- User is not logged in -->
                                        <li>
                                            <a href="#">Create Account</a>
                                            <ul class="submenu">
                                                <li><a href="Signup.php">Sign Up</a></li>
                                                <li><a href="Signin.php">Sign In</a></li>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
         
            
                <!-- Mobile Menu -->
                <div class="col-12">
                    <div class="mobile_menu d-block d-lg-none"></div>
                </div>
            </div>
        </div>
    </div>
</div>

