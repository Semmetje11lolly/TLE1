<?php
require_once "./includes/logged.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/1fe3729de2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css"> <!-- Global styling -->
    <link rel="stylesheet" href="css/account.css"> <!-- Page specific styling -->
    <title>Novara Health - Account</title>
</head>
<body>
    <header>
        [Logo]
    </header>
    <main>
        <h1>Account Settings</h1>
        <div class="flex-items">
            <p>Account Name: <?= $user_info['name'] ?></p>
            <a href="#">Edit</a>
        </div>
        <div class="flex-items">
            <p>Account Email: <?= $user_info['email'] ?></p>
            <a href="#">Edit</a>
        </div>
        <div class="flex-items">
            <p>Account Password: ***</p>
            <a href="#">Edit</a>
        </div>
    </main>
    <nav>
        <?php
            include_once "includes/nav.php"
        ?>
    </nav>
</body>
</html>