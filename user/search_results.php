<?php
include 'userheader.php';

// Product data array (same as in shop.php)
$products = [
    [
        'title' => 'Combo Nail Paint',
        'price' => 'Rs.300.00',
        'image' => 'images/product10.png',
        'category' => 'nail paint',
    ],
    [
        'title' => 'Lipstick',
        'price' => 'Rs.500.00',
        'image' => 'images/product1.png',
        'category' => 'lipstick',
    ],
    [
        'title' => 'Foundation',
        'price' => 'Rs.860.00',
        'image' => 'images/product2.png',
        'category' => 'foundation',
    ],
    [
        'title' => 'Perfume',
        'price' => 'Rs.3000.00',
        'image' => 'images/product5.png',
        'category' => 'perfume',
    ],
    [
        'title' => 'Liquid Lipstick',
        'price' => 'Rs.650.00',
        'image' => 'images/product8.png',
        'category' => 'lipstick',
    ],
    [
        'title' => 'Mascara',
        'price' => 'Rs.250.00',
        'image' => 'images/product7.png',
        'category' => 'mascara',
    ],
    [
        'title' => 'Cleanser',
        'price' => 'Rs.450.00',
        'image' => 'images/product9.png',
        'category' => 'cleanser',
    ],
    [
        'title' => 'Nail Paint',
        'price' => 'Rs.200.00',
        'image' => 'images/product4.png',
        'category' => 'nail paint',
    ],
];

// Get the search query from the URL
$searchQuery = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : '';

// Filter products based on the search query
$filteredProducts = array_filter($products, function($product) use ($searchQuery) {
    return strpos(strtolower($product['title']), $searchQuery) !== false;
});

?>

<div class="container mt-5">
    <h2>Search Results for "<?php echo htmlentities($searchQuery); ?>"</h2>
    <div class="row">
        <?php if (!empty($filteredProducts)): ?>
            <?php foreach ($filteredProducts as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['title']; ?></h5>
                            <p class="card-text"><?php echo $product['price']; ?></p>
                            <a href="cart.php" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found matching your search criteria.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
