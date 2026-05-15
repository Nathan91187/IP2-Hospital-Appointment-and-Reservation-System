<?php
include 'db.php';


$doctor_id = $_GET['id'];

$query = "SELECT * FROM doctors WHERE id='$doctor_id'";
$result = mysqli_query($conn, $query);

$doctor = mysqli_fetch_assoc($result);


if(isset($_POST['book'])) {

    $patient_name = $_POST['patient_name'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    $insert_patient = "INSERT INTO patients(
        full_name,
        email,
        password,
        phone
    )
    VALUES(
        '$patient_name',
        'demo@gmail.com',
        '123456',
        '0911111111'
    )";

    mysqli_query($conn, $insert_patient);

    $patient_id = mysqli_insert_id($conn);

    $insert_appointment = "INSERT INTO appointments(
        doctor_id,
        patient_id,
        appointment_date,
        appointment_time
    )
    VALUES(
        '$doctor_id',
        '$patient_id',
        '$appointment_date',
        '$appointment_time'
    )";

    mysqli_query($conn, $insert_appointment);

    echo "<script>alert('Appointment Booked Successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Appointment</title>

    <link rel="stylesheet" href="appointment.css">

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
                <?php echo $doctor['description']; ?>
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



        <div class="time-box">

    <h3>Available Time</h3>

    <div class="time-grid">

        <button>1.00 am</button>
        <button>1.30 am</button>
        <button>2.00 am</button>

        <button>1.00 am</button>
        <button class="selected">1.30 am</button>
        <button>2.00 am</button>

        <button>1.00 am</button>
        <button>1.30 am</button>
        <button>2.00 am</button>

        <button>1.00 am</button>
        <button>1.30 am</button>
        <button>2.00 am</button>

    </div>

    <button class="book-btn">
        Book Now
    </button>

</div>

    </div>

</div>

</body>
</html>