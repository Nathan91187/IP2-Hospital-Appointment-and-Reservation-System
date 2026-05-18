<?php
include("../../../Database/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST['user_id'];

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    $full_name = $first_name . " " . $last_name;

    // Escape inputs (basic safety)
    $full_name = mysqli_real_escape_string($conn, $full_name);
    $email = mysqli_real_escape_string($conn, $email);
    $username = mysqli_real_escape_string($conn, $username);
    $phone = mysqli_real_escape_string($conn, $phone);
    $gender = mysqli_real_escape_string($conn, $gender);

    $sql = "UPDATE users 
            SET full_name='$full_name',
                email='$email',
                username='$username',
                phone='$phone',
                gender='$gender'
            WHERE user_id='$user_id'";

    if (!mysqli_query($conn, $sql)) {
        die("Update failed: " . mysqli_error($conn));
    }

    // PASSWORD UPDATE (only if provided)
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($new_password) && $new_password === $confirm_password) {

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $pass_sql = "UPDATE users 
                     SET password='$hashed_password'
                     WHERE user_id='$user_id'";

        mysqli_query($conn, $pass_sql);
    }

    echo "Profile updated successfully";
}
?>