<?php
// Include the database connection and user session
session_start();

include 'userheader.php';
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You need to log in to view your wishlist.");
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Fetch wishlist items for the logged-in user
$sql = "
    SELECT products.id, products.name, products.image, products.price 
    FROM wishlist 
    JOIN products ON wishlist.product_id = products.id 
    WHERE wishlist.user_id = ?
";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Wishlist</title>
    <!-- Include Bootstrap or your CSS framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .wishlist-container {
            margin: 20px auto;
            max-width: 1200px;
            padding: 20px;
        }

        .wishlist-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .wishlist-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .wishlist-item img {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .wishlist-item h3 {
            font-size: 1.5rem;
            margin: 10px 0;
        }

        .wishlist-item p {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .wishlist-item button {
            background-color: #dc3545;
            border: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .wishlist-item button:hover {
            background-color: #c82333;
        }

        .empty-message {
            text-align: center;
            font-size: 1.5rem;
            color: #6c757d;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container wishlist-container">
        <h1 class="text-center mb-4">Your Wishlist</h1>
        <?php
        if ($result->num_rows > 0) {
            echo '<div class="row">';
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="col-md-4 col-lg-3">
                    <div class="wishlist-item">
                        <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
                        <h3>' . htmlspecialchars($row['name']) . '</h3>
                        <p>Price: Rs. ' . number_format($row['price'], 2) . '</p>
                        <form method="POST" action="remove-from-wishlist.php">
                            <input type="hidden" name="product_id" value="' . htmlspecialchars($row['id']) . '">
                            <button type="submit">Remove from Wishlist</button>
                        </form>
                    </div>
                </div>';
            }
            echo '</div>';
        } else {
            echo '<p class="empty-message">Your wishlist is empty!</p>';
        }

        $stmt->close();
        $con->close();
        ?>
    </div>
</body>
</html>

<?php
// Include the footer
include 'footer.php';
?>
