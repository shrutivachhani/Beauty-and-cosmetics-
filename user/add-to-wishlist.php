<?php
// Include the database connection
include 'db_connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID and product ID (Assume the user is logged in, and user ID is stored in session)
    session_start();
    if (!isset($_SESSION['user_id'])) {
        die("You need to log in to add items to your wishlist.");
    }
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    // Insert into the wishlist table
    $sql = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);

    if ($stmt->execute()) {
        // Redirect to the wishlist page or show success message
        header("Location: wishlist.php");
        exit;
    } else {
        echo "Error adding to wishlist: " . $con->error;
    }

    $stmt->close();
    $con->close();
}
?>
