<?php
// Include your header file
include 'userheader.php';

include_once("db_connection.php");

// Fetch 4 random products from the database
$sql = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
$result = $con->query($sql);
?>

<style>
    .product-item {
        position: relative;
        text-align: center;
    }

    .product-thumbnail {
        display: block;
        width: 100%;
        height: auto;
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
        width: 24px;
        height: 24px;
        filter: drop-shadow(0 0 2px rgba(0, 0, 0, 0.5));
    }

    .wishlist-icon:hover img {
        filter: brightness(1.2);
    }

    .product-title {
        margin-top: 10px;
        font-size: 1.1rem;
    }

    .product-price {
        font-size: 1rem;
        color: #000;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }

    .original-price {
        text-decoration: line-through;
        color: gray;
        font-size: 0.9rem;
    }

    .discounted-price {
        font-size: 1.2rem;
        color: #d9534f; /* Bootstrap danger color */
        font-weight: bold;
    }

    .discount-percentage {
        color: #28a745; /* Bootstrap success color */
        font-size: 0.9rem;
        font-weight: bold;
    }
</style>

<!-- Start Hero Section -->
<div class="hero mb-3"> <!-- Reduced bottom margin -->
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <br>
                    <h1>Enhance Your <span class="d-block">Beauty Journey</span></h1>
                    <p style="color: black;">DISCOVER LUXURIOUS COSMETICS FOR EVERY SKIN TYPE...</p>
                    <p><a href="shop.php" class="btn btn-secondary me-2">Shop Now</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<!-- Start Product Section -->
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
                    // Calculate the discounted price
                    $discount = $row['discount'] ?? 0; // Assume 0% if no discount value is set
                    $original_price = $row['price'];
                    $discounted_price = $original_price - ($original_price * $discount / 100);

                    echo '
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <div class="card product-item border-0 shadow-sm h-100">
                            <a href="product-detail.php?id=' . $row['id'] . '" class="position-relative">
                                <img src="' . $row['image'] . '" class="card-img-top product-thumbnail" alt="Product Image">
                                <!-- Wishlist Icon -->
                                <form method="POST" action="add-to-wishlist.php" class="wishlist-icon-form">
                                    <input type="hidden" name="product_id" value="' . $row['id'] . '">
                                    <button type="submit" class="wishlist-icon">
                                        <img src="images/wishlist-icon.svg" alt="Add to Wishlist" class="img-fluid">
                                    </button>
                                </form>
                            </a>
                            <div class="card-body text-center">
                                <h5 class="product-title">' . htmlspecialchars($row['name']) . '</h5>
                                <div class="product-price">';
                                if ($discount > 0) {
                                    echo '
                                    <span class="original-price">Rs. ' . number_format($original_price, 2) . '</span>
                                    <span class="discount-percentage">' . $discount . '% Discount</span>
                                    <span class="discounted-price">Rs. ' . number_format($discounted_price, 2) . '</span>
                                    ';
                                } else {
                                    echo '
                                    <span class="discounted-price">Rs. ' . number_format($original_price, 2) . '</span>
                                    ';
                                }
                                echo '
                                </div>
                                <!-- Add the View Product button -->
                                <a href="product-detail.php?id=' . $row['id'] . '" class="btn btn-primary mt-3">View Product</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
        </div>
    </div>
</div>
<!-- End Product Section -->


<!-- Start Why Choose Us Section -->
<div class="why-choose-section mb-3"> <!-- Reduced bottom margin -->
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6">
                <?php
                // Query to select content from the 'about_us' table
                $q = "SELECT * FROM about_us WHERE id = 1"; // Assuming 'id=1' for the content you want to display
                $result = mysqli_query($con, $q); // Execute the query
                
                // Loop through and display the content
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($r = mysqli_fetch_assoc($result)) {
                        echo $r['content']; // Output the 'content' field from the table
                    }
                } else {
                    echo "<p>No content available.</p>"; // Fallback message if no content is found
                }
                ?>
            </div>

            <!-- Column for the image -->
            <div class="col-lg-5">
                <img src="images/sidebar1.png" style="height: 500px; width: 400px; border-radius: 20px;" alt="Why Choose Us">
            </div>
        </div>
    </div>
</div>
<!-- End Why Choose Us Section -->


<!-- Include your footer file -->
<?php
// Close the database connection at the end of the script
$con->close();
include 'footer.php';
?>
