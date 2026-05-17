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

        <div class="profile-card">
            <div class="avatar">📷</div>

            <button>Change Photo</button>

            <h2>John Doe</h2>
            <p>USER</p>
        </div>

        <div class="form-card">

            <h2>ACCOUNT DETAILS</h2>

            <div class="row">
                <input type="text" placeholder="Disabled">
                <input type="email" value="jane.doe@example.com">
            </div>

            <h2>PERSONAL INFORMATION</h2>

            <div class="row">
                <input type="text" value="John">
                <input type="text" value="Doe">
            </div>

            <div class="row">
                <input type="text" value="+1 555-010-9988">
                <input type="text" value="Male/Female/Other">
            </div>

            <h2>SECURITY</h2>

            <input type="password" placeholder="Old Password">

            <div class="row">
                <input type="password" placeholder="New Password">
                <input type="password" placeholder="Confirm Password">
            </div>

            <div class="buttons">
                <button class="cancel">Cancel</button>
                <button class="save">Save Changes</button>
            </div>

        </div>

    </div>

</div>

</body>
</html>