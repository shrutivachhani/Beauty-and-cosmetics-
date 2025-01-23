<?php
// Include the user header and database connection
session_start();

include 'userheader.php';
include 'db_connection.php';

// Start session to get the user ID

// Check if the user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Shop</h1>
                </div>
            </div>
            <div class="col-lg-7"></div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<style>
    body {
        background-color: #f8f9fa;
    }

    .product-container {
        margin: 40px auto;
        max-width: 1200px;
        padding: 20px;
    }

    .product-item {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-bottom: 30px;
        padding: 30px;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .product-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
    }

    .product-item img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
        border-radius: 10px;
    }

    .product-item h3 {
        font-size: 1.8rem;
        margin: 15px 0;
    }

    .product-item p {
        font-size: 1.4rem;
        color: #6c757d;
    }

    .product-price .original-price {
        text-decoration: line-through;
        color: gray;
        font-size: 1.1rem;
    }

    .product-price .discounted-price {
        font-size: 1.5rem;
        color: #d9534f; /* Bootstrap danger color */
        font-weight: bold;
    }

    .product-price .discount-percentage {
        color: #28a745; /* Bootstrap success color */
        font-size: 1.1rem;
        font-weight: bold;
    }

    .wishlist-icon-form {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        display: inline-block;
    }

    .wishlist-icon {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        outline: none;
    }

    .wishlist-icon img {
        width: 30px;
        height: 30px;
        filter: drop-shadow(0 0 3px rgba(0, 0, 0, 0.5));
    }

    .wishlist-icon.filled img {
        filter: brightness(1.2);
        content: url('images/wishlist-filled-icon.svg'); /* Red heart icon */
    }

    .out-of-stock-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #d9534f; /* Bootstrap danger color */
        color: #fff;
        padding: 5px 10px;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 5px;
    }

    .out-of-stock {
        opacity: 0.6;
    }
</style>

<div class="product-container">
    <div class="container">
        <h1 class="text-center mb-4">Shop</h1>
        <div class="row">
        <?php
// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Output data for each product
    while ($row = $result->fetch_assoc()) {
        // Calculate discounted price
        $discount = $row['discount'] ?? 0; // Default to 0% discount
        $original_price = $row['price'];
        $discounted_price = $original_price - ($original_price * $discount / 100);

        // Check if product is out of stock
        $is_out_of_stock = $row['quantity'] <= 0;

        // Check if product is already in the wishlist
        $is_in_wishlist = false;
        if ($user_id) {
            $wishlist_check_sql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
            $wishlist_check_stmt = $con->prepare($wishlist_check_sql);
            $wishlist_check_stmt->bind_param("ii", $user_id, $row['id']);
            $wishlist_check_stmt->execute();
            $wishlist_check_result = $wishlist_check_stmt->get_result();
            $is_in_wishlist = $wishlist_check_result->num_rows > 0;
        }

        echo '
        <div class="col-12 col-md-6 col-lg-4">
            <div class="product-item ' . ($is_out_of_stock ? 'out-of-stock' : '') . '">';

        // Display out-of-stock badge
        if ($is_out_of_stock) {
            echo '
                <span class="out-of-stock-badge">Out of Stock</span>
            ';
        }

        // Display product thumbnail and wishlist icon
        echo '
                <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
                <form method="POST" action="add-to-wishlist.php" class="wishlist-icon-form">
                    <input type="hidden" name="product_id" value="' . htmlspecialchars($row['id']) . '">
                    <button type="submit" class="wishlist-icon ' . ($is_in_wishlist ? 'filled' : '') . '">
                        <img src="' . ($is_in_wishlist ? 'images/wishlist-filled-icon.svg' : 'images/wishlist-icon.svg') . '" alt="Add to Wishlist" class="img-fluid">
                    </button>
                </form>';

        // Display product name and pricing
        echo '
                <h3>' . htmlspecialchars($row['name']) . '</h3>
                <div class="product-price">';
        if ($discount > 0) {
            echo '
                    <span class="original-price">Rs. ' . number_format($original_price, 2) . '</span>
                    <span class="discount-percentage">' . $discount . '% Off</span>
                    <span class="discounted-price">Rs. ' . number_format($discounted_price, 2) . '</span>';
        } else {
            echo '
                    <span class="discounted-price">Rs. ' . number_format($original_price, 2) . '</span>';
        }

        echo '
                </div>';

        // Disable buttons for out-of-stock products
        if ($is_out_of_stock) {
            echo '<button class="btn btn-secondary mt-3" disabled>Unavailable</button>';
        } else {
            echo '
                <a href="product-detail.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-secondary mt-3">View Product</a>';
        }

        echo '
            </div>
        </div>';
    }
} else {
    echo '<p class="text-center">No products available.</p>';
}

$con->close();
?>


        </div>
    </div>
</div>

<?php
// Include the footer
include 'footer.php';
?>
