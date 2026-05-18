<?php
 require_once 'connect.php';

 $sql = file_get_contents("database.sql");
 $db->exec($sql);
 echo "Database Schema imported succesfully";
?>