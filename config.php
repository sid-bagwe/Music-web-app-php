<?php

$databaseHost = 'localhost';
$databaseName = 'wp2_miniproject_db';
$databaseUsername = 'root';
$databasePassword = '';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if (!$mysqli) {
    die('Connection failed: ' . mysql_error());
}else{
    // echo "Database Connected successfully"; // in case of success
}
?>