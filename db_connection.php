<?php
$servername = "mysql-eyvazahmadzada.alwaysdata.net";
$username = "225205";
$password = "e3665097";
$dbname = "eyvazahmadzada_myskyl";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}