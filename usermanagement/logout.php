<?php
session_start();
session_unset(); // remove all session variables
session_destroy(); // destroy the session
header("Location: /smartshelf/index.php"); // redirect to the login page
exit;
?>
