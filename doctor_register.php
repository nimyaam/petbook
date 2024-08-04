<?php
session_start();
require 'conn.inc.php';
date_default_timezone_set('Asia/Calcutta'); 
$date = date('Y-m-d')."T".date("H:i:s");
//echo $_SESSION['User_Id'].",".$_SESSION['name'].",".$_SESSION['Email'].",".$_SESSION['Phone_number'].",".$_SESSION['type'];
if(isset($_SESSION['User_Id']) && isset($_SESSION['name']) && isset($_SESSION['Email'])&& isset($_SESSION['Phone_number'])&& isset($_SESSION['type']))
  {
        
        $User_Id        =$_SESSION['User_Id'];
        $name           =$_SESSION['name'];
        $Email          =$_SESSION['Email'];
        $Phone_number   =$_SESSION['Phone_number'];
        $acc_type       =$_SESSION['type'];
    if($acc_type=='doctor')
        {     
          header("Location: doctor_home"); 
        }
    else{
          header("Location: logout"); 
        }     
  }
 else{ 

    $Doctor_id      ='';
    $Doctor_name    ='';
    $Address        ='';
    $Qualification  ='';
    $License_number ='';
    $Experience     ='';
    $Specialization ='';
    $Hospital_name  ='';
    $Email          ='';
    $dob            ='';
    $phone_number   ='';
    $password       ='';
    $error_msg="";
    $error_flag=false;
    $success_msg="";
    $success_flag=false;
    $uploadOk =1;
    $image_upload_msg="";
 if(isset($_POST['Doctor_id'])&&isset($_POST['Doctor_name'])&&isset($_POST['Address'])&&isset($_POST['Qualification'])&&isset($_POST['License_number'])&&isset($_POST['Experience'])&&isset($_POST['Specialization'])&&isset($_POST['Hospital_name'])&&isset($_POST['Email'])&&isset($_POST['phone_number'])&&isset($_POST['password']))
  {
    $Doctor_id      =$_POST['Doctor_id'];
    $Doctor_name    =$_POST['Doctor_name'];
    $Address        =$_POST['Address'];
    $Qualification  =$_POST['Qualification'];
    $License_number =$_POST['License_number'];
    $Experience     =$_POST['Experience'];
    $Specialization =$_POST['Specialization'];
    $Hospital_name  =$_POST['Hospital_name'];
    $Email          =$_POST['Email'];
    $dob            =$_POST['dob'];
    $phone_number   =$_POST['phone_number'];
    $password       =$_POST['password'];
    $password_hash  =md5($password);
    $image_target_location="User_Uploads/Doctor/images/";
    if(strlen($License_number) != 4) {
      $error_msg = "License number must be exactly 4 digits.";
      $error_flag = true;
  }

  // Check if the License Number is unique
  $check_license_query = "SELECT * FROM `doctor_register` WHERE `Licence_Number` = '$License_number'";
  $check_license_run = mysqli_query($success_connect, $check_license_query);
  if(mysqli_num_rows($check_license_run) > 0) {
      $error_msg = "License number is already used in another account!!";
      $error_flag = true;
  }
    if($_FILES["picture"]["name"]!='')
    {

      // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if($check !== false) {
          $image_upload_msg= "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        } else {
          $image_upload_msg= "File is not an image.";
          $uploadOk = 0;
        }
      
      // Check file size
      if ($_FILES["picture"]["size"] > 5000000) {
        $image_upload_msg= "Sorry, your file is too large.";
        $uploadOk = 0;
      }

      // Allow certain file formats
      $imageFileType = strtolower(pathinfo(basename($_FILES["picture"]["name"]),PATHINFO_EXTENSION));
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        $image_upload_msg= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
      }
    }

    
    if(!empty($Doctor_id)&&!empty($Doctor_name)&&!empty($Address)&&!empty($Qualification)&&!empty($License_number)&&!empty($Experience)&&!empty($Specialization)&&!empty($Hospital_name)&&!empty($Email)&&!empty($phone_number)&&!empty($password))
    {
        $doctor_details_query = "SELECT * FROM `doctor_register` WHERE `Doctor_ID`='".$Doctor_id."' OR `Email`='".$Email."' OR `Phone_number`='".$phone_number."' OR `Doctor_ID`='".$License_number."' ";
        $doctor_details__run  = @mysqli_query($success_connect,$doctor_details_query);
        $doctor_details__rows = @mysqli_num_rows($doctor_details__run);

        if($doctor_details__rows>=1){
         // echo "Exist<br>";
          foreach ( $doctor_details__run as $var ) {
              if(($var['Phone_number']==$phone_number))
              {
                $error_msg="Phone number already used in another account!!";
                $error_flag=true;
              }
              if(($var['Email']==$Email))
              {
                $error_msg="Email already used in another account!!";
                $error_flag=true;
              }
              if(($var['Doctor_ID']==$Doctor_id))
              {
                $error_msg="Doctor ID already used in another account!!";
                $error_flag=true;
              } 
              if(($var['Doctor_ID']==$License_number))
              {
                $error_msg="License number already used in another account!!";
                $error_flag=true;
              }
              if(!$uploadOk) {
                $error_msg=$image_upload_msg;
                $error_flag=true;
              }

              
          }  

        }else{

          if(!$error_flag)
          {

            $add_doctor_data_query="INSERT INTO `doctor_register` (`sl`,`Doctor_ID`, `Doctor_Name`,`DOB`,`Address`,`Qualification`,`Licence_Number`,`Experience`,`Specialization`,`Hospital_Name`,`Email`,`Phone_number`,`Password`,`Photo`,`time`) VALUES ('','$Doctor_id' , '$Doctor_name','$dob','$Address','$Qualification','$License_number','$Experience','$Specialization','$Hospital_name','$Email','$phone_number','$password_hash','','$date')";
            $add_doctor_data_run  =mysqli_query($success_connect, $add_doctor_data_query);

            $fetch_doctor_details_query = "SELECT * FROM `doctor_register` WHERE `Doctor_ID` = '$Doctor_id'";
            $fetch_doctor_details__sql  = @mysqli_query($success_connect,$fetch_doctor_details_query);
            $fetch_doctor_details__rows = @mysqli_num_rows($fetch_doctor_details__sql);

            if($fetch_doctor_details__rows>0)
            {
              if($_FILES["picture"]["name"]!='')
              {
                if($uploadOk) {
                foreach ( $fetch_doctor_details__sql as $var ) {
                  $slno=$var['sl'];
                }
                $imageFileType = strtolower(pathinfo(basename($_FILES["picture"]["name"]),PATHINFO_EXTENSION));
                $target_file = $image_target_location . $slno .'.'.$imageFileType;
                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                  $update_image_loc_query="UPDATE  `doctor_register` SET `Photo`='$target_file' WHERE `sl` = '$slno'";
                  if ($query_run= mysqli_query($success_connect,$update_image_loc_query))
                    {
                      $success_msg="Successfully registered new doctor with Photo!";
                      $success_flag=true;
                    }
                }
              }
              }
              else{
              $success_msg="Successfully registered new doctor!";
              $success_flag=true;
             } 
            }
          }

        }



        //echo $Doctor_id.$Doctor_name.$Address;
    }else{
      $error_msg="Please Fill All Necessary Fields!!";
      $error_flag=true;
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
<link rel="stylesheet" href="Assets/style/doctor_register.css">
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
  <form id="registration-form" method="POST" action="doctor_register" enctype="multipart/form-data" >
    <div class="form-group">
      <label for="Doctor_id">Doctor ID:</label>
      <input type="text" id="Doctor_id" name="Doctor_id" value="<?php echo $Doctor_id ;?>" required>
    </div>
    <div class="form-group">
      <label for="Doctor_name">Doctor Name:</label>
      <input type="text" id="Doctor_name" name="Doctor_name" value="<?php echo $Doctor_name ;?>" required>
    </div>
    <div class="form-group">
          <label for="dob">Date of birth:</label>
          <input type="date" id="dob" name="dob" value="<?php echo $dob;?>" required>
        </div>
    <div class="form-group">
      <label for="Address">Address:</label>
      <input type="text" id="Address" name="Address" value="<?php echo $Address ;?>" required>
    </div>
    <div class="form-group">
      <label for="Qualification">Qualification:</label>
      <input type="text" id="Qualification" name="Qualification" value="<?php echo $Qualification ;?>" required>
    </div>
    <div class="form-group">
      <label for="License_number">License Number:</label>
      <input type="text" id="License_number" name="License_number" value="<?php echo $License_number ;?>" required>
    </div>
    <div class="form-group">
      <label for="Experience">Experience:</label>
      <input type="text" id="Experience" name="Experience" value="<?php echo $Experience ;?>" required>
    </div>
    <div class="form-group">
      <label for="Specialization">Specialization:</label>
      <input type="text" id="Specialization" name="Specialization" value="<?php echo $Specialization ;?>" required>
    </div>
    <div class="form-group">
      <label for="Hospital_name">Hospital Name:</label>
      <input type="text" id="Hospital_name" name="Hospital_name" value="<?php echo $Hospital_name ;?>" required>
    </div>
    <div class="form-group">
      <label for="Email">Email:</label>
      <input type="email" id="Email" name="Email" value="<?php echo $Email ;?>" required>
    </div>
    <div class="form-group">
      <label for="phone_number">Phone Number:</label>
      <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number ;?>" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" value="" autocomplete="off"  required>
    </div>
    <div class="form-group">
      <label for="picture">Picture:</label>
      <input type="file" id="picture" name="picture" accept="image/*" onchange="previewImage()" class="upload-btn" value="Upload Image">
      <!--<button type="button" class="upload-btn" onclick="document.getElementById('picture').click()">Choose File</button>-->
      <div id="preview"></div>
    </div>
    <!-- Other form fields -->
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
    if (age < 22) {
      alert("Only individuals aged 22 or above can register.");
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
<?php 
  }
?>