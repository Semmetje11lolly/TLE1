<?php
require_once "logged.php";
require_once "config.php";

$today = date('Y-m-d');
$userID = $user_info['id'];

$query = "DELETE FROM `diaries` WHERE `date` = '$today' AND `account_id` = '$userID'";
$result = mysqli_query($db, $query);

$query = "DELETE FROM `insights` WHERE `dates` = '$today'";
$result = mysqli_query($db, $query);

header('location: ../tracker.php');