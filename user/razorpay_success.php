<?php
session_start();
require 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$razorpay_payment_id = $data['razorpay_payment_id'] ?? '';
$razorpay_order_id = $data['razorpay_order_id'] ?? '';

if ($razorpay_payment_id && $razorpay_order_id) {
    $stmt = $con->prepare("
        INSERT INTO orders (order_id, user_id, address, total_amount, payment_mode, status) 
        VALUES (?, ?, ?, ?, 'Online', 'Paid')
    ");
    $user_id = $_SESSION['user_id'];
    $address = $_SESSION['address'];
    $total = $_SESSION['total'];
    $stmt->bind_param("sisd", $razorpay_order_id, $user_id, $address, $total);
    $stmt->execute();
    echo "success";
} else {
    echo "Payment verification failed.";
}
?>
