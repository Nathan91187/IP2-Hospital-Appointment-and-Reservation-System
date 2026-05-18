<?php
include("../../Database/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Schedule</title>
    <link rel="stylesheet" href="../CSS/doctor_appointments.css">
</head>
<body>

<nav>
    <div class="logo">XYZ</div>

    <div class="links">
        <a href="#">Schedule</a>
        <a href="#">Logout</a>
    </div>
</nav>

<div class="container">

    <div class="overview">
        <h1>Schedule Overview</h1>

        <div class="appointments">
            <h2>Upcoming Appointments Today</h2>

            <?php
            $date = date("Y-m-d");

            $sql = "SELECT a.appointment_time, u.full_name, d.specialization
                    FROM appointments a
                    JOIN patients p ON a.patient_id = p.patient_id
                    JOIN users u ON p.user_id = u.user_id
                    JOIN doctors d ON a.doctor_id = d.doctor_id
                    WHERE a.appointment_date = '$date'
                    ORDER BY a.appointment_time";

            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<p>" . $row['appointment_time'] . ": " . $row['full_name'] . " (" . $row['specialization'] . ")</p>";
                }
            } else {
                echo "<p>No appointments today</p>";
            }
            ?>
        </div>
    </div>

    <div class="bottom">

        <div class="calendar">
            <h2>Select Date to View Appointments</h2>

            <div class="calendar-box">
                <h3>May 2025</h3>
            </div>
        </div>

        <div class="times">
            <h2>Select Time</h2>

            <div class="time-grid">
                <button>9:00 am</button>
                <button>1:30 am</button>
                <button>2:00 am</button>

                <button>9:30 am</button>
                <button>1:30 am</button>
                <button>2:30 am</button>

                <button>1:00 am</button>
                <button>1:30 am</button>
                <button>2:00 am</button>
            </div>
        </div>

    </div>

</div>

</body>
</html>
