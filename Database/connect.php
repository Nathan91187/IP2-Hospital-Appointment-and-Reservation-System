<?php

try {

    $host = "mysql-1a704d14-hospital-reservation.e.aivencloud.com";
    $port = 25416;
    $dbname = "defaultdb";
    $user = "avnadmin";
    $password = "AVNS_5s4RCfx0eUNHijuILMj";

    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

    $db = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);


} catch (PDOException $e) {

    die("Connection failed: " . $e->getMessage());
}