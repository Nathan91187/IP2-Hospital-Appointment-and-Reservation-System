<?php
$db_url = "postgresql://neondb_owner:npg_3uVZ8KwHmhdj@ep-spring-cherry-aov76suf.c-2.ap-southeast-1.aws.neon.tech/neondb?sslmode=require";

try {
    $conn = new PDO($db_url);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Successfully connected to Neon PostgreSQL!\n";
    
    $result = $conn->query("SELECT version()");
    $version = $result->fetch();
    echo "PostgreSQL version: " . $version[0] . "\n";
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
?>