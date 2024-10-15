<?php
$host = "localhost";
$user = "root";
$port = "3306";
$password = "Anhhung98@";
$database = "app_sell";

// Establish the database connection
$conn = mysqli_connect($host, $user, $password, $database, $port);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set the character set to UTF-8
mysqli_set_charset($conn, 'utf8');


