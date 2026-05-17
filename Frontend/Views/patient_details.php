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

    <div class="content">

        <!-- LEFT -->
        <div class="card">
            <h2>PATIENT-ENTERED PROFILE</h2>

            <label>Full Name:</label>
            <input type="text" value="Sarah Jones">

            <label>Age:</label>
            <input type="text" value="34">

            <label>Gender:</label>
            <input type="text" value="Female">

            <label>Reason for Visit:</label>
            <input type="text" value="Chronic fatigue and persistent headaches">

            <label>Preferred Contact:</label>
            <input type="text" value="(123) 456-7890 | sarah.j@email.com">
        </div>

        <!-- RIGHT -->
        <div class="card">
            <h2>CLINICAL ASSESSMENT</h2>

            <label>Blood Type</label>
            <input type="text">

            <label>Diagnosis / Clinical Impressions:</label>
            <textarea placeholder="Enter notes..."></textarea>

            <label>Prescriptions</label>
            <textarea placeholder="Add details..."></textarea>

            <label>Referrals</label>
            <textarea placeholder="Specify referral..."></textarea>

            <button>SAVE MEDICAL RECORD</button>
        </div>

    </div>

</div>

</body>
</html>