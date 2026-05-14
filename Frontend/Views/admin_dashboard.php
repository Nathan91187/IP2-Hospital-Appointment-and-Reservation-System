<?php
include "db.php";

$error = "";
$success = "";

// TOTAL PATIENTS
$patients = 0;
$patientQuery = "SELECT COUNT(*) AS total FROM users";
$result1 = $conn->query($patientQuery);

if ($result1 && $row = $result1->fetch_assoc()) {
    $patients = $row["total"];
}

// TOTAL DOCTORS
$doctors = 4;

// TOTAL APPOINTMENTS
$appointments = 4;


// CREATE DOCTOR
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first = trim($_POST["first_name"] ?? '');
    $father = trim($_POST["father_name"] ?? '');
    $grand = trim($_POST["grand_father_name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirm = $_POST["confirm_password"] ?? '';
    $specialization = trim($_POST["specialization"] ?? '');

    // EMPTY CHECK
    if (
        empty($first) ||
        empty($father) ||
        empty($grand) ||
        empty($email) ||
        empty($password) ||
        empty($confirm) ||
        empty($specialization)
    ) {
        $error = "⚠️ All fields are required!";
    }

    // NAME VALIDATION
    else if (
        !preg_match("/^[a-zA-Z ]+$/", $first) ||
        !preg_match("/^[a-zA-Z ]+$/", $father) ||
        !preg_match("/^[a-zA-Z ]+$/", $grand)
    ) {
        $error = "⚠️ Names must contain letters only!";
    }

    // EMAIL VALIDATION
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "⚠️ Invalid email format!";
    }

    // PASSWORD LENGTH
    else if (strlen($password) < 6) {
        $error = "⚠️ Password must be at least 6 characters!";
    }

    // PASSWORD CONFIRMATION
    else if ($password !== $confirm) {
        $error = "⚠️ Passwords do not match!";
    }

    else {

        // CHECK IF EMAIL EXISTS
        $check = "SELECT id FROM doctors WHERE email = ?";
        $stmt = $conn->prepare($check);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "❌ Doctor email already exists!";
        }

        else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO doctors
            (first_name, father_name, grand_father_name, email, password, specialization)
            VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "ssssss",
                $first,
                $father,
                $grand,
                $email,
                $hashedPassword,
                $specialization
            );

            if ($stmt->execute()) {
                $success = "✅ Doctor created successfully!";
                $doctors++;
            } else {
                $error = "❌ Failed to create doctor!";
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
    <link rel="stylesheet" href="admin_dashboard.css">
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
                        <label>First Name</label>
                        <input type="text" name="first_name">
                    </div>

                    <div class="input-group">
                        <label>Father Name</label>
                        <input type="text" name="father_name">
                    </div>

                </div>

                <div class="form-row">

                    <div class="input-group">
                        <label>Grand Father Name</label>
                        <input type="text" name="grand_father_name">
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