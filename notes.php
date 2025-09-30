<?php
require_once "includes/logged.php";
/** @var $db mysqli */
require_once 'includes/config.php';

if (isset($_GET['id'])) {
    $hiddenID = $_GET['id'];
    $accountID = $user_info['id'];
} else {
    header('location: tracker.php');
}

if (isset($_POST['submit'])) {

    $note = mysqli_escape_string($db, $_POST['textarea']);
    $date = date('Y-m-d');

    if (empty($errors)) {
        include_once 'includes/functions.php';
        $fileDestination = uploadImage();
        $image = $fileDestination;
        $query = "
                    INSERT INTO diaries (account_id, date, image_url)
                    VALUES ($accountID,'$date', '$image')
                    ";

        $result = mysqli_query($db, $query);

        $last_id = mysqli_insert_id($db);

        $query = "
                UPDATE `insights`
                SET `diary_id`='$last_id'
                WHERE id = '$hiddenID'";

        $result = mysqli_query($db, $query);

        mysqli_close($db);

        if ($result) {
            header('Location: insights.php');
            // Exit the code
            exit();
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/1fe3729de2.js" crossorigin="anonymous"></script> <!-- Icon Library -->
    <script type="text/javascript" src="js/notes.js" defer></script>
    <link rel="stylesheet" href="css/style.css"> <!-- Global styling -->
    <link rel="stylesheet" href="css/notes.css"> <!-- Page specific styling -->
    <title>Novara Health • Notes</title>
</head>
<body>

<header>
    [Logo]
</header>

<main>

    <section class="form">
        <i class="fa-solid fa-microphone" aria-hidden="true"></i>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="textarea"></label>
            <textarea name="textarea" id="textarea" cols="30" rows="10"></textarea>
            <input type="file" name="image" id="image" accept="image/*" required>
            <input type="hidden" id="insight_id" name="insight_id" value=<?= $hiddenID ?>>
            <button type="submit" name="submit">Save</button
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