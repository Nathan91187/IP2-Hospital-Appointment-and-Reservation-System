<?php
try {
    $dsn = "pgsql:host=ep-spring-cherry-aov76suf.c-2.ap-southeast-1.aws.neon.tech;
            port=5432;
            dbname=neondb;
            sslmode=require;
            options=endpoint=ep-spring-cherry-aov76suf";
    $user = "neondb_owner";
    $password = "npg_3uVZ8KwHmhdj";
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>