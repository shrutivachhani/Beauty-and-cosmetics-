<?php
include_once("header.php");
?>

<script>
    $(document).ready(function() {
        $("#form1").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                pswd: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                pswd: {
                    required: "Please provide a password"
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
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });

        // Custom login logic for redirecting based on username and password
        $('#form1').submit(function(event) {
            var email = $('#email').val();
            var password = $('#pwd').val();

            // Check if email is "admin" and password is "admin123"
            if (email === 'admin@gmail.com' && password === 'admin123') {
                // Redirect to the admin page
                window.location.href = '../admin/index.php';
                event.preventDefault(); // Prevent form from submitting
            } 
        });
    });
</script>

<div class="container">
    <div class="row text-center">
        <div class="col-12 bg-dark text-white p-4 align-center">
            <h1>Login</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-2"></div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-xs-12 col-sm-12">
            <br>
            <form action="login_action.php" method="post" id="form1">
                <div class="form-group">
                    <label for="email"><b>Email:</b></label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="pwd"><b>Password:</b></label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
                </div>
                <br>
                <div class="form-group form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember"> Remember me
                    </label>
                </div>
                <a href="Forgot_password.php">Forgot Password?</a>
                
                <br><br>
                <input type="submit" class="btn btn-success" value="Submit" name="lgn_btn" /><br>
                Don't have and account?
                <a href="register1.php">Register here</a>
            </form>
        </div>
    </div>
    <br>
</div>

<?php
include_once("footer.php");
?>
