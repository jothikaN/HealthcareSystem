<?php
session_start();      // Start the session
session_destroy();    // Destroy all session data
header("Location: Signin.php"); // Redirect to the sign-in page (adjust as needed)
exit();
?>
