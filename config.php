<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "complaint-system";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed!");
}
?>