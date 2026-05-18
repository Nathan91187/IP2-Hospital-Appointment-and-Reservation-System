<?php

include '../../../Database/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctor_id = $_POST['doctor_id'];
    $patient_id = $_POST['patient_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];


    if (
        empty($doctor_id) ||
        empty($patient_id) ||
        empty($appointment_date) ||
        empty($appointment_time)
    ) {

        die("All fields are required");
    }


    $doctorCheck = "
    SELECT *
    FROM doctors
    WHERE doctor_id = ?
    ";

    $stmt = $db->prepare($doctorCheck);

    $stmt->execute([$doctor_id]);

    if ($stmt->rowCount() == 0) {

        die("Doctor does not exist");
    }


    $patientCheck = "
    SELECT *
    FROM patients
    WHERE patient_id = ?
    ";

    $stmt = $db->prepare($patientCheck);

    $stmt->execute([$patient_id]);

    if ($stmt->rowCount() == 0) {

        die("Patient does not exist");
    }


    $insert = "
    INSERT INTO appointments
    (
        patient_id,
        doctor_id,
        appointment_date,
        appointment_time
    )
    VALUES (?, ?, ?, ?)
    ";

    $stmt = $db->prepare($insert);

    $success = $stmt->execute([
        $patient_id,
        $doctor_id,
        $appointment_date,
        $appointment_time
    ]);

    if ($success) {

    header("Location: ../../../Frontend/patient/index.php");
    exit;

} else {

    echo "Booking failed";
}
}
?>