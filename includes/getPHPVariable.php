<?php

// THIS FUNCTION ALLOWS FOR RETRIEVING INFORMATION FROM THE DATABASE
// IN JAVASCRIPT.
//
// CURRENTLY, THE ONLY DATA THAT CAN BE RETRIEVED IS:
// - A diary entry (based on account-id and calendar-day-id)
// - Images (based on date)

/** @var mysqli $db */
require_once 'config.php';
header("Content-Type: application/json");

if ($_GET['type'] === 'diary') {
    $dayID = $_GET['dayID'];
    $month = $_GET['month'];
    $year = $_GET['year'];
    $accountID = $_GET['accountID'];

    if (empty($dayID)) {
        http_response_code(418);
        echo json_encode(['error' => "Not found: dayID parameter is required"]);
    }
    if (empty($accountID)) {
        http_response_code(418);
        echo json_encode(['error' => "Not found: accountID parameter is required"]);
    }
    if (empty($year)) {
        http_response_code(418);
        echo json_encode(['error' => "Not found: year parameter is required"]);
    }
    if (empty($month)) {
        http_response_code(418);
        echo json_encode(['error' => "Not found: month parameter is required"]);
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    $fullDate = "$year-$month-$dayID";

    $query = "SELECT * from `diaries` WHERE `date` = '$fullDate' AND `account_id` = $accountID";
    $result = mysqli_query($db, $query);

    $diary = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $diary[] = $row;
    }

    echo json_encode($diary);
} else if ($_GET['type'] === 'monthDiaries') {
    $accountID = $_GET['accountID'];
    $year = $_GET['year'];
    $month = str_pad($_GET['month'], 2, "0", STR_PAD_LEFT);

    if (empty($year) || empty($month) || empty($accountID)) {
        http_response_code(418);
        echo json_encode(['error' => "year, month en accountID zijn verplicht"]);
        exit;
    }

    $query = "SELECT `date`, `image_url` FROM `diaries` WHERE `account_id` = $accountID AND `date` LIKE '$year-$month-%'";

    $result = mysqli_query($db, $query);

    $entries = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $entries[] = $row;
    }

    echo json_encode($entries);
} else {
    http_response_code(404);
    echo json_encode(['error' => "Not found: Type {$_GET['type']} does not exist"]);
}