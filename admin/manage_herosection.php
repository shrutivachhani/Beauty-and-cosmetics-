<?php
// Include the admin header and database connection
include 'header.php';
include_once("adminconnection.php");

$message = "";

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handling the image upload
    $target_dir = "uploads/";
    $image_url = $target_dir . basename($_FILES["image"]["name"]);
    
    // Check if image is uploaded successfully
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_url)) {
        // Prepare the SQL query to update the hero section
        $stmt = $mysqli_connect->prepare("UPDATE hero_section SET image_url = ?, title = ?, description = ? WHERE id = 1");
        $stmt->bind_param("sss", $image_url, $title, $description);

        // Execute the query
        if ($stmt->execute()) {
            $message = "Hero section updated successfully!";
        } else {
            $message = "Failed to update the database.";
        }
    } else {
        $message = "Failed to upload image.";
    }
}

// Fetch the current hero section content
$result = $mysqli->query("SELECT * FROM hero_section WHERE id = 1");
$hero = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Hero Section</title>
</head>
<body>
    <h1>Update Hero Section</h1>

    <!-- Display the form for updating the hero section -->
    <form action="manage_herosection.php" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $hero['title']; ?>" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required><?php echo $hero['description']; ?></textarea><br><br>

        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image" required><br><br>

        <button type="submit">Update</button>
    </form>

    <!-- Display success or error message -->
    <p><?php echo $message; ?></p>
</body>
</html>
