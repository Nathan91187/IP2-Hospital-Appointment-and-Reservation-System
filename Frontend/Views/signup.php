<?php
include "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first = trim($_POST["first_name"] ?? '');
    $father = trim($_POST["father_name"] ?? '');
    $grand = trim($_POST["grand_father_name"] ?? '');
    $dob = trim($_POST["dob"] ?? '');
    $address = trim($_POST["address"] ?? '');
    $phone = trim($_POST["phone"] ?? '');
    $gender = trim($_POST["gender"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirm = $_POST["confirm_password"] ?? '';

    if (
        empty($first) || empty($father) || empty($grand) ||
        empty($dob) || empty($address) || empty($phone) ||
        empty($gender) || empty($email) || empty($password)
    ) {
        $error = "⚠️ All fields are required!";
    }

    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "⚠️ Invalid email format!";
    }

    else if ($password !== $confirm) {
        $error = "⚠️ Passwords do not match!";
    }

    else if (strlen($password) < 6) {
        $error = "⚠️ Password must be at least 6 characters!";
    }

    else {

    // 🔍 CHECK IF EMAIL EXISTS FIRST
    $check = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($check);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "❌ Email already exists! Try another one.";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users 
        (first_name, father_name, grand_father_name, dob, address, phone, gender, email, password)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssssss",
            $first, $father, $grand,
            $dob, $address, $phone,
            $gender, $email, $hashedPassword
        );

        if ($stmt->execute()) {
            $success = "✅ Account created successfully!";
        } else {
            $error = "❌ Something went wrong!";
        
    }
}
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>

<div class="navbar">
    <h2>XYZ</h2>
    <div>
        <a href="#">Home</a>
        <a href="#">Contact Us</a>
    </div>
</div>

<div class="container">
    <div class="signup-box">

        <h2>XYZ Hospital</h2>

        <!--  SUCCESS / ERROR UI -->
        <?php if ($error != ""): ?>
            <div class="error-box"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success != ""): ?>
            <div class="success-box"><?= $success ?></div>
        <?php endif; ?>

        <form action="signup.php" method="POST">

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
                    <label>GrandFather Name</label>
                    <input type="text" name="grand_father_name">
                </div>

                <div class="input-group">
                    <label>Date of Birth</label>
                    <input type="text" name="dob">
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label>Address</label>
                    <input type="text" name="address">
                </div>

                <div class="input-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone">
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label>Gender</label>
                    <input type="text" name="gender">
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
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password">
                </div>
            </div>

            <button type="submit">Signup</button>

        </form>

    </div>
</div>

</body>
</html>