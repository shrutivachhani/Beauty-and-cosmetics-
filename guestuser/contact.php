<?php
session_start(); // Start session to manage user state
include_once 'header.php';
include_once("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please log in first.'); window.location.href = 'login.php';</script>";
        exit();
    }

    $name = $con->real_escape_string($_POST['name']);
    $email = $con->real_escape_string($_POST['email']);
    $subject = $con->real_escape_string($_POST['subject']);
    $message = $con->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Message cannot be sent. Please try again later.');</script>";
        // Optionally, you can log the error for debugging
        error_log("Database error: " . $con->error);
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .wrapper h2 {
            text-align: center;
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }
        .input-box {
            margin-bottom: 20px;
        }
        .input-box input,
        .input-box textarea {
            width: 100%;
            padding: 15px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .input-box textarea {
            height: 100px;
            resize: vertical;
        }
        .input-box input:focus,
        .input-box textarea:focus {
            border-color: #d3658d;
            outline: none;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .input-box.button input {
            width: 100%;
            padding: 15px;
            background-color: #d3658d;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        .input-box.button input:hover {
            background-color: #b74a6d;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Contact Us</h2>
        <form id="contactForm" action="contact.php" method="POST" onsubmit="return validateContactForm()">
            <div class="input-box">
                <input type="text" id="name" name="name" placeholder="Enter your name">
                <span id="nameError" class="error"></span>
            </div>
            <div class="input-box">
                <input type="email" id="email" name="email" placeholder="Enter your email">
                <span id="emailError" class="error"></span>
            </div>
            <div class="input-box">
                <input type="text" id="subject" name="subject" placeholder="Enter subject">
                <span id="subjectError" class="error"></span>
            </div>
            <div class="input-box">
                <textarea id="message" name="message" placeholder="Enter your message"></textarea>
                <span id="messageError" class="error"></span>
            </div>
            <div class="input-box button">
                <input type="submit" value="SEND MESSAGE">
            </div>
        </form>
    </div>

    <script>
        function validateContactForm() {
            let isValid = true;
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const subject = document.getElementById('subject');
            const message = document.getElementById('message');
            const nameError = document.getElementById('nameError');
            const emailError = document.getElementById('emailError');
            const subjectError = document.getElementById('subjectError');
            const messageError = document.getElementById('messageError');

            // Clear previous errors
            nameError.innerHTML = "";
            emailError.innerHTML = "";
            subjectError.innerHTML = "";
            messageError.innerHTML = "";

            // Name validation
            if (name.value.trim() === "") {
                nameError.innerHTML = "Name is required.";
                isValid = false;
            }

            // Email validation
            const emailReg = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
            if (email.value.trim() === "") {
                emailError.innerHTML = "Email is required.";
                isValid = false;
            } else if (!emailReg.test(email.value)) {
                emailError.innerHTML = "Invalid email address.";
                isValid = false;
            }

            // Subject validation
            if (subject.value.trim() === "") {
                subjectError.innerHTML = "Subject is required.";
                isValid = false;
            }

            // Message validation
            if (message.value.trim() === "") {
                messageError.innerHTML = "Message is required.";
                isValid = false;
            }

            return isValid;
        }
    </script>

</body>
</html>
<?php
include 'footer.php';
?>
