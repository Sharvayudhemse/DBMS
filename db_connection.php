<?php

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'parking_db';

$connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// to check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
