<?php

$host = "localhost";
$user = "root";
$pass = "_N1q2w3e4r5t";
$db = "hospital_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>