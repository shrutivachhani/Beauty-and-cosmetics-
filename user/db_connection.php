<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mca_2024-25'; // Replace with your actual database name

$con = mysqli_connect($host, $user, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
