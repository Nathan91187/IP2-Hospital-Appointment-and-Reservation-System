<?php
include "../../Database/connect.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST["full_name"] ?? '');
    $username = trim($_POST["username"] ?? '');
  
    $dob = trim($_POST["dob"] ?? '');
    $birth_date = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($birth_date)->y;

    $phone = trim($_POST["phone"] ?? '');
    $gender = trim($_POST["gender"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirm = $_POST["confirm_password"] ?? '';

    if (
        empty($full_name) || empty($username)  ||
        empty($dob) ||  empty($phone) ||
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
    }else if($age < 18){
     $error = "⚠️  You must be at least 18 years old";
    }   

    else {
    $check = "SELECT user_id FROM users WHERE email = ?";
    $stmt = $db->prepare($check);
    $stmt->execute([$email]);
    $username_check = "SELECT username from users where username = ?";
    $username_stmt = $db->prepare($username_check);
    $username_stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        $error = "❌ Email already exists! Try another one.";
    }else if($username_stmt->rowCount() > 0){
              $error = "❌ Username already exists! Try another one.";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users 
        (username, full_name, phone, email, password_hash,role)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $db->prepare($sql);
$stmt->execute([
            $username,
            $full_name,
            $phone,
            $email,
            $hashedPassword,
            "patient"
        ]);
        $user_id = $db->lastInsertId();
        $stmt = $db->prepare("INSERT INTO patients (patient_id, date_of_birth, gender) VALUES (?,?,?)");
        $stmt->execute([$user_id,$dob,$gender]);
        $success = "✅ Account created successfully!";
        echo"
            <script>
                localStorage.setItem('user_id','$user_id');
                localStorage.setItem('role','patient');
                localStorage.setItem('full_name','$full_name');
                setTimeout(()=>{
                    window.location.href = 'index.php';
                },1000
                );
            </script>
        ";
    }
}
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../CSS/signup.css">
</head>
<body>

<!-- <div class="navbar">
    <h2>XYZ</h2>
    <div>
        <a href="#">Home</a>
        <a href="#">Contact Us</a>
    </div>
</div> -->

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
                    <label>Full Name</label>
                    <input type="text" name="full_name">
                </div>

                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username">
                </div>
            </div>

            <div class="form-row">
     

                <div class="input-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob">
                </div>
                                <div class="input-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone">
                </div>
            </div>



            <div class="form-row">
                <div class="input-group">
                    <label>Gender</label>
                    <select name="gender" id="">
                        <option value="" default disabled>Gender</option>
                        <option value="male">Male</option>
                        <option value="female">female</option>
                    </select>
                
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