<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Clear the session and destroy it
    session_unset();
    session_destroy();
}

// Redirect to the dashboard page
header("Location: dashboard.php");
exit();
?>
