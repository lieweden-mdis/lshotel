<?php
// Start session (if not already started)
session_start();

// Destroy all session data
session_destroy();

// Redirect to login page or any other page after logout
header("Location: index.php");
exit();
?>