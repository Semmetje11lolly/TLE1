<?php
session_start();

/** @var mysqli $db */

// Require DB settings with connection variable
require_once "includes/config.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $inputPassword = $_POST['password'];

    if (empty($email) || empty($inputPassword)) {
        $errors[] = "fill your password!";
    }

    if (empty($errors)) {
        $query = "SELECT * FROM accounts WHERE email = '$email'";
        $result = mysqli_query($db, $query);

        if (!$result) {
            die('Error ' . mysqli_error($db) . ' met query ' . $query);
        }

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($inputPassword, $row['password'])) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['email'] = $row['email'];

                header("Location: index.php");
                exit;
            } else {
                $errors[] = "wrong password!";
            }
        } else {
            $errors[] = "Geen gebruiker gevonden met dit e-mailadres!";
        }
    }
}
?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="field">
<h1> Log IN</h1>

<div class="login-container">
    <form method="post" action="login.php">
        <div>
            <div class="control">
                <input class="input" placeholder="Email" type="text" id="email" name="email">
            </div>

            <div class="control">
                <input class="input"  placeholder="password" type="password" id="password" name="password" required>
            </div>

        <div class="buttons">
            <button class="button" type="submit">Log in</button>
            <a href="register.php">Register</a>
        </div>
            </div>
        </div>
    </form>

    </div>

</body>
</html>
