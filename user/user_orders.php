<?php
session_start();
require 'db_connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'];

// Join orders with products to fetch product images
$query = "
    SELECT 
        o.order_id, 
        o.sub_order_id, 
        o.product_id, 
        o.quantity, 
        o.total_amount, 
        o.payment_mode, 
        p.image 
    FROM orders o 
    JOIN products p 
    ON o.product_id = p.id 
    WHERE o.email = '$user_email'
";
$result = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <style>
        /* CSS for User Orders Page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #444;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 12px;
        }

        table th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        .btn-view {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-view:hover {
            background-color: #45a049;
        }

        img {
            height: 50px;
            border-radius: 4px;
        }
        .btn-shopping {
            display: block;
            width: fit-content;
            margin: 20px auto;
            background-color: #008CBA;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }

        .btn-shopping:hover {
            background-color: #007BB5;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            table th, table td {
                padding: 8px;
            }

            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Orders</h1>
        <table>
            <tr>
                <th>Product Image</th>
                <th>Order ID</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>View Details</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <!-- Display product image -->
                    <td><img src="<?php echo $row['image']; ?>" alt="Product Image"></td>
                    <td><?= $row['order_id'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td>₹<?= $row['total_amount'] ?></td>
                    <td>
                        <!-- View Details Button -->
                        <a href="user_view_order.php?id=<?= $row['sub_order_id'] ?>" class="btn-view">View</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
         <!-- Continue Shopping Button -->
         <a href="index.php" class="btn-shopping">Continue Shopping</a>
    </div>
</body>
</html>
