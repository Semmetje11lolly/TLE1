<?php

// THIS FUNCTION ALLOWS FOR RETRIEVING INFORMATION FROM THE DATABASE
// IN JAVASCRIPT.
//
// CURRENTLY, THE ONLY DATA THAT CAN BE RETRIEVED IS:
// - A diary entry (based on account-id and calendar-day-id)

/** @var mysqli $db */
require_once 'config.php';
header("Content-Type: application/json");

if ($_GET['type'] === 'diary') {
    $dayID = $_GET['dayID'];
    $accountID = $_GET['accountID'];

    if (empty($dayID)) {
        http_response_code(418);
        echo json_encode(['error' => "Not found: dayID parameter is required"]);
    }
    if (empty($accountID)) {
        http_response_code(418);
        echo json_encode(['error' => "Not found: accountID parameter is required"]);
    }

    $fullDate = date('Y-m') . '-' . $dayID;

    $query = "SELECT * from `diaries` WHERE `date` = '$fullDate' AND `account_id` = $accountID";

    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $diary[] = $row;
    };

    echo json_encode($diary);
} else {
    http_response_code(404);
    echo json_encode(['error' => "Not found: Type {$_GET['type']} does not exist"]);
}