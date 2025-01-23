<?php
session_start();
include_once("db_connection.php");
require '../vendor/autoload.php';

use Razorpay\Api\Api;

// Razorpay API credentials
$api_key = 'rzp_test_iicY1ZqsBx3QED';
$api_secret = 'kB89nJEPSKHaTn3ca3TrC6Y3'; 
$api = new Api($api_key, $api_secret);

// Fetch payment details from the client
$razorpay_payment_id = $_POST['razorpay_payment_id'];
$razorpay_order_id = $_POST['razorpay_order_id'];
$razorpay_signature = $_POST['razorpay_signature'];

try {
    // Verify payment signature
    $attributes = [
        'razorpay_order_id' => $razorpay_order_id,
        'razorpay_payment_id' => $razorpay_payment_id,
        'razorpay_signature' => $razorpay_signature
    ];
    $api->utility->verifyPaymentSignature($attributes);

    // Payment verified, process the order
    $order_id = $_SESSION['order_id'];
    $email = $_SESSION['email']; // Assuming 'user' stores the logged-in email
    $address = $_SESSION['address'];
    $order_id = $_SESSION['order_id'];
    $total = $_SESSION['total'];
   
  

    // Fetch cart items for the user
    $cart_query = "SELECT * FROM cart WHERE email = '$email'";
    $cart_result = mysqli_query($con, $cart_query);

    if (!$cart_result || mysqli_num_rows($cart_result) == 0) {
        throw new Exception("Cart is empty or could not be fetched.");
    }

    // Loop through each cart item and process the order
    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
        $product_id = $cart_row['product_id'];
        $quantity = $cart_row['quantity'];
        $total_price =  $_SESSION['total'];

        // Fetch product details
        $product_query = "SELECT * FROM products WHERE id = $product_id";
        $product_result = mysqli_query($con, $product_query);

        if (!$product_result || mysqli_num_rows($product_result) == 0) {
            throw new Exception("Product ID $product_id not found.");
        }

        $product = mysqli_fetch_assoc($product_result);

        // Check stock availability
        if ($product['quantity'] < $quantity) {
            throw new Exception("Insufficient stock for Product ID $product_id.");
        }

        // Calculate discount and actual price
        // $discount_amount = ($total_price / $order_total) * $order_discount;
        // $actual_price = $total_price - $discount_amount;

        // Insert order into database
        $insert_order_query = "
            INSERT INTO orders 
            (order_id, sub_order_id, product_id, quantity, email, delivery_address, total_amount) 
            VALUES 
            ('$razorpay_order_id', '$razorpay_order_id-$product_id', $product_id, $quantity, '$email', '$address', $total_price)";
        //echo($insert_order_query);
        if (!mysqli_query($con, $insert_order_query)) {
            throw new Exception("Error inserting order: " . mysqli_error($con));
        }

        // Update product stock
        $remaining_stock = $product['quantity'] - $quantity;
        $update_stock_query = "UPDATE products SET quantity = $remaining_stock WHERE id = $product_id";

        if (!mysqli_query($con, $update_stock_query)) {
            throw new Exception("Error updating stock for Product ID $product_id: " . mysqli_error($con));
        }

        // Remove item from cart
        $delete_cart_query = "DELETE FROM cart WHERE email = '$email' AND product_id = $product_id";

        if (!mysqli_query($con, $delete_cart_query)) {
            throw new Exception("Error deleting cart item for Product ID $product_id: " . mysqli_error($con));
        }
    }


    // If everything is successful, return success response
    echo "success";
} catch (Exception $e) {
    // Handle exceptions and rollback if needed
    error_log("Error processing payment: " . $e->getMessage());
    echo "error: " . $e->getMessage();
}

?>