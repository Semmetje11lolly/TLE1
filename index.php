<?php
require_once "./includes/logged.php";


$username = $user_info['name'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/1fe3729de2.js" crossorigin="anonymous"></script> <!-- Icon Library -->
    <link rel="icon" type="image/x-icon" href="/img/logo.png"> <!-- Tab icon -->
    <link rel="stylesheet" href="css/style.css"> <!-- Global styling -->
    <link rel="stylesheet" href="css/index.css"> <!-- Page specific styling -->
    <title>Novara Health • Home</title>
</head>
<body>

<header>
    <img src="img/logo.png" alt="Logo">
    <div class="empty-div"></div>
    Hey, <?= $username ?>!
</header>

<main>
    <section class="step-counter">
        <div class="step-background"></div>
        <div class="step-progress"></div>
        <span style="font-size: 55px; transform: translateY(-250px)">3067</span>
        <span style="transform: translateY(-260px)">/6000 <i class="fa-solid fa-person-walking"></i></span>
        <span style="margin-top: -235px">You're halfway! Keep up the good work!</span>
    </section>
    <section class="mood-selector">

    </section>
</main>

<nav>
    <?php
    include_once "includes/nav.php";
    ?>
</nav>

</body>
</html>