<?php
global $db;
require_once "includes/config.php";


if (isset($_GET['json'])) {
    // Query moods
    $queryMood = "SELECT dates, mood FROM insights ORDER BY diary_id ASC";
    $resultMood = mysqli_query($db, $queryMood);
    $moodData = [];
    while ($row = mysqli_fetch_assoc($resultMood)) {
        $moodData[] = $row;
    }

    // Query energy
    $queryEnergy = "SELECT dates, energy FROM insights ORDER BY diary_id ASC";
    $resultEnergy = mysqli_query($db, $queryEnergy);
    $energyData = [];
    while ($row = mysqli_fetch_assoc($resultEnergy)) {
        $energyData[] = $row;
    }

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
$query = "SELECT * FROM insights ORDER BY diary_id DESC LIMIT 1";
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
    <canvas id="myChart" width="40" height="20"></canvas>
<p>hi</p>

    <p> diary note number: <?= $lastDiary['id'] ?></p>
    <p> ur bad habits: <?= $lastDiary['bad_habit'] ?></p>
    <p> ur hobbies: <?= $lastDiary['hobbies'] ?></p>
    <p> ur social status: <?= $lastDiary['social'] ?></p>
    <p> places you have been yesterday: <?= $lastDiary['location'] ?></p>
    <p> food you ate last night: <?= $lastDiary['food'] ?></p>
    <p> this is how much you slept: <?= $lastDiary['sleep'] ?></p>
    <p> these were your emotions: <?= $lastDiary['emotions'] ?></p>
</main>

<nav>
    <?php
    include_once "includes/nav.php";
    ?>
</nav>

</body>
</html>