<?php
$conn = mysqli_connect("localhost", "root", "", "hospital");

if(!$conn){
    die("DB connection failed: " . mysqli_connect_error());
}
?>