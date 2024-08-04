<?php
session_start();
require 'conn.inc.php'; // Assuming this file contains your database connection
date_default_timezone_set('Asia/Calcutta');
$date = date('Y-m-d H:i:s'); // Use Y-m-d H:i:s format for datetime

// Check if staff is logged in
if(isset($_SESSION['User_Id'], $_SESSION['name'], $_SESSION['Email'], $_SESSION['Phone_number'], $_SESSION['type'])) {
        
    $User_Id        = $_SESSION['User_Id'];
    $name           = $_SESSION['name'];
    $Email          = $_SESSION['Email'];
    $Phone_number   = $_SESSION['Phone_number'];
    $acc_type       = $_SESSION['type'];

    if($acc_type == 'staff') {
        // Fetch staff's details from database
        $fetch_staff_query = "SELECT * FROM `public_register` WHERE `User_Id` = '$User_Id'";
        $fetch_staff_run   = mysqli_query($success_connect, $fetch_staff_query);
        
        if(mysqli_num_rows($fetch_staff_run) > 0) {
            $staff_details = mysqli_fetch_assoc($fetch_staff_run);

            // Handle form submission to update staff's details
            if(isset($_POST['update_staff'])) {
                $name           = $_POST['name'];
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

                // Validate email format
                if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                    $error_msg = "Invalid email format!";
                } else {
                    // Validate phone number format
                    if (!preg_match("/^[0-9 +()-]{10,}$/", $phone_number)) {
                        $error_msg = "Invalid phone number format! Must be at least 10 digits.";
                    } else {
                        // Update staff's details in database
                        $update_staff_query = "UPDATE `public_register` SET `name`='$name', `DOB`='$dob', `Email`='$Email', `Phone_number`='$phone_number', `Password`='$password_hash', `Photo`='$photo_destination', `created time`='$date' WHERE `User_Id`='$User_Id'";
                        $update_staff_run   = mysqli_query($success_connect, $update_staff_query);

                        if($update_staff_run) {
                            $_SESSION['success_msg'] = "Staff details updated successfully!";
                            // Redirect to prevent resubmission on page refresh
                            header("Location: staff_account.php");
                            exit;
                        } else {
                            $error_msg = "Error updating staff details: " . mysqli_error($success_connect);
                        }
                    }
                }
            }
        } else {
            $error_msg = "Staff details not found!";
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
<title>PETBOOK </title>
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
  <h1>My Account </h1>
  <?php if(isset($_SESSION['success_msg'])): ?>
    <div class="success-message"><?php echo $_SESSION['success_msg']; ?></div>
    <?php unset($_SESSION['success_msg']); // Clear the session variable after displaying ?>
  <?php endif; ?>
  <?php if(isset($error_msg)): ?>
    <div class="error-message"><?php echo $error_msg; ?></div>
  <?php endif; ?>
  <div class="profile-picture">
    <img src="<?php echo isset($staff_details['Photo']) ? $staff_details['Photo'] : 'Assets/images/default_profile.jpg'; ?>" alt="Profile Picture">
  </div>
  <form id="registration-form" method="POST" action="staff_account.php" enctype="multipart/form-data" onsubmit="return validateForm()">
    <div class="form-group">
    <label for="user_id">User ID:</label>
      <input type="text" id="user_id" name="user_id" value="<?php echo $staff_details['User_Id']; ?>" readonly>
   
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo $staff_details['name']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob" value="<?php echo $staff_details['DOB']; ?>" readonly>
    </div>
    <div class="form-group">
      <label for="Email">Email:</label>
      <input type="email" id="Email" name="Email" value="<?php echo $staff_details['Email']; ?>" required>
    </div>
    <div class="form-group">
      <label for="phone_number">Phone Number:</label>
      <input type="text" id="phone_number" name="phone_number" value="<?php echo $staff_details['Phone_Number']; ?>" required>
    </div>
    
    <div class="form-group">
      <label for="photo">Photo:</label>
      <input type="file" id="photo" name="photo" >
    </div>
    <div class="btn-container">
      <a href="staff_home.php" class="back-btn"><button type="button">Back</button></a>
      <button type="submit" name="update_staff">Update</button>
    </div>
  </form>
</div>

<script>
  function validateForm() {
    var email = document.getElementById('Email').value;
    var phone_number = document.getElementById('phone_number').value;

    // Email validation
    if (!isValidEmail(email)) {
      alert("Invalid email format!");
      return false;
    }

    // Phone number validation
    if (!isValidPhoneNumber(phone_number)) {
      alert("Invalid phone number format! Must be at least 10 digits.");
      return false;
    }

    return true;
  }

  // Function to validate email format
  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  // Function to validate phone number format
  function isValidPhoneNumber(phone_number) {
    return /^[0-9 +()-]{10,}$/.test(phone_number);
  }
</script>

</body>
</html>
