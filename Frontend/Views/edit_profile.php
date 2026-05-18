<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../CSS/edit_profile.css">
</head>
<body>

<nav>
    <div class="logo">XYZ</div>

    <div class="links">
        <a href="#">Home</a>
        <a href="#">Logout</a>
    </div>
</nav>

<div class="container">

    <h1>EDIT PROFILE</h1>

    <div class="main">

        <!-- SINGLE WORKING FORM -->
        <form class="form-card"
              action="../../Backend/api/profile/update.php"
              method="POST">

            <!-- REQUIRED USER ID (temporary static) -->
            <input type="hidden" name="user_id" value="1">

            <div class="avatar">📷</div>
            <button type="button">Change Photo</button>

            <h2>John Doe</h2>
            <p>USER</p>

            <h2>ACCOUNT DETAILS</h2>

            <div class="row">
                <input type="text" name="username" value="jane.doe">
                <input type="email" name="email" value="jane.doe@example.com">
            </div>

            <h2>PERSONAL INFORMATION</h2>

            <div class="row">
                <input type="text" name="first_name" value="John">
                <input type="text" name="last_name" value="Doe">
            </div>

            <div class="row">
                <input type="text" name="phone" value="+1 555-010-9988">
                <input type="text" name="gender" value="Male">
            </div>

            <h2>SECURITY</h2>

            <input type="password" name="old_password" placeholder="Old Password">

            <div class="row">
                <input type="password" name="new_password" placeholder="New Password">
                <input type="password" name="confirm_password" placeholder="Confirm Password">
            </div>

            <div class="buttons">
            <button type="button" class="cancel" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="save">Save Changes</button>
            </div>

        </form>

    </div>

</div>

</body>
</html>