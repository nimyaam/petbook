<?php
session_start();
require 'conn.inc.php';
date_default_timezone_set('Asia/Calcutta'); 
$date = date('Y-m-d')."T".date("H:i:s");
//echo $_SESSION['User_Id'].",".$_SESSION['name'].",".$_SESSION['Email'].",".$_SESSION['Phone_number'].",".$_SESSION['type'];
if(isset($_SESSION['User_Id']) && isset($_SESSION['name']) && isset($_SESSION['Email'])&& isset($_SESSION['Phone_number'])&& isset($_SESSION['type'])&& isset($_SESSION['Approved']))
  {
        
        $User_Id        =$_SESSION['User_Id'];
        $name           =$_SESSION['name'];
        $Email          =$_SESSION['Email'];
        $Phone_number   =$_SESSION['Phone_number'];
        $acc_type       =$_SESSION['type'];
        $Approved       =$_SESSION['Approved'];
    if($acc_type=='admin')
        {    
         if($Approved==1)
          {  
            $admin_id       ='';
            $name           ='';
            $dob            ='';
            $Email          ='';
            $phone_number   ='';
            $password       ='';
            $error_msg="";
            $error_flag=false;
            $success_msg="";
            $success_flag=false;

         if(isset($_POST['admin_id'])&&isset($_POST['name'])&&isset($_POST['dob'])&&isset($_POST['Email'])&&isset($_POST['phone_number'])&&isset($_POST['password']))
          {
            $admin_id       =$_POST['admin_id'];
            $name           =$_POST['name'];
            $dob            =$_POST['dob'];
            $Email          =$_POST['Email'];
            $phone_number   =$_POST['phone_number'];
            $password       =$_POST['password'];
            $password_hash  =md5($password); 
            if(!empty($admin_id)&&!empty($name)&&!empty($dob)&&!empty($Email)&&!empty($phone_number)&&!empty($password))
            {
                $admin_details_query = "SELECT * FROM `public_register` WHERE `User_Id`='".$admin_id."' OR `Email`='".$Email."' OR `Phone_Number`='".$phone_number."' ";
                //echo $admin_details_query;
                $admin_details__run  = @mysqli_query($success_connect,$admin_details_query);
                $admin_details__rows = @mysqli_num_rows($admin_details__run);
                if($admin_details__rows>=1){
                   
                   foreach ( $admin_details__run as $var ) {
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
                            $error_msg="Admin ID already used in another account!!";
                            $error_flag=true;
                          } 
                   }   

                }else{
                     if(!$error_flag)
                        {
                             $add_admin_data_query="INSERT INTO `public_register` (`User_Id`, `name`,`DOB`,`Email`,`Phone_number`,`Password`,`type`,`Photo`,`created time`,`Approved`) VALUES ('$admin_id' , '$name','$dob','$Email','$phone_number','$password_hash','admin','','$date',1)";
                            $add_admin_data_run  =mysqli_query($success_connect, $add_admin_data_query);

                            $fetch_admin_details_query = "SELECT * FROM `public_register` WHERE `User_Id` = '$admin_id'";
                            $fetch_admin_details__sql  = @mysqli_query($success_connect,$fetch_admin_details_query);
                            $fetch_admin_details__rows = @mysqli_num_rows($fetch_admin_details__sql);
                            if($fetch_admin_details__rows>0)
                            {
                                $success_msg="Successfully registered new Admin!";
                                $success_flag=true;

                            }else{
                                $success_msg="Some error please try again!";
                                $success_flag=false;

                            }
                        }

                }

            }
            else{
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
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/admin_home.css">
    <style>
       
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
            <span class="logo-text">PETBOOK</span>
        </div>
        <ul>
            <li><a href="admin_home">Home</a></li>
            <li><a href="admin_Public">Public</a></li>
            <li><a href="admin_admin">Admin</a></li>
            <li><a href="admin_doctor">Doctor</a></li>
            <li><a href="admin_staff">staff</a></li>

            <li><a href="admin_feedback">Feedback</a></li>
            <li><a href="admin_my_account">My Account</a></li>
            <li><a href="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li> <!-- Added logout icon -->
        </ul>
    </nav>

    <!-- Content Here -->

    <h2 style="color: white;" >Register A New Admin</h2>

    <!-- Section for New Registrations -->
    <div class="container section">
    <label for="Error_message" style="color:red;"><?php if($error_flag){ echo $error_msg; }?></label>
    <label for="Error_message" style="color:green;"><?php if($success_flag){ echo $success_msg; }?></label>    
    <form id="registration-form" method="POST" action="admin_home" enctype="multipart/form-data" autocomplete="off" >
        <div class="form-group">
          <label for="Doctor_id">User ID:</label>
          <input type="text" id="Doctor_id" name="admin_id" value="<?php echo $admin_id ; ?>" required>
        </div>
        <div class="form-group">
          <label for="Doctor_id">Name</label>
          <input type="text" id="name" name="name" value="<?php echo $name ;?>"  required>
        </div>
        <div class="form-group">
          <label for="Email">Email:</label>
          <input type="email" id="Email" name="Email" value="<?php echo $Email ;?>" required>
        </div>
        <div class="form-group">
          <label for="dob">Date of birth:</label>
          <input type="date" id="dob" name="dob" value="<?php echo $dob;?>" required>
        </div>
        <div class="form-group">
          <label for="phone_number">Phone Number:</label>
          <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number ;?>" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="btn-container">
          <!--<button type="button" class="back-btn" onclick="window.location.href='index'">Back</button>-->
          <button type="submit" class="submit-btn">Submit</button>
        </div>
      </form>
    </div>

</body>
</html>
<?php 
}else{
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK</title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/admin_home.css">
    <style>
       
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
            <span class="logo-text">PETBOOK</span>
        </div>
        <ul>
            <li><a href="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li> <!-- Added logout icon -->
        </ul>
    </nav>
    <h2 style="color: white;" >Account is in Rejected status contact another admin</h2>
    <div class="container section">

    </div>
    </body>
</html>
<?php

}

}else{
    header("Location: logout"); 
}
}
else{
    header("Location: logout"); 
}
?>