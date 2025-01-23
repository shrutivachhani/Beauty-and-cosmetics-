<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in
$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    echo "User is not logged in.";
    exit();
}

// Get the selected address ID
if (isset($_POST['address_id'])) {
    $address_id = $_POST['address_id'];

    // Store the selected address in the session for checkout
    $_SESSION['selected_address_id'] = $address_id;

    echo "Address selected successfully";
} else {
    echo "No address ID received";
}
?>
