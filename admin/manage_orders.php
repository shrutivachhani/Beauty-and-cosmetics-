<?php
session_start();

include 'header.php'; // Admin header file
include 'adminconnection.php'; // Database connection

// Fetch orders from database
$query = "SELECT * FROM orders ORDER BY order_date DESC";
$result = mysqli_query($con, $query);

?>

<div class="container">
    <h1>Manage Orders</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Total Amount</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($order = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$order['id']}</td>
                    <td>{$order['first_name']} {$order['last_name']}</td>
                    <td>{$order['email']}</td>
                    <td>Rs. {$order['total_amount']}</td>
                    <td>{$order['order_date']}</td>
                    <td><a href='view_order.php?order_id={$order['id']}' class='btn btn-primary'>View</a></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include 'footer.php';
?>
