<?php

include '../../Database/connect.php';

$query = "
SELECT
    doctors.doctor_id,
    users.full_name,
    doctors.specialization,
    doctors.bio
FROM doctors
JOIN users
ON doctors.doctor_id = users.user_id
WHERE users.role = 'doctor'
";

$stmt = $db->prepare($query);

$stmt->execute();

$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Portal</title>

    <link rel="stylesheet" href="../CSS/index.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">



    <section class="hero">

        <div class="hero-text">

            <h2>Find The Right Doctor</h2>

            <p>
                Search and connect with trusted healthcare
                professional near you
            </p>

            <div class="search-box">

                <input type="text" placeholder="Search Doctors ....">

                <select>
                    <option>Category</option>
                    <option>Heart Specialist</option>
                    <option>Dentist</option>
                    <option>Neurologist</option>
                </select>

            </div>

        </div>

        <div class="hero-icon">

            <div class="circle">
                🩺
            </div>

        </div>

    </section>



    <section class="doctor-list">

        <?php foreach ($doctors as $doctor) { ?>

        <div class="doctor-card">

            <div class="doctor-left">

                <div class="doctor-icon">
                    🩺
                </div>

                <div>

                    <h3>
                        <?php echo $doctor['full_name']; ?>
                    </h3>

                    <span>
                        <?php echo $doctor['specialization']; ?>
                    </span>

                </div>

            </div>

            <a href="appointment.php?id=<?php echo $doctor['doctor_id']; ?>">

                <button>
                    View Profile >
                </button>

            </a>

        </div>

        <?php } ?>


        <div class="pagination">

            <a href="#">< prev</a>
            <a href="#">next ></a>

        </div>

    </section>



    <section class="welcome-box">

        <div class="welcome-icon">
            ❤
        </div>

        <div>

            <p>
                Welcome to our patient portal, where finding the right healthcare
                professional is simple and convenient. You can easily search for
                specialized doctors based on your needs,
                Our platform is designed to help you connect with trusted medical
                experts quickly and efficiently.
            </p>

        </div>

    </section>

</div>

</body>
</html>