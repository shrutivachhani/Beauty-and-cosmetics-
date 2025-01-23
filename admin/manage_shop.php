<?php
include 'header.php'; // Include the admin header
include 'adminconnection.php'; // Include the database connection file

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id = $delete_id";
    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Product deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting product: " . $con->error . "');</script>";
    }
}

// Handle product addition
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    // Save the uploaded image
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $sql = "INSERT INTO products (name, price, description, image) VALUES ('$name', '$price', '$description', '$target_file')";
    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Product added successfully');</script>";
    } else {
        echo "<script>alert('Error adding product: " . $con->error . "');</script>";
    }
}

// Handle product update
if (isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    // If a new image is uploaded, update the image field
    if ($image) {
        $target_dir = "images/products/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $sql = "UPDATE products SET name = '$name', price = '$price', description = '$description', image = '$target_file' WHERE id = $id";
    } else {
        $sql = "UPDATE products SET name = '$name', price = '$price', description = '$description' WHERE id = $id";
    }

    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Product updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating product: " . $con->error . "');</script>";
    }
}
?>

<div class="container">
    <h1>Manage Products</h1>

    <!-- Add Product Form -->
    <form action="manage_shop.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="price">Product Price</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="description">Product Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
    </form>

    <hr>

    <!-- Display All Products -->
    <h2>All Products</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM products";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['name'] . '</td>
                        <td>Rs. ' . $row['price'] . '</td>
                        <td>' . $row['description'] . '</td>
                        <td><img src="' . $row['image'] . '" alt="' . $row['name'] . '" style="width: 100px; height: 100px;"></td>
                        <td><a href="edit_shop.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a></td>
                        <td><a href="manage_shop.php?delete_id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a></td>
                    </tr>';
                }
            } else {
                echo '<tr><td colspan="7">No products found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include 'footer.php'; // Include the admin footer
$con->close(); // Close the database connection
?>
