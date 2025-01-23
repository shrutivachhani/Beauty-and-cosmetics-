<?php
session_start();
include 'db_connection.php';
include 'userheader.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle profile update via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];

    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $mobile = htmlspecialchars($_POST['mobile']);
    $address = htmlspecialchars($_POST['address']);
    $user_id = $_SESSION['user_id'];

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../guestuser/images/profile_pictures/';
        $fileName = basename($_FILES['profile_picture']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
            $_SESSION['profile_picture'] = $fileName;
            $profilePictureSQL = ", profile_picture = '$fileName'";
            $response['profile_picture'] = $fileName;
        } else {
            $response['error'] = 'Failed to upload profile picture.';
            echo json_encode($response);
            exit();
        }
    } else {
        $profilePictureSQL = '';
    }

    // Update user information in the database
    $sql = "UPDATE users SET fullname = '$fullname', email = '$email', mobile = '$mobile', address = '$address' $profilePictureSQL WHERE id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
        $_SESSION['mobile'] = $mobile;
        $_SESSION['address'] = $address;

        $response['success'] = 'Profile updated successfully.';
        $response['fullname'] = $fullname;
        $response['email'] = $email;
        $response['mobile'] = $mobile;
        $response['address'] = $address;
    } else {
        $response['error'] = 'Error updating profile: ' . mysqli_error($conn);
    }

    mysqli_close($conn);
    echo json_encode($response);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* Add your previous styles here */
        .hidden { display: none; }
        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 20px;
        }

        .profile-pic img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-right: 20px;
            border: 3px solid #007BFF;
        }

        .user-info h1 {
            font-size: 24px;
            color: #333;
        }

        .edit-btn {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .edit-btn:hover {
            background-color: #0056b3;
        }

        .wishlist-btn {
            padding: 10px 20px;
            background-color:rgb(209, 40, 40);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 20px;
        }

        .wishlist-btn:hover {
            background-color: #218838;
        }

        .profile-info h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .info-row {
            margin-bottom: 15px;
        }

        .info-row label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .info-row p {
            font-size: 16px;
            color: #333;
            padding: 8px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        .info-row input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }

    </style>
    <script>
        async function updateProfile(event) {
            event.preventDefault();

            const formData = new FormData(document.getElementById('edit-profile-form'));
            const response = await fetch('', { // Current page
                method: 'POST',
                body: formData,
            });
            const result = await response.json();

            if (result.success) {
                // Update UI with new information
                document.getElementById('name-display').textContent = result.fullname;
                document.getElementById('email-display').textContent = result.email;
                document.getElementById('phone-display').textContent = result.mobile;
                document.getElementById('address-display').textContent = result.address;

                if (result.profile_picture) {
                    document.getElementById('profile-pic').src = '../guestuser/images/profile_pictures/' + result.profile_picture;
                }

                toggleEditForm();
                alert(result.success);
            } else if (result.error) {
                alert(result.error);
            }
        }

        function toggleEditForm() {
            document.getElementById('profile-info').classList.toggle('hidden');
            document.getElementById('edit-profile-form').classList.toggle('hidden');
        }
    </script>
</head>
<body>
    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-pic">
                <img id="profile-pic" src="../guestuser/images/profile_pictures/<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Picture">
            </div>
            <div class="user-info">
                <h1 id="name-display"><?php echo htmlspecialchars($_SESSION['fullname']); ?></h1>
                <button class="edit-btn" onclick="toggleEditForm()">Edit Profile</button>
                <a href="logout.php" class="wishlist-btn">Logout</a>
            </div>
        </div>

        <!-- Display Profile Info -->
        <div id="profile-info" class="profile-info">
            <h2>Personal Information</h2>
            <div class="info-row">
                <label for="name">Name:</label>
                <p id="name-display"><?php echo htmlspecialchars($_SESSION['fullname']); ?></p>
            </div>
            <div class="info-row">
                <label for="email">Email:</label>
                <p id="email-display"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
            </div>
            <div class="info-row">
                <label for="phone">Phone Number:</label>
                <p id="phone-display"><?php echo htmlspecialchars($_SESSION['mobile']); ?></p>
            </div>
            <div class="info-row">
                <label for="address">Address:</label>
                <p id="address-display"><?php echo htmlspecialchars($_SESSION['address']); ?></p>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div id="edit-profile-form" class="hidden">
            <form onsubmit="updateProfile(event)" enctype="multipart/form-data">
                <div class="info-row">
                    <label for="fullname">Name:</label>
                    <input type="text" name="fullname" value="<?php echo htmlspecialchars($_SESSION['fullname']); ?>">
                </div>
                <div class="info-row">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                </div>
                <div class="info-row">
                    <label for="mobile">Phone Number:</label>
                    <input type="text" name="mobile" value="<?php echo htmlspecialchars($_SESSION['mobile']); ?>">
                </div>
                <div class="info-row">
                    <label for="address">Address:</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($_SESSION['address']); ?>">
                </div>
                <div class="info-row">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" name="profile_picture">
                </div>
                <button type="submit" class="edit-btn">Save Changes</button>
                <button type="button" class="wishlist-btn" onclick="toggleEditForm()">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>
