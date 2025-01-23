<?php
// Include the header
include 'header.php';
// Include the database connection
include_once("db_connection.php");



// Fetch services from the database
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
    <title>Services</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Include your CSS files -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .hero {
            background: #f7f7f7;
            padding: 60px 0;
            text-align: center;
        }
        .why-choose-section {
            padding: 60px 0;
        }
        .feature {
            text-align: center;
            margin: 20px 0;
        }
        .feature img {
            width: 50px; /* Adjust size as needed */
        }
        h1, h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>


<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <h1>Our Services</h1>
    </div>
</div>
<!-- End Hero Section -->

<!-- Start Why Choose Us Section -->
<div class="why-choose-section">
    <div class="container">
        <div class="row">
            <?php foreach ($services as $service): ?>
                <div class="col-6 col-md-6 col-lg-3 mb-4">
                    <div class="feature">
                        <div class="icon">
                            <img src="<?php echo $service['icon']; ?>" alt="<?php echo $service['title']; ?>" class="img-fluid">
                        </div>
                        <h3><?php echo $service['title']; ?></h3>
                        <p><?php echo $service['description']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- End Why Choose Us Section -->

<?php include 'footer.php'; ?> <!-- Include your footer -->

<script src="path/to/bootstrap.bundle.js"></script> <!-- Include your JS files -->
</body>
</html>
