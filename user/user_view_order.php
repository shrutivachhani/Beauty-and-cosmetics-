<?php
session_start();
include_once("userheader.php");
include_once("db_connection.php");

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: register1.php");
    exit;
}

$email = $_SESSION['email'];

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];

    // Fetch order details
    $orders = "SELECT * FROM orders WHERE sub_order_id='$id'";
    $order_result = mysqli_query($con, $orders);

    while ($order_detail = mysqli_fetch_assoc($order_result)) {
        $product_id = $order_detail['product_id'];

        // Fetch product details
        $product_query = "SELECT image FROM products WHERE id='$product_id'";
        $product_result = mysqli_fetch_assoc(mysqli_query($con, $product_query));
?>

<div class="container my-5">
    <div class="row text-center mb-4">
        <div class="col-12 bg-dark text-white py-3">
            <h2>Order ID: <?php echo $order_detail['order_id']; ?></h2>
        </div>
    </div>

    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-3 col-md-4 col-sm-12 mb-3 text-center">
            <img src="<?php echo $product_result['image']; ?>" alt="Product Image" class="img-fluid shadow rounded">
        </div>

        <!-- Product Details -->
        <div class="col-lg-4 col-md-8 col-sm-12">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-dark text-white">
                    <h5>Product Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Product ID:</strong> <?php echo $order_detail['product_id']; ?></p>
                    <p><strong>Quantity:</strong> <?php echo $order_detail['quantity']; ?></p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5>Payment Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total Amount:</strong> ₹<?php echo $order_detail['total_amount']; ?></p>
                    <p><strong>Payment Status:</strong> 
                        <span class="badge bg-<?php echo $order_detail['payment_status'] === 'Paid' ? 'success' : 'warning'; ?>">
                            <?php echo $order_detail['payment_status']; ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Delivery and Order Info -->
        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-dark text-white">
                    <h5>Delivery Address</h5>
                </div>
                <div class="card-body">
                    <p><?php echo $order_detail['delivery_address']; ?></p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5>Order Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Order Date:</strong> <?php echo date('d M Y, H:i', strtotime($order_detail['created_at'])); ?></p>
                    <p><strong>Order Status:</strong>
                        <span class="badge bg-<?php echo $order_detail['delivery_status'] === 'Delivered' ? 'success' : 'secondary'; ?>">
                            <?php echo $order_detail['delivery_status']; ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }
}
include_once("footer.php");
?>
