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
  <p>Hello World</p>

    <section class="form-group">
        <form action="" method="post">
            <div class="field">
                <p>Mood</p>

                <label class="label" for="one">1</label>
                <input class="input" id="one" type="checkbox" name="one" value="<?= $one ?>"/>

                <label class="label" for="two">2</label>
                <input class="input" id="two" type="checkbox" name="two" value="<?= $two ?>"/>

                <label class="label" for="three">3</label>
                <input class="input" id="three" type="checkbox" name="three" value="<?= $three ?>"/>

                <label class="label" for="four">4</label>
                <input class="input" id="four" type="checkbox" name="four" value="<?= $four ?>"/>

                <label class="label" for="five">5</label>
                <input class="input" id="five" type="checkbox" name="five" value="<?= $five ?>"/>
            </div>

<!--            <div class="field">-->
<!--                <p>energy</p>-->
<!--                <label class="label" for="one">1</label>-->
<!--                <input class="input" id="one" type="checkbox" name="one" value="--><?php //= $one ?><!--"/>-->
<!---->
<!--                <label class="label" for="two">2</label>-->
<!--                <input class="input" id="two" type="checkbox" name="two" value="--><?php //= $two ?><!--"/>-->
<!---->
<!--                <label class="label" for="three">3</label>-->
<!--                <input class="input" id="three" type="checkbox" name="three" value="--><?php //= $three ?><!--"/>-->
<!---->
<!--                <label class="label" for="four">4</label>-->
<!--                <input class="input" id="four" type="checkbox" name="four" value="--><?php //= $four ?><!--"/>-->
<!---->
<!--                <label class="label" for="five">5</label>-->
<!--                <input class="input" id="five" type="checkbox" name="five" value="--><?php //= $five ?><!--"/>   -->
<!--            </div>-->
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
