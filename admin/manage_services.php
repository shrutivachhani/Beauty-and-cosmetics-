<?php
include_once("header.php");
include_once("adminconnection.php");

// Handle form submission for adding a new service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon = $_POST['icon']; // This should be the path to the icon image

    $sql = "INSERT INTO services (title, description, icon) VALUES ('$title', '$description', '$icon')";
    if ($con->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>New service added successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $con->error . "</div>";
    }
}

// Handle form submission for editing a service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_service'])) {
    $id = $_POST['service_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];

    $sql = "UPDATE services SET title='$title', description='$description', icon='$icon' WHERE id=$id";
    if ($con->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Service updated successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating record: " . $con->error . "</div>";
    }
}

// Handle deletion of a service
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM services WHERE id=$id";
    if ($con->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Service deleted successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting record: " . $con->error . "</div>";
    }
}

// Fetch existing services
$services = [];
$sql = "SELECT * FROM services";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .alert {
            margin-bottom: 20px;
        }
        table {
            margin-top: 20px;
        }
        th, td {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add New Service</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="title">Service Title:</label>
            <input type="text" class="form-control" name="title" placeholder="Service Title" required>
        </div>
        <div class="form-group">
            <label for="description">Service Description:</label>
            <textarea class="form-control" name="description" placeholder="Service Description" required></textarea>
        </div>
        <div class="form-group">
            <label for="icon">Icon URL:</label>
            <input type="text" class="form-control" name="icon" placeholder="Icon URL" required>
        </div>
        <button type="submit" class="btn btn-primary" name="add_service">Add Service</button>
    </form>

    <h2>Manage Existing Services</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
            <tr>
                <td><?php echo htmlspecialchars($service['title']); ?></td>
                <td><?php echo htmlspecialchars($service['description']); ?></td>
                <td><img src="<?php echo htmlspecialchars($service['icon']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" style="width:50px;"></td>
                <td>
                    <form method="post" action="" style="display:inline;">
                        <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                        <input type="text" name="title" value="<?php echo htmlspecialchars($service['title']); ?>" required>
                        <textarea name="description" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                        <input type="text" name="icon" value="<?php echo htmlspecialchars($service['icon']); ?>" required>
                        <button type="submit" class="btn btn-success" name="edit_service">Update</button>
                    </form>
                    <br>
                    <a href="?delete=<?php echo $service['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this service?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
