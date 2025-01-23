<?php
include_once("adminconnection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the user
    $deleteQuery = "DELETE FROM registration WHERE id=$id";
    if (mysqli_query($con, $deleteQuery)) {
        echo "<script>alert('User deleted successfully'); window.location.href='manage_user.php';</script>";
    } else {
        echo "<script>alert('Error deleting user');</script>";
    }
}
?>
