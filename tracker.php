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
                <label class="label-form" for="angry"><i class="fa-regular fa-face-angry"></i></label>
                <h4>Angry</h4>
                <input class="input" id="angry" type="checkbox" name="mood" value="1"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="sad"><i class="fa-regular fa-face-frown"></i></label>
                <h4>Sad</h4>
                <input class="input" id="sad" type="checkbox" name="mood" value="2"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="meh"><i class="fa-regular fa-face-meh-blank"></i></label>
                <h4>Meh</h4>
                <input class="input" id="meh" type="checkbox" name="mood" value="3"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="good"><i class="fa-regular fa-face-smile"></i></label>
                <h4>Good</h4>
                <input class="input" id="good" type="checkbox" name="mood" value="4"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="happy"><i class="fa-regular fa-face-laugh-squint"></i></label>
                <h4>Happy</h4>
                <input class="input" id="happy" type="checkbox" name="mood" value="5"/>
            </div>
        </div>

        <h2 class="form-category">Energy</h2>
        <div class="form-content">
            <div class="form-option">
                <label class="label-form" for="low"><i class="fa-solid fa-1"></i></label>
                <h4>Low</h4>
                <input class="input" id="low" type="checkbox" name="energy" value="1"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="alright"><i class="fa-solid fa-2"></i></label>
                <h4>Meh</h4>
                <input class="input" id="alright" type="checkbox" name="energy" value="2"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="middle"><i class="fa-solid fa-3"></i></label>
                <h4>Middle</h4>
                <input class="input" id="middle" type="checkbox" name="energy" value="3"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="good"><i class="fa-solid fa-4"></i></label>
                <h4>Good</h4>
                <input class="input" id="good" type="checkbox" name="energy" value="4"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="full"><i class="fa-solid fa-5"></i></label>
                <h4>Full</h4>
                <input class="input" id="full" type="checkbox" name="energy" value="5"/>
            </div>
        </div>

        <h2 class="form-category">Bad Habit</h2>
        <div class="form-content">
            <div class="form-option">
                <label class="label-form" for="smoking"><i class="fa-solid fa-smoking"></i></label>
                <h4>Smoking</h4>
                <input class="input" id="smoking" type="checkbox" name="bad-habit" value="1"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="nail-bitting"><i class="fa-solid fa-hand-point-up"></i></label>
                <h4>Nail Bitting</h4>
                <input class="input" id="nail-bitting" type="checkbox" name="bad-habit" value="2"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="procrastinating"><i class="fa-solid fa-clock"></i></label>
                <h4>Procrastinating</h4>
                <input class="input" id="procrastinating" type="checkbox" name="bad-habit" value="3"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="alcohol"><i class="fa-solid fa-wine-glass"></i></label>
                <h4>Alcohol</h4>
                <input class="input" id="alcohol" type="checkbox" name="bad-habit" value="4"/>
            </div>
        </div>

        <h2 class="form-category">Hobbies</h2>
        <div class="form-content">
            <div class="form-option">
                <label class="label-form" for="reading"><i class="fa-solid fa-book-open-reader"></i></label>
                <h4>Reading</h4>
                <input class="input" id="reading" type="checkbox" name="hobbies" value="1"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="gaming"><i class="fa-solid fa-gamepad"></i></label>
                <h4>Gaming</h4>
                <input class="input" id="gaming" type="checkbox" name="hobbies" value="2"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="music"><i class="fa-solid fa-music"></i></label>
                <h4>Music</h4>
                <input class="input" id="music" type="checkbox" name="hobbies" value="3"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="writing"><i class="fa-solid fa-pen"></i></label>
                <h4>Writing</h4>
                <input class="input" id="writing" type="checkbox" name="hobbies" value="4"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="film"><i class="fa-solid fa-video"></i></label>
                <h4>Film</h4>
                <input class="input" id="film" type="checkbox" name="hobbies" value="5"/>
            </div>
        </div>

        <h2 class="form-category">Social</h2>
        <div class="form-content">
            <div class="form-option">
                <label class="label-form" for="family"><i class="fa-solid fa-people-roof"></i></label>
                <h4>Family</h4>
                <input class="input" id="family" type="checkbox" name="social" value="1"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="friends"><i class="fa-solid fa-people-group"></i></label>
                <h4>Friends</h4>
                <input class="input" id="friends" type="checkbox" name="social" value="2"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="alone"><i class="fa-solid fa-person"></i></label>
                <h4>Alone</h4>
                <input class="input" id="alone" type="checkbox" name="social" value="3"/>
            </div>
        </div>

        <h2 class="form-category">Locations</h2>
        <div class="form-content">
            <div class="form-option">
                <label class="label-form" for="home"><i class="fa-solid fa-house"></i></label>
                <h4>Home</h4>
                <input class="input" id="home" type="checkbox" name="locations" value="1"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="work"><i class="fa-solid fa-briefcase"></i></label>
                <h4>Work</h4>
                <input class="input" id="work" type="checkbox" name="locations" value="2"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="school"><i class="fa-solid fa-school"></i></label>
                <h4>School</h4>
                <input class="input" id="school" type="checkbox" name="locations" value="3"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="park"><i class="fa-solid fa-tree"></i></label>
                <h4>Park</h4>
                <input class="input" id="park" type="checkbox" name="locations" value="4"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="city"><i class="fa-solid fa-city"></i></label>
                <h4>City</h4>
                <input class="input" id="city" type="checkbox" name="locations" value="5"/>
            </div>
        </div>

        <h2 class="form-category">Food</h2>
        <div class="form-content">
            <div class="form-option">
                <label class="label-form" for="fast-food"><i class="fa-solid fa-burger"></i></label>
                <h4>Fast Food</h4>
                <input class="input" id="fast-food" type="checkbox" name="food" value="1"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="cooked"><i class="fa-solid fa-kitchen-set"></i></label>
                <h4>Cooked</h4>
                <input class="input" id="cooked" type="checkbox" name="food" value="2"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="snacks"><i class="fa-solid fa-cookie"></i></label>
                <h4>Snacks</h4>
                <input class="input" id="snacks" type="checkbox" name="food" value="3"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="soda"><i class="fa-solid fa-glass-water"></i></label>
                <h4>Soda</h4>
                <input class="input" id="soda" type="checkbox" name="food" value="4"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="restaurant"><i class="fa-solid fa-utensils"></i></label>
                <h4>Restaurant</h4>
                <input class="input" id="restaurant" type="checkbox" name="food" value="5"/>
            </div>
        </div>

        <h2 class="form-category">Sleep</h2>
        <div class="form-content">
            <div class="form-option">
                <label class="label-form" for="six-or-less-hours"><i class="fa-solid fa-minus"></i><i class="fa-solid fa-6"></i></label>
                <h4>Hours</h4>
                <input class="input" id="six-or-less-hours" type="checkbox" name="sleep" value="1"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="six-to-seven-hours"><i class="fa-solid fa-6"></i><i class="fa-solid fa-slash"></i><i class="fa-solid fa-7"></i></label>
                <h4>Hours</h4>
                <input class="input" id="six-to-seven-hours" type="checkbox" name="sleep" value="2"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="seven-to-eight-hours"><i class="fa-solid fa-7"></i><i class="fa-solid fa-slash"></i><i class="fa-solid fa-8"></i></label>
                <h4>Hours</h4>
                <input class="input" id="seven-to-eight-hours" type="checkbox" name="sleep" value="3"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="eight-or-more"><i class="fa-solid fa-8"></i><i class="fa-solid fa-plus"></i></label>
                <h4>Hours</h4>
                <input class="input" id="eight-or-more" type="checkbox" name="sleep" value="4"/>
            </div>
        </div>

        <h2 class="form-category">Emotions</h2>
        <div class="form-content">
            <div class="form-option">
                <label class="label-form" for="stressed"><i class="fa-solid fa-face-flushed"></i></label>
                <h4>Stressed</h4>
                <input class="input" id="stressed" type="checkbox" name="emotions" value="1"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="insecure"><i class="fa-solid fa-face-grimace"></i></label>
                <h4>Insecure</h4>
                <input class="input" id="insecure" type="checkbox" name="emotions" value="2"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="relaxed"><i class="fa-solid fa-face-smile-beam"></i></label>
                <h4>Relaxed</h4>
                <input class="input" id="relaxed" type="checkbox" name="emotions" value="3"/>
            </div>
            <div class="form-option">
                <label class="label-form" for="bored"><i class="fa-solid fa-face-meh"></i></label>
                <h4>Bored</h4>
                <input class="input" id="bored" type="checkbox" name="emotions" value="4"/>
            </div>
        </div>

        <button type="submit" name="submit">Add to diary</button>
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
