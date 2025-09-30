<?php
/** @var mysqli $db */

// Require DB settings with connection variable
require_once "includes/config.php";

if(isset($_POST['submit'])) {
    // Get form data
    // POST-BACK
    $name = mysqli_real_escape_string($db, $_POST['name'] ??'');
    $email = mysqli_real_escape_string($db, $_POST['email'] ??'');
    $password = $_POST['password'] ??'';
    $repeatPassword = $_POST['repeatPassword'] ??'';

// Initialize errors array
    $errors = [];

// Server-side validation
// POST-BACK
    if (empty($name)) {
        $errors['name'] = 'Name is required.';
    }

// Is it a valid email?
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'A valid email address is required.';
    }

// Is the password 8 characters long?
    if (empty($password) || strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long.';
    }

    if(empty($repeatPassword) || $repeatPassword !== $password) {
        $errors['repeatPassword'] = 'Passwords are not the same!';
    }

// If data valid
// POST
    if (empty($errors)) {
        // Create a secure password, with the PHP function password_hash()
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Store the new user in the database.
        $query = "INSERT INTO accounts (name, email, password) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            // If query succeeded

            // Redirect to login page
            header("Location: login.php");
            exit;
        } else {
            $errors['database'] = 'Something went wrong while saving the user. Please try again.';
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register form</title>
    <link rel="icon" type="image/x-icon" href="/img/logo.png"> <!-- Tab icon -->
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animation.css">
    <script src="js/animation.js"></script>
</head>


<body>

<!--animation-->


<div class="container-animation">
    <div class="logo" id="animatedLogo">
        <svg viewBox="0 0 100 100" width="100" height="100">
            <circle cx="50" cy="50" r="40" fill="#4F46E5"/>
            <text x="50" y="58" text-anchor="middle" fill="white" font-size="24" font-weight="bold">LOGO</text>
        </svg>
    </div>
</div>

<div class="container">
    <a href="login.php" class="back-btn">Back</a>
<h1> Register </h1>

    <form action ="register.php" method="post">
        <div class="form-group">

            <div>
            <input type="text" id="name" name="name" placeholder="Name">
             </div>
        <div>
        <input type="text" name="email" placeholder="Email">
        </div>

        <div>
        <input type="password" name="password" placeholder="Password">
        </div>
            <div>
                <input type="password" name="repeatPassword" placeholder=" Repeat Password">
            </div>


         <div>
         <input type="submit"  value="Register" name="submit">
         </div>


      </form>

      </div>



</body>

</html>