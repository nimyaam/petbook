<?php
session_start();
require 'conn.inc.php'; // Include database connection file
date_default_timezone_set('Asia/Calcutta');

if (isset($_SESSION['User_Id'], $_SESSION['type'], $_SESSION['Approved']) && $_SESSION['type'] === 'doctor') {
    $User_Id = $_SESSION['User_Id'];
    $acc_type = $_SESSION['type'];
    $Approved = $_SESSION['Approved'];

    if ($Approved == 1) {
        $doctor_query = "SELECT * FROM `doctor_register` WHERE `Doctor_ID` = '$User_Id'";
        $doctor_result = mysqli_query($success_connect, $doctor_query);

        if ($doctor_result && mysqli_num_rows($doctor_result) > 0) {
            $doctor_details = mysqli_fetch_assoc($doctor_result);
            $Doctor_id = $doctor_details['Doctor_ID'];
            $Doctor_name = $doctor_details['Doctor_Name'];
            $Address = $doctor_details['Address'];
            $Qualification = $doctor_details['Qualification'];
            $License_number = $doctor_details['Licence_Number'];
            $Experience = $doctor_details['Experience'];
            $Specialization = $doctor_details['Specialization'];
            $Hospital_name = $doctor_details['Hospital_Name'];
            $Email = $doctor_details['Email'];
            $dob = $doctor_details['DOB'];
            $phone_number = $doctor_details['Phone_number'];
            $password = $doctor_details['Password'];
            $photo = $doctor_details['Photo'];
            $time = $doctor_details['time'];
        }
    } else {
        echo "<h2 style='color: red;'>Your account is not yet approved by admin!</h2>";
        echo "<div class='container section'></div>";
    }
} else {
    header("Location: logout"); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK - Doctor Details</title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/doctor_home.css">
    <style>
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        form input[type=text],
        form input[type=email],
        form input[type=file] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        form input[type=submit],
        form button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form input[type=submit]:hover,
        form button:hover {
            background-color: #45a049;
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
            <li><a href="doctor_home">Home</a></li>
            <li><a href="doctor_services">Services</a></li>
            <li><a href="doctor_medical_record">Medical Records</a></li>
            <li><a href="doctor_feedback">Feedback</a></li>
            <li><a href="logout" id="login-link">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <form method="POST" action="#" enctype="multipart/form-data">
            <img src="<?php echo $photo; ?>" alt="Doctor Photo" style="width: 150px; height: 150px; border-radius: 50%; margin-bottom: 10px;">
            <input type="file" name="photo" accept="image/*" style="margin-bottom: 10px;"><br>
            <input type="text" name="Doctor_id" value="<?php echo $Doctor_id; ?>" placeholder="Doctor ID" required readonly><br>
            <input type="text" name="Doctor_name" value="<?php echo $Doctor_name; ?>" placeholder="Doctor Name" required><br>
            <input type="text" name="Address" value="<?php echo $Address; ?>" placeholder="Address" required><br>
            <input type="text" name="Qualification" value="<?php echo $Qualification; ?>" placeholder="Qualification" required><br>
            <input type="text" name="License_number" value="<?php echo $License_number; ?>" placeholder="License Number" required><br>
            <input type="text" name="Experience" value="<?php echo $Experience; ?>" placeholder="Experience" required><br>
            <input type="text" name="Specialization" value="<?php echo $Specialization; ?>" placeholder="Specialization" required><br>
            <input type="text" name="Hospital_name" value="<?php echo $Hospital_name; ?>" placeholder="Hospital Name" required><br>
            <input type="email" name="Email" value="<?php echo $Email; ?>" placeholder="Email" required><br>
            <input type="text" name="dob" value="<?php echo $dob; ?>" placeholder="Date of Birth" required><br>
            <input type="text" name="phone_number" value="<?php echo $phone_number; ?>" placeholder="Phone Number" required><br>
            <input type="text" name="password" value="<?php echo $password; ?>" placeholder="Password" required readonly><br>
            <input type="text" name="time" value="<?php echo $time; ?>" placeholder="Registration Time" required readonly><br>
            <input type="submit" name="edit" value="Edit">
            <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>
</html>
