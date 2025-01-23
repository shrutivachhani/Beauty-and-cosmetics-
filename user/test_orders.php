<?php
session_start();
include_once("db_connection.php");







    // Payment verified, process the order
    $email = 'vachhanishruti2003@gmail.com'; // Assuming 'user' stores the logged-in 
    $address = $_SESSION['address'];
    $order_id = $_SESSION['order_id'];
    $total = $_SESSION['total'];
    $order_array = $_SESSION['order_array'];

    $order_total = $order_array['total'];
    $order_discount = $order_array['discount'];
    $offer_code = $order_array['offer_code'];
    
     echo($email);
     echo($address);
     echo($order_id);
     echo($total);
     print_r($order_array);
     echo($order_total);
     echo($order_discount);
     echo($offer_code);

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
        $total_price = $cart_row['total_price'];

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
        $discount_amount = ($total_price / $order_total) * $order_discount;
        $actual_price = $total_price - $discount_amount;

        // Insert order into database
        $insert_order_query = "
            INSERT INTO orders 
            (order_id, sub_order_id, product_id, quantity, email, delivery_address, total_amount, offer_name, discount_amount, actual_amount) 
            VALUES 
            ('$razorpay_order_id', '$razorpay_order_id-$product_id', $product_id, $quantity, '$email', '$address', $total_price, '$offer_code', $discount_amount, $actual_price)";
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


   
?>