<?php
$host = 'ep-spring-cherry-aov76suf.c-2.ap-southeast-1.aws.neon.tech';
$port = '5432';
$dbname = 'neondb';
$user = 'neondb_owner';
$password = 'npg_3uVZ8KwHmhdj';

$conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require", $user, $password);
echo "Connected to Neon!";
?>