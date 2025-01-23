<?php
include 'header.php';
include 'adminconnection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $con->query($sql);
    $product = $result->fetch_assoc();
}

if (isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

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
    echo "<script>window.location.href = 'manage_shop.php';</script>";
}
?>

<div class="container">
    <h1>Edit Product</h1>
    <form action="edit_shop.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Product Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Product Description</label>
            <textarea class="form-control" id="description" name="description" required><?php echo $product['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Product Image (Upload new image to replace)</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" name="edit_product" class="btn btn-primary">Update Product</button>
    </form>
</div>

<?php
include 'footer.php'; // Include the admin footer
$con->close(); // Close the database connection
?>
