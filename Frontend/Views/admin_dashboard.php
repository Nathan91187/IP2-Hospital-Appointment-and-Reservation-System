<?php

include "../../Database/connect.php";

$error = "";
$success = "";



$patientQuery = "
SELECT COUNT(*) AS total
FROM patients
";

$stmt = $db->prepare($patientQuery);

$stmt->execute();

$patients = $stmt->fetch(PDO::FETCH_ASSOC)['total'];



$doctorQuery = "
SELECT COUNT(*) AS total
FROM doctors
";

$stmt = $db->prepare($doctorQuery);

$stmt->execute();

$doctors = $stmt->fetch(PDO::FETCH_ASSOC)['total'];



$appointmentQuery = "
SELECT COUNT(*) AS total
FROM appointments
";

$stmt = $db->prepare($appointmentQuery);

$stmt->execute();

$appointments = $stmt->fetch(PDO::FETCH_ASSOC)['total'];




if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $specialization = trim($_POST['specialization']);



    if (
        empty($full_name) ||
        empty($username) ||
        empty($email) ||
        empty($password) ||
        empty($confirm) ||
        empty($specialization)
    ) {

        $error = "All fields are required";

    }

    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Invalid email format";

    }

    else if (strlen($password) < 6) {

        $error = "Password must be at least 6 characters";

    }

    else if ($password !== $confirm) {

        $error = "Passwords do not match";

    }

    else {


        $check = "
        SELECT *
        FROM users
        WHERE email = ?
        ";

        $stmt = $db->prepare($check);

        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {

            $error = "Email already exists";

        }

        else {

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $insertUser = "
            INSERT INTO users
            (
                username,
                email,
                password_hash,
                full_name,
                role
            )
            VALUES (?, ?, ?, ?, 'doctor')
            ";

            $stmt = $db->prepare($insertUser);

            $stmt->execute([
                $username,
                $email,
                $hashedPassword,
                $full_name
            ]);


            $doctor_id = $db->lastInsertId();


            $insertDoctor = "
            INSERT INTO doctors
            (
                doctor_id,
                specialization
            )
            VALUES (?, ?)
            ";

            $stmt = $db->prepare($insertDoctor);

            $successInsert = $stmt->execute([
                $doctor_id,
                $specialization
            ]);

            if ($successInsert) {

                $success = "Doctor created successfully";

                $doctors++;

            } else {

                $error = "Failed to create doctor";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../CSS/admin_dashboard.css">
</head>
<body>

<div class="top-header">
    Dashboard: Admin
</div>

<div class="main-container">

    <!-- NAVBAR -->
    <div class="navbar">
        <h2>XYZ</h2>

        <div class="nav-links">
            <a href="#">Home</a>
            <a href="login.php">Logout</a>
        </div>
    </div>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Total Patients</h3>
            <p><?= $patients ?></p>
        </div>

        <div class="card">
            <h3>Total Doctors</h3>
            <p><?= $doctors ?></p>
        </div>

        <div class="card">
            <h3>Total Appointments</h3>
            <p><?= $appointments ?></p>
        </div>

    </div>

    <!-- CREATE DOCTOR -->
    <div class="doctor-section">

        <h1>Create Doctor</h1>

        <!-- ERROR MESSAGE -->
        <?php if ($error != ""): ?>
            <div class="error-box"><?= $error ?></div>
        <?php endif; ?>

        <!-- SUCCESS MESSAGE -->
        <?php if ($success != ""): ?>
            <div class="success-box"><?= $success ?></div>
        <?php endif; ?>

        <div class="doctor-box">

            <form action="" method="POST">

                <div class="form-row">

                    <div class="input-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name">
                    </div>
                    
                    <div class="input-group">
                        <label>Username</label>
                        <input type="text" name="username">
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email">
                    </div>
                    

                </div>


                <div class="form-row">

                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password">
                    </div>

                    <div class="input-group">
                        <label>Specialization</label>
                        <input type="text" name="specialization">
                    </div>

                </div>

                <div class="form-row">

                    <div class="input-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password">
                    </div>

                    <div class="input-group invisible"></div>

                </div>

                <button type="submit">Create Doctor</button>

            </form>

        </div>

    </div>

</div>

</body>
</html>