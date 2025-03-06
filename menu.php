<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
/* Add active class styling for bold and dark green color */
#navigation .active {
    color: #006400; /* Dark green color */
    font-weight: bold;
}
</style>

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
                                    <!-- Home link with active class -->
                                    <li><a href="index.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/') ? 'active' : ''; ?>">Home</a></li>

                                    <!-- About link with active class -->
                                    <li><a href="about.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/about.php') ? 'active' : ''; ?>">About</a></li>

                                    <!-- Services link with submenu -->
                                    <li><a href="services.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/services.php') ? 'active' : ''; ?>">Services</a>
                                        <ul class="submenu">
                                            <li><a href="index.php?pg=bloodsugardetails.php&option=view" class="<?php echo ($_SERVER['REQUEST_URI'] == '/index.php?pg=bloodsugardetails.php&option=view') ? 'active' : ''; ?>">Blood Sugar Details</a></li>
                                            <li><a href="index.php?pg=bloodpressuredetails.php&option=add" class="<?php echo ($_SERVER['REQUEST_URI'] == '/index.php?pg=bloodpressuredetails.php&option=add') ? 'active' : ''; ?>">Blood Pressure Details</a></li>
                                            <li><a href="index.php?pg=foodtable.php&option=add" class="<?php echo ($_SERVER['REQUEST_URI'] == '/index.php?pg=foodtable.php&option=add') ? 'active' : ''; ?>">Food Table</a></li>
                                        </ul>
                                    </li>

                                    <!-- Blog link with submenu -->
                                    <li><a href="blog.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/blog.php') ? 'active' : ''; ?>">Blog</a>
                                        <ul class="submenu">
                                            <li><a href="index.php?pg=patient_dashboard.php&option=add" class="<?php echo ($_SERVER['REQUEST_URI'] == '/index.php?pg=patient_dashboard.php&option=add') ? 'active' : ''; ?>">Patient</a></li>
                                            <li><a href="index.php?pg=staff.php&option=add" class="<?php echo ($_SERVER['REQUEST_URI'] == '/index.php?pg=staff.php&option=add') ? 'active' : ''; ?>">Staff</a></li>
                                            <li><a href="index.php?pg=staffdestination.php&option=add" class="<?php echo ($_SERVER['REQUEST_URI'] == '/index.php?pg=staffdestination.php&option=add') ? 'active' : ''; ?>">Staffdestination</a></li>
                                        </ul>
                                    </li>

                                    <!-- Contact link with active class -->
                                    <li><a href="contact.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/contact.php') ? 'active' : ''; ?>">Contact</a></li>

                                    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['name']) && isset($_SESSION['role'])): ?>
                                        <!-- Display Dashboard based on Role -->
                                        <?php if ($_SESSION['role'] === 'admin'): ?>
                                            <li><a href="admin_dashboard.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/admin_dashboard.php') ? 'active' : ''; ?>">Ad_Dashboard</a></li>
                                        <?php elseif ($_SESSION['role'] === 'user'): ?>
                                            <li><a href="patient_dashboard.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/patient_dashboard.php') ? 'active' : ''; ?>">Dashboard</a></li>
                                        <?php endif; ?>
                                        
                                        <li>
                                            <a href="#">
                                                Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>
                                            </a>
                                        </li>
                                        <li><a href="logout.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/logout.php') ? 'active' : ''; ?>">Sign Out</a></li>
                                    <?php else: ?>
                                        <!-- User is not logged in -->
                                        <li>
                                            <a href="#">Create Account</a>
                                            <ul class="submenu">
                                                <li><a href="Signup.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/Signup.php') ? 'active' : ''; ?>">Sign Up</a></li>
                                                <li><a href="Signin.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/Signin.php') ? 'active' : ''; ?>">Sign In</a></li>
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
