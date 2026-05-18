<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="../CSS/patient_details.css">
</head>
<body>

<div class="container">

    <h1>PATIENT DETAILS</h1>

    <form class="content"
          action="../../Backend/api/patient/create.php"
          method="POST">

        <input type="number"
               name="user_id"
               placeholder="Enter User ID"
               required>

        <!-- LEFT -->
        <div class="card">

            <h2>PATIENT-ENTERED PROFILE</h2>

            <label>Full Name:</label>
            <input type="text"
                   name="full_name"
                   value="Sarah Jones">

            <label>Age:</label>
            <input type="text"
                   name="age"
                   value="34">

            <label>Gender:</label>
            <input type="text"
                   name="gender"
                   value="Female">

            <label>Reason for Visit:</label>
            <input type="text"
                   name="reason_for_visit"
                   value="Chronic fatigue and persistent headaches">

            <label>Preferred Contact:</label>
            <input type="text"
                   name="preferred_contact"
                   value="(123) 456-7890 | sarah.j@email.com">

        </div>

        <!-- RIGHT -->
        <div class="card">

            <h2>CLINICAL ASSESSMENT</h2>

            <label>Blood Type</label>
            <input type="text" name="blood_type">

            <label>Diagnosis / Clinical Impressions:</label>
            <textarea name="diagnosis"
                      placeholder="Enter notes..."></textarea>

            <label>Prescriptions</label>
            <textarea name="prescriptions"
                      placeholder="Add details..."></textarea>

            <label>Referrals</label>
            <textarea name="referrals"
                      placeholder="Specify referral..."></textarea>

            <button type="submit">
                SAVE MEDICAL RECORD
            </button>

        </div>

    </form>

</div>

</body>
</html>