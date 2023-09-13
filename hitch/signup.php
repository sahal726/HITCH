<?php
session_start();

include("connections.php");
include("functions.php");

// Function to validate the password
function validatePassword($password) {
    $uppercase = preg_match('/[A-Z]/', $password);
    $lowercase = preg_match('/[a-z]/', $password);
    $number = preg_match('/[0-9]/', $password);
    $length = strlen($password) >= 8;
    return $uppercase && $lowercase && $number && $length;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
    $email = $_POST['email'];
    $user_name = $_POST['uname'];
    $phone = $_POST['phNum'];
    $pass = $_POST['pass1'];
    $passRE = $_POST['pass2'];
    $name = $_POST['name'];

    if (!empty($email) && !empty($user_name) && !empty($phone) && !empty($pass) && !empty($passRE) && !empty($name)) {
        if ($pass == $passRE) {
            if (validatePassword($pass)) {
                // Check if the username is already taken
                $check_query = "SELECT * FROM users WHERE uname = '$user_name'";
                $check_result = mysqli_query($con, $check_query);

                if (mysqli_num_rows($check_result) > 0) {
                    echo '<script>  alert ( "Username already taken. Please choose a different username.")</script>';
                } else {
                    $query = "INSERT INTO users (name, email, uname, ph_no, password) VALUES ('$name', '$email', '$user_name', '$phone', '$pass')";

                    if (mysqli_query($con, $query)) {
                        header("Location: login.php");
                        exit;
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                }
            } else {
                echo '<script> alert("Password should be at least 8 characters long and include an uppercase letter, a lowercase letter, and a number.")</script>';
            }
        } else {
            echo '<script> alert("Passwords do not match")</script>';
        }
    } else {
        echo '<script> alert ("Please enter all required information!") </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hitch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital@1&display=swap" rel="stylesheet">
    <style>
        .password-strength {
            font-size: 12px;
            color: #dc3545;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<section id="navbar">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mx-5  bg-light">
            <h4 class="hitch-h1">hitch</h4>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-dark my-4">Log in</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</section>

<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1"
     role="dialog" id="modalSignin">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Sign up</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        fdprocessedid="4x0la6"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Your Name"
                               fdprocessedid="zrk37a" name="name" required>
                        <label for="floatingInput">Your Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3" id="floatingInput"
                               placeholder="name@example.com" fdprocessedid="f9bzpb" name="email" required>
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="text"
                               fdprocessedid="zrk37a" name="uname" required>
                        <label for="floatingInput">User Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="tel" class="form-control rounded-3" id="floatingInput" placeholder="number"
                               fdprocessedid="zrk37a" name="phNum" required>
                        <label for="floatingInput">Phone Number</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="passwordInput"
                               placeholder="Password" fdprocessedid="zrk37a" name="pass1" required>
                        <label for="passwordInput">Create Password</label>
                        <div id="passwordStrength" class="password-strength"></div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="confirmPasswordInput"
                               placeholder="Password" fdprocessedid="zrk37a" name="pass2" required>
                        <label for="confirmPasswordInput">Confirm Password</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" fdprocessedid="kpcbbk">
                        Sign up
                    </button>
                    <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script>
    const passwordInput = document.getElementById("passwordInput");
    const passwordStrength = document.getElementById("passwordStrength");

    passwordInput.addEventListener("input", function () {
        const password = passwordInput.value;
        const strength = getPasswordStrength(password);

        passwordStrength.textContent = getPasswordStrengthMessage(strength);
    });

    function getPasswordStrength(password) {
        // Function to calculate password strength based on your criteria
        const uppercase = /[A-Z]/.test(password);
        const lowercase = /[a-z]/.test(password);
        const number = /[0-9]/.test(password);
        const length = password.length >= 8;

        let strength = 0;
        if (uppercase) strength++;
        if (lowercase) strength++;
        if (number) strength++;
        if (length) strength++;

        return strength;
    }

    function getPasswordStrengthMessage(strength) {
        // Function to get password strength message based on strength value
        switch (strength) {
            case 0:
                return "";
            case 1:
                return "There must be 8 character,uppercase,lowercase,special character(.,@#$)";
            case 2:
                return "There must be 8 character,uppercase,lowercase,special character(.,@#$)";
            case 3:
                return "Strong password";
            case 4:
                return "Very strong password";
            default:
                return "";
        }
    }
</script>
</body>
</html>
