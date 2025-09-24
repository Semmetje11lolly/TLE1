<?php

// This file checks if the user is logged in to be able to access
// certain pages. If the user is not logged in, redirect to the login page,
// if the user is logged in, send the user to the correct page and get all
// info from the database about this user.

session_start();

// Is user logged in?
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
} else {
    /** @var $db mysqli */
    require_once 'config.php';

    $user_email = $_SESSION['user'];
    $user_query = "SELECT * FROM accounts WHERE email = '$user_email'";

    $user_result = mysqli_query($db, $user_query)
    or die('Error ' . mysqli_error($db) . ' with query ' . $user_query);

    $user_info = mysqli_fetch_assoc($user_result);

    if (empty($user_info)) {
        session_destroy();
        header('Location: ../login.php');
        exit();
    }
}