<?php
include "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';

    // 1. EMPTY CHECK
    if (empty($email) || empty($password)) {
        $error = "⚠️ Please fill in both Email and Password!";
    }

    // 2. EMAIL FORMAT CHECK
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "⚠️ Please enter a valid email address!";
    }

    else {

        // 3. CHECK USER
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            $error = "❌ No account found with this email!";
        } 
        else if (!password_verify($password, $user["password"])) {
            $error = "❌ Incorrect password!";
        } 
        else {
            header("Location: admin_dashboard.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
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
    <div class="login-box">

        <h2>XYZ Hospital</h2>

        <!-- ERROR / SUCCESS UI -->
        <?php if ($error != ""): ?>
            <div class="error-box"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success != ""): ?>
            <div class="success-box"><?= $success ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">

            <label>Email</label>
            <input type="email" name="email" placeholder="example@gmail.com">

            <label>Password</label>
            <input type="password" name="password" placeholder="********">

            <button type="submit">Login</button>

            <p>Don't have an account? <a href="signup.php">SignUp</a></p>

        </form>

    </div>
</div>

</body>
</html>