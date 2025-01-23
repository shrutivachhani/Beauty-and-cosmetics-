<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

$sql = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('ii', $user_id, $product_id);

if ($stmt->execute()) {
    echo "Product removed from wishlist.";
} else {
    echo "Error removing product.";
}

$con->close();
header('Location: wishlist.php');
?>
