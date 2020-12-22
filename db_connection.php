<?php
$servername = "mysql-eyvazahmadzada12.alwaysdata.net";
$username = "190166";
$password = "e3665097";
$dbname = "eyvazahmadzada12_weather";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}