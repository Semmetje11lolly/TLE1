<?php
// PHP here

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/1fe3729de2.js" crossorigin="anonymous"></script> <!-- Icon Library -->
    <link rel="stylesheet" href="css/style.css"> <!-- Global styling -->
    <link rel="stylesheet" href="css/tracker.css"> <!-- Page specific styling -->
    <title>Novara Health • Home</title>
</head>
<body>

<header>
    [Logo]
    <div class="empty-div"></div>
</header>

<main>

    <form action="" method="post">
        <h2 class="form-category">Mood</h2>
        <div class="form-content">
            <div class="form-option">
                <label class="label" for="one"><i class="fa-regular fa-face-angry"></i></label>
                <h4>Angry</h4>
                <input class="input" id="one" type="checkbox" name="one" value="Option 1"/>
            </div>
            <div class="form-option">
                <label class="label" for="two"><i class="fa-regular fa-face-frown"></i></label>
                <h4>Sad</h4>
                <input class="input" id="two" type="checkbox" name="two" value="Option 2"/>
            </div>
            <div class="form-option">
                <label class="label" for="three"><i class="fa-regular fa-face-meh-blank"></i></label>
                <h4>Meh</h4>
                <input class="input" id="three" type="checkbox" name="three" value="Option 3"/>
            </div>
            <div class="form-option">
                <label class="label" for="four"><i class="fa-regular fa-face-smile"></i></label>
                <h4>Good</h4>
                <input class="input" id="four" type="checkbox" name="four" value="Option 4"/>
            </div>
            <div class="form-option">
                <label class="label" for="five"><i class="fa-regular fa-face-laugh-squint"></i></label>
                <h4>Happy</h4>
                <input class="input" id="five" type="checkbox" name="five" value="Option 5"/>
            </div>
        </div>
    </form>


































<!--    <p>Hello World</p>-->
<!--        <form action="" method="post">-->
<!---->
<!--            <div class="form-field">-->
<!---->
<!--                <div>-->
<!--                   <p>Mood</p>-->
<!--                </div>-->
<!---->
<!--                <div class="form-content-container">-->
<!--                    <div class="form-content">-->
<!--                        <label class="label" for="one"><i class="fa-regular fa-face-angry"></i></label>-->
<!--                        <input class="input" id="one" type="checkbox" name="one" value="--><?php //= $one ?><!--"/>-->
<!--                    </div>-->
<!---->
<!--                    <div class="form-content">-->
<!--                        <label class="label" for="two"><i class="fa-regular fa-face-frown"></i></label>-->
<!--                        <input class="input" id="two" type="checkbox" name="two" value="--><?php //= $two ?><!--"/>-->
<!--                    </div>-->
<!---->
<!--                    <div class="form-content">-->
<!--                        <label class="label" for="three"><i class="fa-regular fa-face-meh-blank"></i></label>-->
<!--                        <input class="input" id="three" type="checkbox" name="three" value="--><?php //= $three ?><!--"/>-->
<!--                    </div>-->
<!---->
<!--                    <div class="form-content">-->
<!--                        <label class="label" for="four"><i class="fa-regular fa-face-smile"></i></label>-->
<!--                        <input class="input" id="four" type="checkbox" name="four" value="--><?php //= $four ?><!--"/>-->
<!--                    </div>-->
<!---->
<!--                    <div class="form-content">-->
<!--                        <label class="label" for="five"><i class="fa-regular fa-face-laugh-squint"></i></label>-->
<!--                        <input class="input" id="five" type="checkbox" name="five" value="--><?php //= $five ?><!--"/>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </form>-->
</main>

<nav>
    <?php
    include_once "includes/nav.php";
    ?>
</nav>

</body>
</html>
