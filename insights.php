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
        "mood" => $moodData,
        "energy" => $energyData,
    ]);
    exit;
}
// diary summary query
$today = date('Y-m-d');
$query = "SELECT `text`,`date` FROM diaries WHERE `date` = '$today'";
$summaryResult = mysqli_query($db, $query);
$summaryJSON = mysqli_fetch_assoc($summaryResult);
if (isset($summaryJSON)) $summaryText = json_decode($summaryJSON['text'], true);
if (!isset($summaryJSON)) $summaryJSON['date'] = null;

// all data query
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
            <?php if ($summaryJSON['date'] == $today) : ?>
                <h1>Today’s Feelings</h1>
            <?php else : ?>
                <h1>Yesterday's Feelings</h1>
            <?php endif; ?>
            <p>
                Bad habits: <?= $lastDiary['bad_habit'] ?><br>
                Hobbies: <?= $lastDiary['hobbies'] ?><br>
                Social status: <?= $lastDiary['social'] ?><br>
                Places you have been yesterday: <?= $lastDiary['location'] ?><br>
                Food you ate last night: <?= $lastDiary['food'] ?><br>
                How much you slept: <?= $lastDiary['sleep'] ?><br>
                Your emotions: <?= $lastDiary['emotions'] ?><br>
            </p>
        </div>

    </section>


    <section class="summary">
        <?php if ($summaryJSON['date'] == $today) : ?>
            <h1>Today's Summary</h1>

            <p>
                <?= $summaryText['todaySummary'] ?>
            </p>
        <?php endif; ?>
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