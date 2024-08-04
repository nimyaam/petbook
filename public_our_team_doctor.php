<?php
session_start();
require 'conn.inc.php';
date_default_timezone_set('Asia/Calcutta');

// Check if the doctor's ID is provided in the URL
if(isset($_GET['id'])) {
    $doctor_id = $_GET['id'];

    // Fetch the details of the selected doctor from the database
    $doctor_query = "SELECT * FROM `doctor_register` WHERE `Doctor_ID` = '$doctor_id'";
    $doctor_result = mysqli_query($success_connect, $doctor_query);

    // Check if the doctor is found in the database
    if(mysqli_num_rows($doctor_result) > 0) {
        $doctor = mysqli_fetch_assoc($doctor_result);
        // Display the doctor's details
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK</title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/public_our_team_doctor.css">
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
            <li class="dropdown">
                <a href="#" class="dropbtn">Pet Registration <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="public_account">Pet Account</a>
                    <a href="pet_register">Pet Registration</a>
                </div>
            </li>  
            <li><a href="public_service">Services</a></li>
            <li><a href="public_medicalrecord">Medical Records</a></li>
            <li><a href="public_feedback">Feedback</a></li>
            <li><a href="logout" id="login-link">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
    <div class="doctor-details">
        <img class="doctor-image" src="<?php echo $doctor['Photo']; ?>" alt="<?php echo $doctor['Doctor_Name']; ?>">
        <div class="doctor-info">
            <h2 class="doctor-name"><?php echo $doctor['Doctor_Name']; ?></h2>
            <ul class="details-list">
                <li><span>Doctor ID:</span> <?php echo $doctor['Doctor_ID']; ?></li>
                <li><span>Address:</span> <?php echo $doctor['Address']; ?></li>
                <li><span>Qualification:</span> <?php echo $doctor['Qualification']; ?></li>
                <li><span>Experience:</span> <?php echo $doctor['Experience']; ?></li>
                <li><span>Specialization:</span> <?php echo $doctor['Specialization']; ?></li>
                <li><span>Hospital Name:</span> <?php echo $doctor['Hospital_Name']; ?></li>
                <li><span>Email:</span> <?php echo $doctor['Email']; ?></li>
                <li><span>Phone Number:</span> <?php echo $doctor['Phone_number']; ?></li>
            </ul>
        </div>
    </div>
    <div class="appointment" onclick="goToAppointment()">
        <img src="Assets/images/drapp.jpg" alt="Make an Appointment">
        <span>Make an Appointment</span>
    </div>
    <div class="chatroom" onclick="goToChatroom()">
        <img src="Assets/images/chat.jpg" alt="Join the Chatroom">
        <span>Join the Chatroom</span>
    </div>
</div>

        
    <script>
        function goToAppointment() {
            window.location.href = "public_appointment_consultation";
        }

        function goToChatroom() {
            window.location.href = "public_chatting_page";
        }
    </script>
</body>
</html>
<?php
    } else {
        // Redirect if the doctor is not found
        header("Location: error_page.php");
    }
} else {
    // Redirect if the doctor's ID is not provided in the URL
    header("Location: error_page.php");
}
?>
