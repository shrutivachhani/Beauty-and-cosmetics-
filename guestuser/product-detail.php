<?php
session_start(); // Start session to manage cart

include 'db_connection.php'; // Include the database connection file

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // Fetch product details from the database based on the ID
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the product exists
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Calculate discounted price
        $discount = $product['discount'] ?? 0; // Default to 0 if no discount
        $original_price = $product['price'];
        $discounted_price = $original_price - ($original_price * $discount / 100);
    } else {
        echo "<p>Product not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid product ID.</p>";
    exit();
}

// Handle adding product to the cart
if (isset($_POST['add_to_cart'])) {
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    // Retrieve user ID and email from the session
    $user_id = $_SESSION['user_id'] ?? null;
    $email = $_SESSION['email'] ?? null;

    if (!$user_id || !$email) {
        // Redirect user to login if not logged in
        echo "<script>
                alert('Please log in first.');
                window.location.href = 'login.php'; 
              </script>";
        exit();
    }

    // Fetch product details for insertion into the cart
    $stmt = $con->prepare("SELECT name, image, price, description FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();

    if ($product_result->num_rows > 0) {
        $product_data = $product_result->fetch_assoc();
        $name = $product_data['name'];
        $image = $product_data['image'];
        $price = $product_data['price'];
        $description = $product_data['description'];
    } else {
        echo "<p>Product details could not be retrieved.</p>";
        exit();
    }

    // Check if the product is already in the cart for this user
    $stmt = $con->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the product already exists in the cart, update the quantity
        $stmt = $con->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    } else {
        // Otherwise, insert a new row into the cart table
        
    }
    $stmt->execute();

    echo "<script>alert('Please login first.');</script>";
    
}

// Include header after session logic
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="productdetail.css">
    <style>
        .original-price {
            text-decoration: line-through;
            color: gray;
            font-size: 0.9rem;
        }

        .discounted-price {
            color: #d9534f;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .discount-percentage {
            color: #28a745;
            font-size: 0.9rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <main>
        <div class="product-container">
            <div class="product-image">
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
            <div class="product-details">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <p class="product-description">
                    <?= !empty($product['description']) ? htmlspecialchars($product['description']) : 'No description available.' ?>
                </p>
                <p class="product-price">
                    <?php if ($discount > 0): ?>
                        <span class="original-price">Price: Rs. <?= number_format($original_price, 2) ?></span><br>
                        <span class="discount-percentage"><?= $discount ?>% Discount</span><br>
                        <span class="discounted-price">Price: Rs. <?= number_format($discounted_price, 2) ?></span>
                    <?php else: ?>
                        <span class="discounted-price">Price: Rs. <?= number_format($original_price, 2) ?></span>
                    <?php endif; ?>
                </p>

                <!-- Add to Cart Form -->
                <form method="POST">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" style="width: 50px;">
                    <button class="add-to-cart" type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>

<br><br><br>

<?php
include 'footer.php';
?>
