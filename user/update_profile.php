<?php
session_start();

include_once("db_connection.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $profile_picture = $_SESSION['profile_picture'];

    // Handle file upload if provided
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "../guestuser/images/profile_pictures/";
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $profile_picture = basename($_FILES['profile_picture']['name']);
        }
    }

    // Update the database
    $sql = "UPDATE registration SET fullname = ?, email = ?, mobile_number = ?, address = ?, profile_picture = ? WHERE id = ?";
    $stmt = $con->prepare($sql);

    // Check if the statement was successfully prepared
    if ($stmt === false) {
        die('Error preparing the query: ' . $con->error); // Debugging the error
    }

    // Bind the parameters to the query
    $stmt->bind_param('sssssi', $fullname, $email, $mobile_number, $address, $profile_picture, $user_id);

    // Execute the query
    if ($stmt->execute()) {
        // Update session variables
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
        $_SESSION['mobile'] = $mobile;
        $_SESSION['address'] = $address;
        $_SESSION['profile_picture'] = $profile_picture;

        // Redirect to profile page
        header("Location: userprofile.php?success=1");
        exit();
    } else {
        echo "Error updating profile: " . $stmt->error;
    }
}
