<?php
require_once "./includes/logged.php";

$userID = $user_info['id'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/1fe3729de2.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/diary.js" defer></script>
    <link rel="stylesheet" href="css/style.css"> <!-- Global styling -->
    <link rel="stylesheet" href="css/diary.css"> <!-- Page specific styling -->
    <title>Novara Health - Diary</title>
</head>
<body>
    <header>
        [Logo]
    </header>
    <main data-accountID="<?= $userID ?>">
        <div id="monthNavigation">
            <a id="prevMonth">&lt; Previous</a>
            <span id="currentMonth"></span>
            <a id="nextMonth">Next &gt;</a>
        </div>
        <div id="days"></div>
        <div id="calendar"></div>
        <h1 id="currentMonth"></h1>
        <div id="days"></div>
        <section id="calendar"></section>
    </main>
    <dialog class="modal">
        <div class="modalContent"></div>
    </dialog>
    <nav>
        <?php
            include_once "includes/nav.php"
        ?>
    </nav>
</body>
</html>
