<?php

include '../../Database/connect.php';

if (!isset($_GET['id'])) {
    die("Doctor ID missing");
}

$doctor_id = $_GET['id'];

$query = "
SELECT
    doctors.doctor_id,
    doctors.specialization,
    doctors.bio,
    doctors.consultation_fee,
    users.full_name
FROM doctors
JOIN users
ON doctors.doctor_id = users.user_id
WHERE doctors.doctor_id = ?
";

$stmt = $db->prepare($query);

$stmt->execute([$doctor_id]);

$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$doctor) {
    die("Doctor not found");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Appointment</title>

    <link rel="stylesheet" href="../CSS/appointment.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>

<div class="container appointment-container">

    <a class="back-link" href="index.php">
        < Back to doctors
    </a>

    <div class="profile-card">

        <div class="profile-icon">
            🩺
        </div>

        <div>

            <h2>
                <?php echo $doctor['full_name']; ?>
            </h2>

            <span>
                <?php echo $doctor['specialization']; ?>
            </span>

            <p>
                <?php echo $doctor['bio']; ?>
            </p>

        </div>

    </div>

    <div class="appointment-section">

        <div class="calendar-box">

            <h3>Available Appointments</h3>

            <p>
                Select a date and time that works for you.
            </p>

            <div class="calendar">

                <div class="month">
                    May 2025
                </div>

                <div class="days">

                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>

                    <div>27</div>
                    <div>28</div>
                    <div>29</div>
                    <div>30</div>
                    <div>1</div>
                    <div>2</div>
                    <div>3</div>

                    <div>4</div>
                    <div>5</div>
                    <div>6</div>
                    <div>7</div>
                    <div>8</div>
                    <div>9</div>
                    <div>10</div>

                    <div>11</div>
                    <div>12</div>
                    <div class="active-day">13</div>
                    <div>14</div>
                    <div>15</div>
                    <div>16</div>
                    <div>17</div>

                    <div>18</div>
                    <div>19</div>
                    <div>20</div>
                    <div>21</div>
                    <div>22</div>
                    <div>23</div>
                    <div>24</div>

                    <div>25</div>
                    <div>26</div>
                    <div>27</div>
                    <div>28</div>
                    <div>29</div>
                    <div>30</div>
                    <div>31</div>

                </div>

            </div>

        </div>

        <form action="../../Backend/api/appointment/book.php" method="POST">

            <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">

            <input type="number" name="patient_id" placeholder="Enter Patient ID" required>

            <input type="date" name="appointment_date" required>

            <input type="time" name="appointment_time" required>

            <div class="time-box">

                <h3>Available Time</h3>

                <div class="time-grid">

                    <button type="button">1.00 am</button>
                    <button type="button">1.30 am</button>
                    <button type="button">2.00 am</button>

                    <button type="button">1.00 am</button>
                    <button type="button" class="selected">1.30 am</button>
                    <button type="button">2.00 am</button>

                    <button type="button">1.00 am</button>
                    <button type="button">1.30 am</button>
                    <button type="button">2.00 am</button>

                    <button type="button">1.00 am</button>
                    <button type="button">1.30 am</button>
                    <button type="button">2.00 am</button>

                </div>

                <button type="submit" class="book-btn">
                    Book Now
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>