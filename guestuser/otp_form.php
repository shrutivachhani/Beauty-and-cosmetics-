<?php
include ("header.php");
session_start();
?>

<script>
    $(document).ready(function() {
        $("#form1").validate({
            rules: {
                otp: {
                    required: true,
                    digits: true,
                    minlength: 6,
                    maxlength: 6
                }
            },
            messages: {
                otp: {
                    required: "Please enter the OTP",
                    digits: "Please enter a valid OTP",
                    minlength: "OTP must be 6 digits",
                    maxlength: "OTP must be 6 digits"
                }
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
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

<div class="container" style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; box-shadow: 0px 0px 10px rgba(0,0,0,0.1);">
    <h1 style="text-align: center; color: #333; margin-bottom: 20px;">OTP Verification</h1>
    
    <form action="otp_form.php" method="post" id="form1">
        <div class="form-group">
            <label for="otp"><b>OTP:</b></label>
            <input type="text" class="form-control" id="otp1" placeholder="Enter OTP" name="otp" required>
        </div>
        <br>
        
         <div id="timer" class="text-danger"></div>
        <br>
        
        <input type="button" id="resend_otp" class="btn btn-warning" style="display:none;" value="Resend OTP">
        
        <input type="submit" class="btn btn-success" value="Submit" name="otp_btn">
    </form>
    
    <script>
        let timeLeft = 60; // Timer (in seconds)
        const timerDisplay = document.getElementById('timer');
        const resendButton = document.getElementById('resend_otp');

        function startCountdown() {
            const countdown = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    timerDisplay.innerHTML = "You can now resend the OTP.";
                    resendButton.style.display = "inline";
                } else {
                    timerDisplay.innerHTML = `Resend OTP in ${timeLeft} seconds`;
                    timeLeft -= 1;
                }
            }, 1000);
        }

        if (sessionStorage.getItem('otpTimer')) {
            timeLeft = parseInt(sessionStorage.getItem('otpTimer'));
            startCountdown();
        } else {
            startCountdown();
        }

        setInterval(() => {
            sessionStorage.setItem('otpTimer', timeLeft);
        }, 1000);

        resendButton.onclick = function(event) {
            event.preventDefault();
            window.location.href = 'resend_otp_forgot_password.php';
        };
    </script>
</div>

<?php
include_once("footer.php");

if (isset($_POST['otp_btn'])) 
{
    if (isset($_SESSION['forgot_email'])) {
        $email = $_SESSION['forgot_email'];
        $otp = $_POST['otp'];

        // Fetch OTP from database
        $query = "SELECT otp FROM password_token WHERE email = '$email'";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $db_otp = $row['otp'];

            if ($otp == $db_otp) {
                echo "<script>window.location.href = 'new_password_form.php';</script>";
            } else {
                setcookie('error', 'Incorrect OTP', time() + 5, '/');
                echo "<script>window.location.href = 'otp_form.php';</script>";
            }
        } else {
            setcookie('error', 'OTP has expired. Regenerate new OTP.', time() + 2, '/');
            echo "<script>window.location.href = 'Forgot_password.php';</script>";
        }
    }
}
?>