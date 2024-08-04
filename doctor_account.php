<?php
session_start();
require 'conn.inc.php'; // Assuming this file contains your database connection
date_default_timezone_set('Asia/Calcutta');
$date = date('Y-m-d H:i:s'); // Use Y-m-d H:i:s format for datetime

// Check if doctor is logged in
if(isset($_SESSION['User_Id']) && isset($_SESSION['name']) && isset($_SESSION['Email']) && isset($_SESSION['Phone_number']) && isset($_SESSION['type'])) {
        
    $User_Id        = $_SESSION['User_Id'];
    $name           = $_SESSION['name'];
    $Email          = $_SESSION['Email'];
    $Phone_number   = $_SESSION['Phone_number'];
    $acc_type       = $_SESSION['type'];

    if($acc_type == 'doctor') {
        // Fetch doctor's details from database
        $fetch_doctor_query = "SELECT * FROM `doctor_register` WHERE `Doctor_ID` = '$User_Id'";
        $fetch_doctor_run   = mysqli_query($conn, $fetch_doctor_query);
        
        if(mysqli_num_rows($fetch_doctor_run) > 0) {
            $doctor_details = mysqli_fetch_assoc($fetch_doctor_run);

            // Handle form submission to update doctor's details
            if(isset($_POST['update_doctor'])) {
                $Doctor_id      = $_POST['Doctor_id'];
                $Doctor_name    = $_POST['Doctor_name'];
                $Address        = $_POST['Address'];
                $Qualification  = $_POST['Qualification'];
                $License_number = $_POST['License_number'];
                $Experience     = $_POST['Experience'];
                $Specialization = $_POST['Specialization'];
                $Hospital_name  = $_POST['Hospital_name'];
                $Email          = $_POST['Email'];
                $dob            = $_POST['dob'];
                $phone_number   = $_POST['phone_number'];
                $password       = $_POST['password'];
                $password_hash  = md5($password); // Note: md5 is not recommended for password hashing in production

                // Handle photo upload
                $photo = $_FILES['photo'];
                $photo_name = $photo['name'];
                $photo_tmp_name = $photo['tmp_name'];
                $photo_error = $photo['error'];

                if($photo_error === 0) {
                    $photo_destination = 'Assets/images/' . $photo_name;
                    move_uploaded_file($photo_tmp_name, $photo_destination);
                } else {
                    $error_msg = "Error uploading photo: " . $photo_error;
                }

                // Update doctor's details in database
                $update_doctor_query = "UPDATE `doctor_register` SET `Doctor_ID`='$Doctor_id', `Doctor_Name`='$Doctor_name', `DOB`='$dob', `Address`='$Address', `Qualification`='$Qualification', `Licence_Number`='$License_number', `Experience`='$Experience', `Specialization`='$Specialization', `Hospital_Name`='$Hospital_name', `Email`='$Email', `Phone_number`='$phone_number', `Password`='$password_hash', `Photo`='$photo_destination', `time`='$date' WHERE `Doctor_ID`='$User_Id'";
                $update_doctor_run   = mysqli_query($conn, $update_doctor_query);

                if($update_doctor_run) {
                    $_SESSION['success_msg'] = "Doctor details updated successfully!";
                    // Redirect to prevent resubmission on page refresh
                    header("Location: doctor_account.php");
                    exit;
                } else {
                    $error_msg = "Error updating doctor details: " . mysqli_error($conn);
                }
            }
        } else {
            $error_msg = "Doctor details not found!";
        }
    } else {
        header("Location: logout.php");
        exit;
    }
} else {
    header("Location: logout.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PETBOOK</title>
<link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
  }

  .container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .container h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 28px;
  }

  .profile-picture {
    text-align: center;
    margin-bottom: 20px;
  }

  .profile-picture img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ccc;
  }

  .form-group {
    margin-bottom: 15px;
  }

  .form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }

  .form-group input[type="text"],
  .form-group input[type="email"],
  .form-group input[type="password"],
  .form-group input[type="date"] {
    width: calc(100% - 12px);
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
  }

  .form-group input[type="file"] {
    width: auto;
    padding: 8px;
    font-size: 14px;
  }

  .btn-container {
    text-align: center;
    margin-top: 20px;
  }

  .btn-container button {
    padding: 10px 20px;
    margin: 0 10px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    background-color: #4CAF50;
    color: white;
    transition: background-color 0.3s;
  }

  .btn-container button:hover {
    background-color: blue;
  }

  .error-message {
    color: red;
    margin-top: 10px;
    text-align: center;
  }

  .success-message {
    color: green;
    margin-top: 10px;
    text-align: center;
    animation: blinker 1s linear infinite;
  }

  @keyframes blinker {
    50% {
      opacity: 0;
    }
  }
</style>
</head>
<body>
<div class="container">
  <h1>My Account</h1>
  <?php if(isset($_SESSION['success_msg'])): ?>
    <div class="success-message"><?php echo $_SESSION['success_msg']; ?></div>
    <?php unset($_SESSION['success_msg']); // Clear the session variable after displaying ?>
  <?php endif; ?>
  <?php if(isset($error_msg)): ?>
    <div class="error-message"><?php echo $error_msg; ?></div>
  <?php endif; ?>
  <div class="profile-picture">
    <img src="<?php echo isset($doctor_details['Photo']) ? $doctor_details['Photo'] : 'Assets/images/default_profile.jpg'; ?>" alt="Profile Picture">
  </div>
  <form id="registration-form" method="POST" action="doctor_account.php" enctype="multipart/form-data" onsubmit="return validateForm()">
    <div class="form-group">
      <label for="Doctor_id">Doctor ID:</label>
      <input type="text" id="Doctor_id" name="Doctor_id" value="<?php echo $doctor_details['Doctor_ID']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="Doctor_name">Doctor Name:</label>
      <input type="text" id="Doctor_name" name="Doctor_name" value="<?php echo $doctor_details['Doctor_Name']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob" value="<?php echo $doctor_details['DOB']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="Address">Address:</label>
      <input type="text" id="Address" name="Address" value="<?php echo $doctor_details['Address']; ?>" required>
    </div>
    <div class="form-group">
      <label for="Qualification">Qualification:</label>
      <input type="text" id="Qualification" name="Qualification" value="<?php echo $doctor_details['Qualification']; ?>" required>
    </div>
    <div class="form-group">
      <label for="License_number">License Number:</label>
      <input type="text" id="License_number" name="License_number" value="<?php echo $doctor_details['Licence_Number']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="Experience">Experience:</label>
      <input type="text" id="Experience" name="Experience" value="<?php echo $doctor_details['Experience']; ?>" required>
    </div>
    <div class="form-group">
      <label for="Specialization">Specialization:</label>
      <input type="text" id="Specialization" name="Specialization" value="<?php echo $doctor_details['Specialization']; ?>" required>
    </div>
    <div class="form-group">
      <label for="Hospital_name">Hospital Name:</label>
      <input type="text" id="Hospital_name" name="Hospital_name" value="<?php echo $doctor_details['Hospital_Name']; ?>" required>
    </div>
    <div class="form-group">
      <label for="Email">Email:</label>
      <input type="email" id="Email" name="Email" value="<?php echo $doctor_details['Email']; ?>" required>
    </div>
    <div class="form-group">
      <label for="phone_number">Phone Number:</label>
      <input type="text" id="phone_number" name="phone_number" value="<?php echo $doctor_details['Phone_number']; ?>" required>
    </div>
    
    <div class="form-group">
      <label for="photo">Photo:</label>
      <input type="file" id="photo" name="photo">
    </div>
    <div class="btn-container">
      <a href="doctor_home.php" class="back-btn"><button type="button">Back</button></a>
      <button type="submit" name="update_doctor">Update</button>
    </div>
  </form>
</div>

<script>
  function validateForm() {
    var phone_number = document.getElementById('phone_number').value;
    var email = document.getElementById('Email').value;

    // Validate phone number format (at least 10 digits)
    if (phone_number.length < 10) {
      alert("Phone number must be at least 10 digits!");
      return false;
    }

    // Validate email format
    if (!isValidEmail(email)) {
      alert("Invalid email format!");
      return false;
    }

    return true;
  }

  // Function to validate email format
  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
</script>

</body>
</html>

