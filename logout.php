<?php
session_start();
$update_message = isset($_SESSION['update_message']) ? $_SESSION['update_message'] : '';
session_unset();
session_destroy();

session_start();
if (!empty($update_message)) {
    $_SESSION['update_message'] = $update_message;
}

header("Location: login.php");
exit;
?>
