<?php
session_start();

include 'header.php'; 
include 'adminconnection.php';

$order_id = intval($_GET['order_id']);

// Fetch order details
$order_query = "SELECT * FROM orders WHERE id = $order_id";
$order_result = mysqli_query($con, $order_query);
$order = mysqli_fetch_assoc($order_result);

// Fetch order items
$items_query = "SELECT * FROM order_items WHERE order_id = $order_id";
$items_result = mysqli_query($con, $items_query);
?>

<div class="container">
    <h1>Order #<?php echo $order_id; ?></h1>
    <p>Customer: <?php echo $order['first_name'] . ' ' . $order['last_name']; ?></p>
    <p>Email: <?php echo $order['email']; ?></p>
    <p>Phone: <?php echo $order['phone']; ?></p>
    <p>Address: <?php echo $order['address']; ?>, <?php echo $order['state']; ?>, <?php echo $order['zip']; ?></p>
    <p>Total Amount: Rs. <?php echo $order['total_amount']; ?></p>

    <h3>Order Items</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($item = mysqli_fetch_assoc($items_result)) {
                echo "<tr>
                    <td>{$item['product_id']}</td>
                    <td>{$item['quantity']}</td>
                    <td>Rs. {$item['price']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include 'footer.php';
?>
