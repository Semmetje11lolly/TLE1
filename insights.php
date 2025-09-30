<?php
global $db;
require_once "includes/config.php";


if (isset($_GET['json'])) {
    // Query moods
    $queryMood = "SELECT dates, mood, id FROM insights ORDER BY id DESC LIMIT 7 ";
    $resultMood = mysqli_query($db, $queryMood);
    $moodData = [];
    while ($row = mysqli_fetch_assoc($resultMood)) {
        $moodData[] = $row;
    }
    $moodData = array_reverse($moodData);

    // Query energy
    $queryEnergy = "SELECT dates, energy, id FROM insights ORDER BY id DESC LIMIT 7 ";
    $resultEnergy = mysqli_query($db, $queryEnergy);
    $energyData = [];
    while ($row = mysqli_fetch_assoc($resultEnergy)) {
        $energyData[] = $row;
    }
    $energyData = array_reverse($energyData);

    mysqli_close($db);

    // Return JSON instead of HTML
    header('Content-Type: application/json');
    echo json_encode([
        "mood"   => $moodData,
        "energy" => $energyData
    ]);
    exit; // 🚨 stop execution here (no HTML printed)
}

// --- Normal page render (HTML) ---
$query = "SELECT * FROM insights ORDER BY id DESC LIMIT 1";
$result = mysqli_query($db, $query);
$lastDiary = mysqli_fetch_assoc($result);
mysqli_close($db);


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/1fe3729de2.js" crossorigin="anonymous"></script> <!-- Icon Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/insight.js" defer></script>
    <link rel="icon" type="image/x-icon" href="/img/logo.png"> <!-- Tab icon -->
    <link rel="stylesheet" href="css/style.css"> <!-- Global styling -->
    <link rel="stylesheet" href="css/index.css"> <!-- Page specific styling -->
    <link rel="stylesheet" href="css/insights.css">

</head>
<body>

<header>
    <img src="img/logo.png" alt="Logo">
    <div class="empty-div"></div>

</header>

<main>

    <section class="step-counter">
        <div class="step-background"></div>
        <div class="step-progress"></div>
        <span style="font-size: 55px; transform: translateY(-250px)">3067</span>
        <span style="transform: translateY(-260px)">/6000 <i class="fa-solid fa-person-walking"></i></span>
        <span style="margin-top: -235px">You're halfway! Keep up the good work!</span>
    </section>

    <section class="graph">

        <div class="feelings">
            <p> diary note number: <?= $lastDiary['id'] ?></p>
            <p> ur bad habits: <?= $lastDiary['bad_habit'] ?></p>
            <p> ur hobbies: <?= $lastDiary['hobbies'] ?></p>
            <p> ur social status: <?= $lastDiary['social'] ?></p>
            <p> places you have been yesterday: <?= $lastDiary['location'] ?></p>
            <p> food you ate last night: <?= $lastDiary['food'] ?></p>
            <p> this is how much you slept: <?= $lastDiary['sleep'] ?></p>
            <p> these were your emotions: <?= $lastDiary['emotions'] ?></p>
        </div>
        <canvas id="myChart" width="40" height="20"></canvas>
    </section>

<p>hi</p>


</main>

<nav>
    <?php
    include_once "includes/nav.php";
    ?>
</nav>

</body>
</html>