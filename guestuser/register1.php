<?php
include_once("header.php");
include_once("db_connection.php"); // Ensure the database connection is included

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

?>

<script>
    $(document).ready(function() {
        $("#form1").validate({
            rules: {
                fn: {
                    required: true,
                    minlength: 3,
                    pattern: /^[A-Za-z\s]+$/
                },
                email: {
                    required: true,
                    email: true
                },
                pswd: {
                    required: true,
                    minlength: 8,
                    maxlength: 25,
                    pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,25}$/
                },
                repswd: {
                    required: true,
                    equalTo: "#pwd"
                },
                address: {
                    required: true,
                    minlength: 10
                },
                gen: {
                    required: true
                },
                mobile: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                pic: {
                    required: true,
                    accept: "image/*"
                }
            },
            messages: {
                fn: {
                    required: "Please enter your full name",
                    minlength: "Full name must be at least 3 characters long",
                    pattern: "Fullname must contain letters and spaces"
                },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                pswd: {
                    required: "Please provide a password",
                    minlength: "Password must be at least 8 characters long",
                    maxlength: "Password must not be greater than 25 characters",
                    pattern: "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character"
                },
                repswd: {
                    required: "Please confirm your password",
                    minlength: "Password must be at least 6 characters long",
                    equalTo: "Password and Confirm Passwords do not match"
                },
                address: {
                    required: "Please enter your address",
                    minlength: "Address must be at least 10 characters long"
                },
                gen: {
                    required: "Please select your gender"
                },
                mobile: {
                    required: "Please enter your mobile number",
                    digits: "Please enter only digits",
                    minlength: "Mobile number must be exactly 10 digits long",
                    maxlength: "Mobile number must be exactly 10 digits long"
                },
                pic: {
                    required: "Please select a profile picture",
                    accept: "Only image files are allowed"
                }
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                if (element.attr("name") === "gen") {
                    error.insertAfter("#gen_err");
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass('is-valid').removeClass('is-invalid');
            }
        });
    });
</script>
<div class="container">
    <div class="row text-center">
        <div class="col-12 bg-dark text-white p-4 align-center">
            <h1>Registration</h1>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-2"></div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-xs-12 col-sm-12">
            <form action="register1.php" method="post" enctype="multipart/form-data" id="form1">
                <div class="form-group">
                    <label for="fn1"><b>Fullname:</b></label>
                    <input type="text" class="form-control" id="fn1" placeholder="Enter Name" name="fn">
                </div>
                <br>
                <div class="form-group">
                    <label for="email1"><b>Email:</b></label>
                    <input type="email" class="form-control" id="email1" placeholder="Enter email" name="email">
                </div>
                <br>
                <div class="form-group">
                    <label for="pwd"><b>Password:</b></label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
                </div>
                <br>
                <div class="form-group">
                    <label for="repwd"><b>Confirm Password: </b></label>
                    <input type="password" class="form-control" id="repwd" placeholder="Enter password" name="repswd">
                </div>
                <br>
                <div class="form-group">
                    <label for="address1"><b>Enter Address:</b></label>
                    <textarea class="form-control" id="address1" name="address"></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="gen1"><b>Select Gender:</b></label>
                    <br>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" id="genMale" name="gen" value="Male"> Male
                        </label>
                        <label class="radio-label">
                            <input type="radio" id="genFemale" name="gen" value="Female"> Female
                        </label>
                        <span id="gen_err" class="radio-error"></span>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for="mobile1"><b>Mobile Number: </b></label>
                    <input type="number" class="form-control" id="mobile1" placeholder="1234567890" name="mobile">
                </div>
                <br>
                <div class="form-group">
                    <label for="file1"><b>Select Profile Picture:</b></label>
                    <input type="file" class="form-control" id="file1" name="pic">
                </div>
                <br>
                <input type="submit" class="btn btn-success" value="Submit" name="btn">
            </form>
        </div>
    </div>
</div>
</div>

<?php

if (isset($_POST['btn'])) {
    //Form data extraction
    $fn = $_POST['fn'];
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];

    $address = $_POST['address'];
    $gen = $_POST['gen'];
    $mobile = $_POST['mobile'];
    $pic = uniqid() . $_FILES['pic']['name'];

    $q = "INSERT INTO `registration`(`fullname`, `email`, `password`, `address`, `gender`, `mobile_number`, `profile_picture`) VALUES ('$fn','$email','$pswd','$address','$gen',$mobile,'$pic')";

    if (mysqli_query($con, $q)) {
        if (!is_dir("images/profile_pictures")) {
            mkdir("images/profile_pictures");
        }
        move_uploaded_file($_FILES['pic']['tmp_name'], "images/profile_pictures/.$pic");

        $mail = new PHPMailer(true);
        // try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'shrutivachhani2003@gmail.com';
            $mail->Password = 'lwls sihz kvuy kqxa';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('shrutivachhani2003@gmail.com', 'shruti');
            $mail->addAddress($email, $fn);

            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $activation_link = "http://localhost/beauty%20and%20cosmetics/guestuser/verify_email.php?em=" . $email;
            $mail->Body    = "<html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; }
                    h1 { color: black; }
                    a { text-decoration: none; color: white; }
                    .button { display: inline-block; padding: 10px 20px; background-color: black; color: white; text-decoration: none; border-radius: 5px; }
                    .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
                    
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Welcome, $fn!</h1>
                    <p>Thank you for registering. Please click the button below to activate your account:</p>
                    <p><a href='$activation_link' class='button'>Activate Your Account</a></p>
                    <p>If you didn't register on our website, please ignore this email.</p>
                    <div class='footer'>
                        <p>This is an automated message, please do not reply to this email.</p>
                    </div>
                </div>
            </body>
            </html>";

            $mail->send();
        // } catch (Exception $e) {
        //     // $_SESSION['error'] = "Error in sending email: ". $mail->ErrorInfo;
        //     setcookie('error', "Error in sending email: " . $mail->ErrorInfo, time() + 5);
        // }

        // $_SESSION['success'] = "Registration Successfull. VErify your Email using verification link sent to registered Email Address";
        setcookie('success', 'Registration Successfull. Verify your Email using verification link sent to registered Email Address', time() + 5, "/");
?>

        <script>
            window.location.href = "login.php";
        </script>
    <?php
    } else {
        // $_SESSION['error'] = "Error in Registration. Try again."
        setcookie('error', 'Error in Registration. Try again.', time() + 5, "/");
    ?>

        <script>
            window.location.href = "register1.php";
        </script>
<?php
    }
}
