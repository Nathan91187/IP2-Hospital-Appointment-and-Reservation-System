<?php
include("../../../Database/db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $doctor_id = $_POST['doctor_id'];
    $patient_id = $_POST['patient_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    $sql = "INSERT INTO appointments 
            (doctor_id, patient_id, appointment_date, appointment_time)
            VALUES
            ('$doctor_id', '$patient_id', '$appointment_date', '$appointment_time')";

    if(mysqli_query($conn, $sql)){
        echo "Appointment booked successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>