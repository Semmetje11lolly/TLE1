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
        <canvas id="myChart" width="40" height="20"></canvas>

        <div class="feelings">
            <h1>today’s feelings</h1>
            <p>diary note number: <?= $lastDiary['id'] ?><br>
             ur bad habits: <?= $lastDiary['bad_habit'] ?><br>
             ur hobbies: <?= $lastDiary['hobbies'] ?><br>
             ur social status: <?= $lastDiary['social'] ?><br>
             places you have been yesterday: <?= $lastDiary['location'] ?><br>
             food you ate last night: <?= $lastDiary['food'] ?><br>
             this is how much you slept: <?= $lastDiary['sleep'] ?><br>
             these were your emotions: <?= $lastDiary['emotions'] ?><br>
            </p>
        </div>

    </section>


    <section class="summary">
        <h2>todays summary</h2>
        <p>
            You spent the day at home watching movies and series. Your mood was **sad** with energy at **very low**. You noted that the development sprint starts tomorrow and you haven’t prepared anything yet, so you binged Netflix to avoid stress.
        </p>
    </section>

<!--    <section class="last-week">-->
<!--        <h3>Past 7 days</h3>-->
<!--        <p>-->
<!--            The week began with you feeling okay while reading and listening to music. On Wednesday you felt sad when the GenAI prototype didn’t work as expected. After‑school drinks later that day escalated a bit. Thursday brought useful progress as you felt okay and completed productive user testing. Yesterday you were **very happy** while watching movies, series, and listening to music. Today you are sad again.-->
<!--        </p>-->
<!--    </section>-->
<!---->
<!--    <section class="recurring-behavior">-->
<!--        <h4>recurring behavior</h4>-->
<!--        <p>-->
<!--            **Recurring Behaviors**    - You smoke the day after drinking alcohol; this occurred 1 time this week.    - You engage in creative activities like drawing and music after low‑mood days; this occurred 1 time.    - You spend time alone after social activities or drinking; this pattern occurred 3 times.    - You get poor sleep (6 hours or less) on days when you game; this happened 1 time.-->
<!--        </p>-->
<!--    </section>-->

</main>

<nav>
    <?php
    include_once "includes/nav.php";
    ?>
</nav>

</body>
</html>