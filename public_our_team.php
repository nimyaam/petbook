<?php
session_start();
require 'conn.inc.php';
date_default_timezone_set('Asia/Calcutta'); 
$date = date('Y-m-d')."T".date("H:i:s");

if(isset($_SESSION['User_Id']) && isset($_SESSION['name']) && isset($_SESSION['Email'])&& isset($_SESSION['Phone_number'])&& isset($_SESSION['type'])&& isset($_SESSION['Approved'])) {
    $User_Id        = $_SESSION['User_Id'];
    $name           = $_SESSION['name'];
    $Email          = $_SESSION['Email'];
    $Phone_number   = $_SESSION['Phone_number'];
    $acc_type       = $_SESSION['type'];
    $Approved       = $_SESSION['Approved'];
    
    if($acc_type=='public') { 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK</title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/public_our_team.css">
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 140px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropbtn {
            color: white;
            padding: 16px;
            font-size: 18px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover, .dropbtn:focus {
            background-color: #3e8e41;
        }
        </style>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
            <span class="logo-text">PETBOOK</span>
        </div>
        <ul>
            <li><a href="public_home">Home</a></li>
            <li><a href="public_service">Services</a></li>
            <li><a href="public_medicalrecord">Medical Records</a></li>
            <li><a href="public_feedback">Feedback</a></li>
            <li><a href="logout" id="login-link">Logout</a></li>
        </ul>
    </nav>

    <div class="header">
        <h1>Our Team - Veterinary Doctors</h1>
    </div>
    <div class="team-section">
        <div class="team-image">
            <img src="Assets/images/frontpage.jpg" alt="Our Team">
        </div>
        <div class="team-content">
            <p>Transforming pet care into a seamless experience, we offer convenient appointment scheduling, gentle vaccination reminders, and online consultations at your fingertips. Plus, our mobile veterinary services bring compassionate care right to your doorstep, ensuring your pet's well-being is never out of reach.</p>
            <button class="view-button" onclick="showDoctors()">Find Your Specialist click here...</button>
        </div>
    </div>

    <div class="doctor-box-container" id="doctors-section" style="display: none;">
        <?php
        // Query to fetch doctor details from database
        $doctor_query = "SELECT * FROM `doctor_register`";
        $doctor_result = mysqli_query($success_connect, $doctor_query);

        // Check if there are doctors in the database
        if(mysqli_num_rows($doctor_result) > 0) {
            // Loop through each doctor and display their details
            while($doctor = mysqli_fetch_assoc($doctor_result)) {
        ?>
<a href="public_our_team_doctor.php?id=<?php echo $doctor['Doctor_ID']; ?>" class="doctor-box">
            <img class="doctor-image" src="<?php echo $doctor['Photo']; ?>" alt="<?php echo $doctor['Doctor_Name']; ?>">
            <h3><?php echo $doctor['Doctor_Name']; ?></h3>
            <p>Specialization: <?php echo $doctor['Specialization']; ?></p>
            <p>Hospital Name: <?php echo $doctor['Hospital_Name']; ?></p>
            <p>Experience: <?php echo $doctor['Experience']; ?> years</p>
        </a>
        <?php
            }
        } else {
            // No doctors found in database
            echo "<p>No doctors found.</p>";
        }
        ?>
    </div>

    <script>
        function showDoctors() {
            var doctorsSection = document.getElementById('doctors-section');
            doctorsSection.style.display = 'flex';
            doctorsSection.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
<?php
    } else {
        // Redirect to logout if user is not public
        header("Location: logout"); 
    }
} else {
    // Redirect to logout if session data is not set
    header("Location: logout"); 
}
?>