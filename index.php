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
    <script type="text/javascript" src="js/index.js" defer></script>
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
        <form action="tracker.php" method="post">
            <div class="form-content">
                <div class="form-option">
                    <label class="label-form" for="angry"><i class="fa-regular fa-face-angry"></i></label>
                    <h4>Angry</h4>
                    <input class="input-radio" id="angry" type="radio" name="mood[]" value="1"/>
                </div>
                <div class="form-option">
                    <label class="label-form" for="sad"><i class="fa-regular fa-face-frown"></i></label>
                    <h4>Sad</h4>
                    <input class="input-radio" id="sad" type="radio" name="mood[]" value="2"/>
                </div>
                <div class="form-option">
                    <label class="label-form" for="meh"><i class="fa-regular fa-face-meh-blank"></i></label>
                    <h4>Meh</h4>
                    <input class="input-radio" id="meh" type="radio" name="mood[]" value="3"/>
                </div>
                <div class="form-option">
                    <label class="label-form" for="good"><i class="fa-regular fa-face-smile"></i></label>
                    <h4>Good</h4>
                    <input class="input-radio" id="good" type="radio" name="mood[]" value="4"/>
                </div>
                <div class="form-option">
                    <label class="label-form" for="happy"><i class="fa-regular fa-face-laugh-squint"></i></label>
                    <h4>Happy</h4>
                    <input class="input-radio" id="happy" type="radio" name="mood[]" value="5"/>
                </div>
            </div>
        </form>
    </section>
</main>

<nav>
    <?php
    include_once "includes/nav.php";
    ?>
</nav>

</body>
</html>