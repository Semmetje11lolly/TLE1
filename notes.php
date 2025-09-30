<?php
require_once "includes/logged.php";
/** @var $db mysqli */
require_once 'includes/config.php';

if (isset($_POST['submit'])) {

    $name = mysqli_escape_string($db, $_POST['name']);
    $description = mysqli_escape_string($db, $_POST['description']);
    $price = mysqli_escape_string($db, $_POST['price']);
    $stock = mysqli_escape_string($db, $_POST['stock']);

//server side-validation
    if ($name === '') {
        $errors['name'] = 'Name of the product must be filled';
    }
    if ($description === '') {
        $errors['description'] = 'Description must be filled';
    }
    if ($price === '') {
        $errors['price'] = 'Price of the product must be filled';
    } elseif (!is_numeric($price))
        $errors['price'] = 'Price must be a valid number';
    if ($stock === '') {
        $errors['stock'] = 'Stock number of the product must be filled';
    } elseif (!is_numeric($stock))
        $errors['stock'] = 'Stock must be a valid number';

    if (empty($errors)) {
        include_once 'includes/functions.php';
        $fileDestination = uploadImage();
        $image = substr($fileDestination, 3);
        $query = "
                    INSERT INTO products (name, description, price, stock, image)
                    VALUES ('$name','$description','$price','$stock','$image')
                    ";

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
        <form action="" method="post">
            <label for="textarea"></label>
            <textarea name="textarea" id="textarea" cols="30" rows="10"></textarea>
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