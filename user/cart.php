<?php
session_start();
ob_start(); // Start output buffering
include 'db_connection.php';  // Database connection
include 'userheader.php';  // User header

// Check if the user is logged in
$user_id = $_SESSION['user_id'] ?? 0;
$email = $_SESSION['email'] ?? ''; // Assuming the user's email is stored in the session
if (!$user_id || !$email) {
    header('Location: login.php');
    exit();
}

// Initialize subtotal and total discount
$subtotal = 0;
$total_discount = 0;

// Fetch cart items for the logged-in user
$cart_items = [];
$stmt = $con->prepare("SELECT c.product_id, c.quantity, p.name, p.image, p.price, p.discount FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;

    $original_price = $row['price'];
    $discount = $row['discount'] ?? 0;
    $discounted_price = $original_price - ($original_price * $discount / 100);
    $discount_amount = $original_price * $discount / 100;

    $subtotal += $discounted_price * $row['quantity'];
    $total_discount += $discount_amount * $row['quantity'];
}

// Save final total for the payment page
$_SESSION['total'] = $subtotal;

// Handle removing an item from the cart
if (isset($_GET['remove'])) {
    $product_id = intval($_GET['remove']);
    $stmt = $con->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();

    // Redirect to refresh the cart page
    header('Location: cart.php');
    exit();
}

// Handle updating the quantity of a product in the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $product_id = intval($_POST['product_id']);
    $new_quantity = intval($_POST['quantity']);

    if ($new_quantity > 0) {
        $stmt = $con->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
        $stmt->execute();
    }

    // Redirect to avoid form resubmission
    header('Location: cart.php');
    exit();
}

// Handle address selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_address_id'])) {
    $selected_address_id = intval($_POST['selected_address_id']);
    $_SESSION['selected_address_id'] = $selected_address_id;

    // Redirect to avoid form resubmission
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        .card {
            border: 2px solid black;
            padding: 10px;
            margin-bottom: 10px;
        }

        .card.selected {
            border-color: green;
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-control button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
        }

        .quantity-control input {
            width: 60px;
            text-align: center;
            font-size: 16px;
            padding: 5px;
            margin: 0 5px;
        }

        .quantity-control button:focus {
            outline: none;
        }

        .remove-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Original Price</th>
                        <th>Discount (%)</th>
                        <th>Discounted Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <?php
                        $original_price = $item['price'];
                        $discount = $item['discount'] ?? 0;
                        $discounted_price = $original_price - ($original_price * $discount / 100);
                        $total_price = $discounted_price * $item['quantity'];
                        ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="Product" style="width: 100px;"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>Rs. <?= number_format($original_price, 2) ?></td>
                            <td><?= $discount ?>%</td>
                            <td>Rs. <?= number_format($discounted_price, 2) ?></td>
                            <td>
                                <!-- Quantity Control -->
                                <form action="cart.php" method="post" style="display:inline;">
                                    <div class="quantity-control">
                                        <button type="button" onclick="updateQuantity(<?= $item['product_id'] ?>, -1)">-</button>
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" id="quantity-<?= $item['product_id'] ?>" readonly>
                                        <button type="button" onclick="updateQuantity(<?= $item['product_id'] ?>, 1)">+</button>
                                    </div>
                                    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                    <input type="hidden" name="update_quantity" value="1">
                                </form>
                            </td>
                            <td>Rs. <?= number_format($total_price, 2) ?></td>
                            <td>
                                <!-- Remove Item -->
                                <form action="cart.php" method="get" style="display:inline;">
                                    <input type="hidden" name="remove" value="<?= $item['product_id'] ?>">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Subtotal: Rs. <?= number_format($subtotal, 2) ?></h3>
            <h3>Total Discount: Rs. <?= number_format($total_discount, 2) ?></h3>
            <h3>Final Total: Rs. <?= number_format($subtotal, 2) ?></h3>
        <?php endif; ?>

        <h3>Select Shipping Address</h3>
        <form method="POST">
            <div class="row">
                <?php
                // Fetch addresses from the database
                $address_query = "SELECT * FROM address WHERE email = ?";
                $stmt = $con->prepare($address_query);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result_address = $stmt->get_result();

                while ($r_address = $result_address->fetch_assoc()): 
                    $is_selected = ($_SESSION['selected_address_id'] ?? 0) == $r_address['id'];
                ?>
                    <div class="col-6">
                        <div class="card <?= $is_selected ? 'selected' : ''; ?>">
                            <?= htmlspecialchars($r_address['delivery_address']); ?>
                        </div>
                        <br>
                        <button 
                            type="submit" 
                            name="selected_address_id" 
                            value="<?= $r_address['id']; ?>" 
                            class="btn btn-dark <?= $is_selected ? 'disabled' : '' ?>">
                            <?= $is_selected ? 'Selected' : 'Deliver to this Address' ?>
                        </button>
                    </div>
                <?php endwhile; ?>
            </div>
        </form>

        <br>
        <a href="add_delivery_address.php"><button class="btn btn-dark">Add New Address</button></a>
        <br><br>
        <form action="payment_razorpay_action.php" method="post">
                        <div class="form-group">
                            <label for="gen1"><b>Select Payment Method</b></label>
                            <br>
                            <div class="radio-group">
                            <label for="cod">Cash on Delivery</label>
    <input type="radio" id="cod" name="payment_mode" value="cod" required>
    
    <label for="online">Online Payment</label>
    <input type="radio" id="online" name="payment_mode" value="online" required>
                                <span id="gen_err" class="radio-error"></span>
                            </div>
                        </div>
                        <br>

                        <input type="hidden" name="payment" value="1">
            <input type="hidden" name="address_id" value="<?= $_SESSION['selected_address_id'] ?? 0; ?>">
            <input type="submit" class="btn btn-primary" value="Proceed to Checkout" name="payment">

                    </form>

        
    </div>

    <script>
        function updateQuantity(productId, delta) {
            var quantityInput = document.getElementById("quantity-" + productId);
            var currentQuantity = parseInt(quantityInput.value);

            if (currentQuantity + delta > 0) {
                quantityInput.value = currentQuantity + delta;

                // Submit the form after updating the quantity
                var form = quantityInput.closest('form');
                form.submit();
            }
        }
    </script>
</body>
</html>
