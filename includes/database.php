<?php

//general settings
$host       = '127.0.0.1';
$database   = 's16135_healthapp';
$user       = 'u16135_f4prHKcgXP';
$password   = 'wh^i74s2+LSR=KYSTIH.X6=D';



//make connection to the database
$db = mysqli_connect($host, $user, $password, $database)
or die("Error: " . mysqli_connect_error());

