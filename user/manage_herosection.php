<?php
include_once("db_connection.php");


// Handle form submission for Create/Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];
    $image_path = $_POST['image_path'];

    if ($id) {
        // Update existing record
        $stmt = $con->prepare("UPDATE hero_section SET title = ?, subtitle = ?, description = ?, button_text = ?, button_link = ?, image_path = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $title, $subtitle, $description, $button_text, $button_link, $image_path, $id);
        $stmt->execute();
    } else {
        // Insert new record
        $stmt = $con->prepare("INSERT INTO hero_section (title, subtitle, description, button_text, button_link, image_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $subtitle, $description, $button_text, $button_link, $image_path);
        $stmt->execute();
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $con->query("DELETE FROM hero_section WHERE id = $id");
}

// Fetch current hero section content
$result = $con->query("SELECT * FROM hero_section LIMIT 1");
$hero = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Hero Section</title>
</head>
<body>

<h1>Manage Hero Section</h1>

<form action="admin_hero.php" method="POST">
    <input type="hidden" name="id" value="<?php echo isset($hero['id']) ? $hero['id'] : ''; ?>">
    
    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo isset($hero['title']) ? $hero['title'] : ''; ?>" required><br>

    <label for="subtitle">Subtitle:</label>
    <input type="text" name="subtitle" value="<?php echo isset($hero['subtitle']) ? $hero['subtitle'] : ''; ?>"><br>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo isset($hero['description']) ? $hero['description'] : ''; ?></textarea><br>

    <label for="button_text">Button Text:</label>
    <input type="text" name="button_text" value="<?php echo isset($hero['button_text']) ? $hero['button_text'] : ''; ?>"><br>

    <label for="button_link">Button Link:</label>
    <input type="text" name="button_link" value="<?php echo isset($hero['button_link']) ? $hero['button_link'] : ''; ?>"><br>

    <label for="image_path">Image Path:</label>
    <input type="text" name="image_path" value="<?php echo isset($hero['image_path']) ? $hero['image_path'] : ''; ?>"><br><br>

    <button type="submit">Save</button>
</form>

<?php if (isset($hero['id'])): ?>
    <a href="admin_hero.php?delete=<?php echo $hero['id']; ?>" onclick="return confirm('Are you sure?')">Delete Hero Section</a>
<?php endif; ?>

</body>
</html>
