<?php
session_start();
ob_start();
include_once("header.php");
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>

<div class="container" style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; box-shadow: 0px 0px 10px rgba(0,0,0,0.1);">
    <h1 style="text-align: center; color: #333; margin-bottom: 20px;">Forgot Password</h1>
    <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-2"></div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-xs-12 col-sm-12">
            <br>
            <form action="Forgot_password.php" method="post" id="form1">
                <div class="form-group">
                    <label for="email"><b>Email:</b></label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                </div>
                <br>

                <input type="submit" class="btn btn-success " value="Submit" name="frgt_pwd_btn" />
            </form>
        </div>
    </div>
    <br>

</div>

<?php
include_once("footer.php");

if (isset($_POST['frgt_pwd_btn'])) {
    $email = $_POST['email'];

    $check_query = "SELECT * FROM registration WHERE email = '$email'";
    $check_result = mysqli_query($con, $check_query);
    // $count=mysqli_num_rows($check_result);
    // if($count>0)
    // {
    //     echo "valid";
    // }
    // else{
    //     echo "invalid";
    // }


    
    if (mysqli_num_rows($check_result) > 0) {
        $query = "SELECT * FROM password_token WHERE email = '$email'";
        $result = mysqli_query($con, $query);
        
        if (mysqli_num_rows($result) > 0) {
            setcookie('error', "OTP is already sent to email address. A new OTP will be generated after the old OTP expires.", time() + 5, "/");
            echo "<script>window.location.href = 'otp_form.php';</script>";
            exit; // Terminate script
        } else {
            $otp = rand(100000, 999999);

            // Use PHPMailer to send the OTP
            $mail = new PHPMailer();
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth = true;
                $mail->Username = 'shrutivachhani2003@gmail.com'; // SMTP username
                $mail->Password = 'lwls sihz kvuy kqxa'; // SMTP password (make sure this is your correct app password)
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('shrutivachhani2003@gmail.com', 'Shruti vachhani');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP for Password Reset';
                $mail->Body = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; }
                            h1 { color: black; }
                            .otp { font-size: 24px; font-weight: bold; color: #007bff; }
                            .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <h1>Forgot Your Password?</h1>
                            <p>We received a request to reset your password. Here is your One-Time Password (OTP):</p>
                            <p class='otp'>$otp</p>
                            <p>Please enter this OTP on the website to proceed with resetting your password.</p>
                            <p>If you did not request a password reset, please ignore this email.</p>
                            <div class='footer'>
                                <p>This is an automated message, please do not reply to this email.</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";

                $mail->send();

                // Store the OTP and timestamps in the database
                $email_time = date("Y-m-d H:i:s");
                $expiry_time = date("Y-m-d H:i:s", strtotime('+10 minutes')); // OTP valid for 10 minutes
                $query = "INSERT INTO password_token (email, otp, created_at, expires_at) VALUES ('$email', '$otp', '$email_time', '$expiry_time')";
                mysqli_query($con, $query);

                $_SESSION['forgot_email'] = $email;
                setcookie('success', "OTP for resetting your password has been sent to your registered email address.", time() + 2, "/");
                echo "<script>window.location.href = 'otp_form.php';</script>";
                exit;
             } catch (Exception $e) {
                 setcookie('error', "Error sending email: " . $mail->ErrorInfo, time() + 2, "/");
                 echo "<script>window.location.href = 'Forgot_password.php';</script>";
                 exit;
             }
        }
    } else {
        setcookie('error', "Email is not registered", time() + 5, "/");
        echo "<script>window.location.href = 'Forgot_password.php';</script>";
        exit;
    }
}
?>
