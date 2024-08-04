<?php
session_start();
require 'conn.inc.php';
date_default_timezone_set('Asia/Calcutta'); 
$date = date('Y-m-d')."T".date("H:i:s");
if(isset($_SESSION['User_Id']) && isset($_SESSION['name']) && isset($_SESSION['Email'])&& isset($_SESSION['Phone_number'])&& isset($_SESSION['type']))
{
    $User_Id        =$_SESSION['User_Id'];
    $name           =$_SESSION['name'];
    $Email          =$_SESSION['Email'];
    $Phone_number   =$_SESSION['Phone_number'];
    $acc_type       =$_SESSION['type'];

    echo '$acc_type '.$acc_type ;

    if($acc_type=='admin')
    {   
        header("Location: admin_home"); 
    }
    else if($acc_type=='public')
    {
        header("Location: public_home");  
    } 
    else if($acc_type=='staff')
    {
        header("Location: staff_home");  
    }
}
else
{ 
    $admin_id       ='';
    $name           ='';
    $dob            ='';
    $Email          ='';
    $phone_number   ='';
    $password       ='';
    $error_msg    ="";
    $error_flag   =false;
    $success_msg  ="";
    $success_flag =false;

    if(isset($_POST['user_id']) && isset($_POST['name']) && isset($_POST['dob']) && isset($_POST['Email']) && isset($_POST['phone_number']) && isset($_POST['password']) && isset($_POST['type']))
    {

        $admin_id       =$_POST['user_id'];
        $name           =$_POST['name'];
        $dob            =$_POST['dob'];
        $Email          =$_POST['Email'];
        $phone_number   =$_POST['phone_number'];
        $password       =$_POST['password'];
        $acc_type       =$_POST['type'];
        $password_hash  =md5($password); 
        if(!empty($admin_id) && !empty($name) && !empty($dob) && !empty($Email) && !empty($phone_number) && !empty($password))
        {
            $admin_details_query = "SELECT * FROM `public_register` WHERE `User_Id`='".$admin_id."' OR `Email`='".$Email."' OR `Phone_Number`='".$phone_number."' ";
            $admin_details__run  = @mysqli_query($success_connect,$admin_details_query);
            $admin_details__rows = @mysqli_num_rows($admin_details__run);
            if($admin_details__rows>=1)
            {
                foreach ( $admin_details__run as $var ) 
                {
                    if(($var['Phone_Number']==$phone_number))
                    {
                        $error_msg="Phone number already used in another account!!";
                        $error_flag=true;
                    }
                    if(($var['Email']==$Email))
                    {
                        $error_msg="Email already used in another account!!";
                        $error_flag=true;
                    }
                    if(($var['User_Id']==$admin_id))
                    {
                        $error_msg="User ID already used in another account!!";
                        $error_flag=true;
                    } 
                }   
            }
            else
            {
                if(!$error_flag)
                {
                    $add_admin_data_query="INSERT INTO `public_register` (`User_Id`, `name`,`DOB`,`Email`,`Phone_number`,`Password`,`type`,`Photo`,`created time`,`Approved`) VALUES ('$admin_id' , '$name','$dob','$Email','$phone_number','$password_hash','$acc_type','','$date',1)";
                    $add_admin_data_run  =mysqli_query($success_connect, $add_admin_data_query);

                    $fetch_admin_details_query = "SELECT * FROM `public_register` WHERE `User_Id` = '$admin_id'";
                    $fetch_admin_details__sql  = @mysqli_query($success_connect,$fetch_admin_details_query);
                    $fetch_admin_details__rows = @mysqli_num_rows($fetch_admin_details__sql);
                    if($fetch_admin_details__rows>0)
                    {
                        $success_msg="Successfully registered.Please Login!";
                        $success_flag=true;

                    }
                    else
                    {
                        $success_msg="Some error please try again!";
                        $success_flag=false;

                    }
                }
            }              
        }
        else
        {
          $error_msg="Please Fill All Necessary Fields!!";
          $error_flag=true;
        }
    }
    // Add staff registration logic here
    else if(isset($_POST['user_id']) && isset($_POST['name']) && isset($_POST['dob']) && isset($_POST['Email']) && isset($_POST['phone_number']) && isset($_POST['password']) && isset($_POST['type']))
    {
        $staff_user_id       =$_POST['user_id'];
        $staff_name          =$_POST['name'];
        $staff_dob           =$_POST['dob'];
        $staff_Email         =$_POST['Email'];
        $staff_phone_number  =$_POST['phone_number'];
        $staff_password      =$_POST['password'];
        $staff_acc_type      =$_POST['type'];
        $staff_password_hash =md5($spassword); 

        // Add validation and database insertion logic for staff registration here

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PETBOOK</title>
<link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="Assets/style/public_register.css">
<style>
  
</style>
</head>
<body>
<div class="container">
  <img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
  <h1>Welcome to Pet Book</h1>
  <h2>Register Here!</h2>
  <label for="Error_message" style="color:red;"><?php if($error_flag){ echo $error_msg; }?></label>
  <label for="Error_message" style="color:green;"><?php if($success_flag){ echo $success_msg; }?></label> 
  <form id="registration-form" method="POST" action="public_register" enctype="multipart/form-data" autocomplete="off">
    <div class="form-group">
      <label for="user_id">User ID:</label>
      <input type="text" id="user_id" name="user_id" value="<?php echo $admin_id ; ?>" required>
    </div>
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo $name ; ?>" required>
    </div>
    <div class="form-group">
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob" value="<?php echo $dob ; ?>" required>
      <i class="far fa-calendar-alt"></i> <!-- Calendar icon -->
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="Email" name="Email" value="<?php echo $Email ; ?>" required>
    </div>
    <div class="form-group">
      <label for="phone_number">Phone Number:</label>
      <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number ; ?>" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
      <label for="type"> User Type:</label>
      <select id="type" name="type" required>
        <option value="">Select Type</option>
        <option value="public">Public</option>
        <option value="staff">Staff</option>
        <option value="admin">Admin</option>
      </select>
    </div>
    <div class="form-group">
      <label for="picture">Picture:</label>
      <input type="file" id="picture" name="picture" accept="image/*" onchange="previewImage()" class="upload-btn" value="Upload Image">
      <button type="button" class="upload-btn" onclick="document.getElementById('picture').click()">Choose File</button>
      <div id="preview"></div>
    </div>
    <div class="btn-container">
      <button type="button" class="back-btn" onclick="window.location.href='index'">Back</button>
      <button type="submit" class="submit-btn">Submit</button>
    </div>
  </form>
</div>

<script>
   document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("registration-form");

  form.addEventListener("submit", function(event) {
    // Prevent the form from submitting
    event.preventDefault();

    // Validate Doctor ID, Doctor Name, Address, Qualification, License Number, Experience, Specialization, Hospital Name
    // These validations remain the same as provided in the previous code snippet

    // Validate Date of Birth
    const dob = document.getElementById("dob").value.trim();
    const dobDate = new Date(dob);
    const currentDate = new Date();
    const age = currentDate.getFullYear() - dobDate.getFullYear();
    if (age < 15) {
      alert("Only individuals aged 15 or above can register.");
      return;
    }

    // Validate Email
    const email = document.getElementById("Email").value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert("Please enter a valid Email.");
      return;
    }

    // Validate Phone Number
    const phoneNumber = document.getElementById("phone_number").value.trim();
    if (phoneNumber.length !== 10 || isNaN(phoneNumber)) {
      alert("Please enter a valid 10-digit Phone Number.");
      return;
    }

    // Validate Password
    const password = document.getElementById("password").value.trim();
    const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}$/;
    if (!passwordRegex.test(password)) {
      alert("Password must contain at least 6 characters, including uppercase, lowercase letters, and numbers.");
      return;
    }

    // If all validations pass, submit the form
    form.submit();
  });
});


</script>

</body>
</html>
