<?php
session_start();
require 'db_connection.php';
require '../vendor/autoload.php';

use Razorpay\Api\Api;

$payment_mode = $_POST['payment_mode'] ?? '';
$total = $_SESSION['total'] ?? 0;
$address_id = $_SESSION['selected_address_id'] ?? 0;
$email = $_SESSION['email'] ?? 0;

if (!$address_id || !$total || !$email || !$payment_mode) {
    echo "Invalid request.";
    exit();
}

// Fetch address
$stmt = $con->prepare("SELECT delivery_address FROM address WHERE id = ?");
$stmt->bind_param("i", $address_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "Invalid address.";
    exit();
}
$address = $result->fetch_assoc()['delivery_address'];

if ($payment_mode === 'cod') {
    // Handle COD order
    $order_id = "COD" . time();
    $stmt = $con->prepare("
        INSERT INTO orders (order_id, email, delivery_address, total_amount, payment_mode, delivery_status) 
        VALUES (?, ?, ?, ?, 'COD', 'Pending')
    ");
    $stmt->bind_param("sisd", $order_id, $email, $delivery_address, $total);
    $stmt->execute();
    header("Location: user_orders.php");
    exit();
} elseif ($payment_mode === 'pay_online') {
    // Handle Razorpay payment
    $api_key = 'rzp_test_iicY1ZqsBx3QED';
    $api_secret = 'kB89nJEPSKHaTn3ca3TrC6Y3';
    $api = new Api($api_key, $api_secret);

    try {
        $razorpay_order = $api->order->create([
            'receipt' => 'order_' . time(),
            'amount' => $total * 100, // Amount in paise
            'currency' => 'INR'
        ]);
        $_SESSION['razorpay_order_id'] = $razorpay_order->id;
        $_SESSION['address'] = $address;
        header("Location: razorpay_checkout.php");
        exit();
    } catch (Exception $e) {
        echo "Razorpay Error: " . $e->getMessage();
        exit();
    }
}
?>
