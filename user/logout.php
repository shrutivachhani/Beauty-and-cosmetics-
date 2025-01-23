<?php
session_start();
// Destroy the session to log out the user
session_destroy();
// Redirect to the guestuser/index.php page after logout
header("Location: ../guestuser/index.php");
exit();
?>
