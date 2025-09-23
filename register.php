<?php
/** @var mysqli $db */

// Require DB settings with connection variable
require_once "includes/database.php";

// Get form data
// POST-BACK
$name = mysqli_real_escape_string($db, $_POST['name']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$password = $_POST['password'];

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

// If data valid
// POST
if (empty($errors)) {
    // Create a secure password, with the PHP function password_hash()
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Store the new user in the database.
    $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        // If query succeeded

        // Redirect to login page
        header("Location: login.php");
        exit;
    } else {
        $errors['database'] = 'Something went wrong while saving the user. Please try again.';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register form</title>
</head>
<body>
<h1> Register </h1>
<div class="container">
    <form action ="register.php" method="post">
        <div class="form-group">
            <input type="text" name="name" placeholder="Name">
        </div>

        <input type="text" name="email" placeholder="Email">
</div>

<input type="password" name="password" placeholder="Password">
</div>

<input type="text" name="reapeat_password" placeholder=" Repeat Password">
</div>

<div class="form-group">
    <input type="submit"  value="Register" name="register">
</div>

</form>


</body>
</html>