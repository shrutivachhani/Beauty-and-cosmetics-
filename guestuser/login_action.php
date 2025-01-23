<?php
session_start();
include_once('header.php');
include_once('db_connection.php'); // Database connection

if (isset($_POST['lgn_btn'])) {
    $em = $_POST['email'];
    $pwd = $_POST['pswd'];

    // Validate email
    $q = "SELECT * FROM `registration` WHERE `email`='$em'";
    $result = mysqli_query($con, $q);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $user = mysqli_fetch_assoc($result);

        // Check password
        if ($user['password'] == $pwd) {

            // Check if account is active
            if ($user['status'] == 'Active') {

                // Store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['mobile'] = $user['mobile_number'];
                $_SESSION['address'] = $user['address'];
                $_SESSION['profile_picture'] = $user['profile_picture'];

                // Check user role
                if ($user['role'] == 'Admin') {
                    setcookie('success', 'Login Successful', time() + 5, "/");
                    $_SESSION['admin_user'] = $em;

                    // Redirect to admin dashboard
                    ?>
                    <script>
                        window.location.href = "admin/index.php";
                    </script>
                    <?php
                } else {
                    // Regular user
                    $_SESSION['user_uname'] = $em;
                    setcookie('success', 'Login Successful', time() + 5, "/");

                    // Redirect to user dashboard
                    ?>
                    <script>
                        window.location.href = "/beauty and cosmetics/user/index.php";
                    </script>
                    <?php
                }

            } else {
                // Account is not active
                setcookie("error", "Email is not verified", time() + 5, "/");
                ?>
                <script>
                    window.location.href = "login.php";
                </script>
                <?php
            }

        } else {
            // Incorrect password
            setcookie("error", "Incorrect Password", time() + 5, "/");
            ?>
            <script>
                window.location.href = "login.php";
            </script>
            <?php
        }

    } else {
        // Email not registered
        setcookie("error", "Email is not registered", time() + 5, "/");
        ?>
        <script>
            window.location.href = "login.php";
        </script>
        <?php
    }
}
?>
