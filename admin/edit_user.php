<?php
include_once("adminconnection.php");
include_once("header.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user data based on the ID
    $query = "SELECT * FROM registration WHERE id=$id";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $fn = $_POST['fn'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $gen = $_POST['gen'];
    $address = $_POST['address'];

    // Update query
    $updateQuery = "UPDATE registration SET fullname='$fn', email='$email', mobile_number='$mobile', gender='$gen', address='$address' WHERE id=$id";
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('User updated successfully'); window.location.href='manage_user.php';</script>";
    } else {
        echo "<script>alert('Error updating user');</script>";
    }
}
?>

<div class="container">
    <h2 class="text-center mt-4">Edit User</h2>
    <form method="post">
        <div class="form-group">
            <label for="fn">Fullname:</label>
            <input type="text" class="form-control" id="fn" name="fn" value="<?php echo $user['fullname']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile Number:</label>
            <input type="number" class="form-control" id="mobile" name="mobile" value="<?php echo $user['mobile_number']; ?>" required>
        </div>
        <div class="form-group">
            <label for="gen">Gender:</label>
            <select class="form-control" id="gen" name="gen" required>
                <option value="Male" <?php if ($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" name="address" required><?php echo $user['address']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-success" name="update">Update User</button>
    </form>
</div>

<?php include_once("footer.php"); ?>
