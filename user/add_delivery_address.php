<?php
session_start();
include_once("userheader.php");
include_once("db_connection.php");

$email = $_SESSION['email'];
$address_id = $_GET['address_id'] ?? 0; // Check if we're editing an existing address

// Fetch existing address if we're editing
if ($address_id) {
    $stmt = $con->prepare("SELECT * FROM address WHERE id = ? AND email = ?");
    $stmt->bind_param("is", $address_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing_address = $result->fetch_assoc();
} else {
    $existing_address = null; // No address to edit
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Update Delivery Address</title>
</head>
<body>
    <div class="container">
        <div class="row text-center">
            <div class="col-12 bg-dark text-white p-2 align-center">
                <h1><?= $address_id ? 'Edit Delivery Address' : 'Add Delivery Address' ?></h1>
            </div>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <form action="add_delivery_address.php" method="post" id="addressForm">
                <input type="hidden" name="address_id" value="<?= $existing_address['id'] ?? '' ?>">
                <div class="form-group">
                    <label for="person_name"><b>Person Name:</b></label>
                    <input type="text" id="person_name" name="person_name" class="form-control" value="<?= $existing_address['person_name'] ?? '' ?>" placeholder="Enter person's name">
                </div>
                <div class="form-group">
                    <label for="email_address"><b>Email Address:</b></label>
                    <input type="email" id="email_address" name="email_address" class="form-control" value="<?= $existing_address['email_address'] ?? '' ?>" placeholder="Enter email address">
                </div>
                <div class="form-group">
                    <label for="mobile_number"><b>Mobile Number:</b></label>
                    <input type="text" id="mobile_number" name="mobile_number" class="form-control" value="<?= $existing_address['mobile_number'] ?? '' ?>" placeholder="Enter mobile number">
                </div>
                <div class="form-group">
                    <label for="address_line_1"><b>Address Line 1:</b></label>
                    <input type="text" id="address_line_1" name="address_line_1" class="form-control" value="<?= $existing_address['address_line_1'] ?? '' ?>" placeholder="Enter address line 1">
                </div>
                <div class="form-group">
                    <label for="address_line_2"><b>Address Line 2:</b></label>
                    <input type="text" id="address_line_2" name="address_line_2" class="form-control" value="<?= $existing_address['address_line_2'] ?? '' ?>" placeholder="Enter address line 2">
                </div>
                <div class="form-group">
                    <label for="city"><b>City:</b></label>
                    <input type="text" id="city" name="city" class="form-control" value="<?= $existing_address['city'] ?? '' ?>" placeholder="Enter city">
                </div>
                <div class="form-group">
                    <label for="zip"><b>Zip:</b></label>
                    <input type="text" id="zip" name="zip" class="form-control" value="<?= $existing_address['zip'] ?? '' ?>" placeholder="Enter zip code">
                </div>
                <div class="form-group">
                    <label for="state"><b>State:</b></label>
                    <input type="text" id="state" name="state" class="form-control" value="<?= $existing_address['state'] ?? '' ?>" placeholder="Enter state">
                </div>
                <div class="form-group">
                    <label for="country"><b>Country:</b></label>
                    <input type="text" id="country" name="country" class="form-control" value="<?= $existing_address['country'] ?? '' ?>" placeholder="Enter country">
                </div>

                <input type="submit" class="btn btn-dark" value="<?= $address_id ? 'Update Address' : 'Add Address' ?>" name="address" />
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['address'])) {
        $address_id = $_POST['address_id'] ?? 0;
        $person_name = $_POST['person_name'];
        $email_address = $_POST['email_address'];
        $mobile_number = $_POST['mobile_number'];
        $address_line_1 = $_POST['address_line_1'];
        $address_line_2 = $_POST['address_line_2'];
        $city = $_POST['city'];
        $zip = $_POST['zip'];
        $state = $_POST['state'];
        $country = $_POST['country'];

        $delivery_address = $person_name . "<br>" . $address_line_1 . "<br>" . $address_line_2 . "<br>" . $city . "-" . $zip . "<br>" . $state . "<br>" . $country . "<br>Mobile: " . $mobile_number . "<br>Email:" . $email_address;

        if ($address_id) {
            // Update existing address
            $update_query = "UPDATE address SET delivery_address = ? WHERE id = ? AND email = ?";
            $stmt = $con->prepare($update_query);
            $stmt->bind_param("sis", $delivery_address, $address_id, $email);
            $stmt->execute();
        } else {
            // Insert new address
            $insert_query = "INSERT INTO address (email, delivery_address) VALUES (?, ?)";
            $stmt = $con->prepare($insert_query);
            $stmt->bind_param("ss", $email, $delivery_address);
            $stmt->execute();
        }

        // Redirect to cart page
        echo "<script>window.location.href = 'cart.php';</script>";
    }
    ?>
</body>
</html>
