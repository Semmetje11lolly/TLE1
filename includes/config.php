<?php

//general settings
$host = 'sql2.revivenode.com:3306';
$database = 's16135_healthapp';
$user = 'u16135_f4prHKcgXP';
$password = 'WObKN^.PZ30Aha6XPIqRWQif';


//make connection to the database
$db = mysqli_connect($host, $user, $password, $database)
or die("Error: " . mysqli_connect_error());