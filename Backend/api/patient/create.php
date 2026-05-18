<?php
include("../../../Database/db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $user_id = $_POST['user_id'];

    $sql = "INSERT INTO patients (user_id)
            VALUES ('$user_id')";

    if(mysqli_query($conn, $sql)){
        echo "Patient created successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>