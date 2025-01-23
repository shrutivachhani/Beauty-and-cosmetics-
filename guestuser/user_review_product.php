<?php
session_start();
require 'db_connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'];

// Check if `id` parameter is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request. No order selected.";
    exit;
}

$sub_order_id = $_GET['id'];

// Fetch product and order details
$query = "
    SELECT 
        o.sub_order_id, 
        o.order_id, 
        o.product_id, 
        p.name AS product_name, 
        p.image AS product_image 
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE o.sub_order_id = '$sub_order_id' AND o.email = '$user_email'
";
$result = $con->query($query);

if ($result->num_rows === 0) {
    echo "No matching order found.";
    exit;
}

$order_details = $result->fetch_assoc();

// Handle review form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'] ?? 0;
    $review = $con->real_escape_string($_POST['review'] ?? '');

    if ($rating < 1 || $rating > 5) {
        $error_message = "Please select a valid rating between 1 and 5.";
    } elseif (empty($review)) {
        $error_message = "Review cannot be empty.";
    } else {
        $insert_query = "
            INSERT INTO reviews (sub_order_id, product_id, email, rating, review, created_at)
            VALUES ('$sub_order_id', '{$order_details['product_id']}', '$user_email', '$rating', '$review', NOW())
        ";
        if ($con->query($insert_query)) {
            $success_message = "Your review has been submitted successfully!";
        } else {
            $error_message = "Error submitting review. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #444;
        }

        .product-info {
            text-align: center;
        }

        .product-info img {
            max-width: 100px;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group textarea {
            resize: vertical;
        }

        .btn-submit {
            display: block;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            font-size: 16px;
            margin-top: 20px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Submit Your Review</h1>

        <div class="product-info">
            <img src="<?= $order_details['product_image'] ?>" alt="<?= $order_details['product_name'] ?>">
            <h2><?= $order_details['product_name'] ?></h2>
        </div>

        <?php if (isset($error_message)): ?>
            <div class="message error"><?= $error_message ?></div>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <div class="message success"><?= $success_message ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="rating">Rating (1 to 5):</label>
                <select name="rating" id="rating" required>
                    <option value="" disabled selected>Select Rating</option>
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>

            <div class="form-group">
                <label for="review">Your Review:</label>
                <textarea name="review" id="review" rows="5" placeholder="Write your review here..." required></textarea>
            </div>

            <button type="submit" class="btn-submit">Submit Review</button>
        </form>
    </div>
</body>
</html>
