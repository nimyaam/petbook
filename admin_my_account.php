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
    if($acc_type=='admin')
        {    
            $admin_id       =$User_Id;
            $name           ='';
            $dob            ='';
            $Email          ='';
            $phone_number   ='';
            $password       ='';
            $error_msg="";
            $error_flag=false;
            $success_msg="";
            $success_flag=false;

         
                $admin_details_query = "SELECT * FROM `public_register` WHERE `User_Id`='".$admin_id."'";
                //echo $admin_details_query;
                $admin_details__run  = @mysqli_query($success_connect,$admin_details_query);
                $admin_details__rows = @mysqli_num_rows($admin_details__run);
                if($admin_details__rows>=1){
                   
                   foreach ( $admin_details__run as $var ) {

                    $admin_id       =$var['User_Id'];
                    $name           =$var['name'];
                    $dob            =$var['DOB'];
                    $Email          =$var['Email'];
                    $phone_number   =$var['Phone_Number'];
                        
                   }   

                }

            if(isset($_POST['Email'])&&isset($_POST['phone_number'])&&isset($_POST['password']))
              {
                
                $Email          =$_POST['Email'];
                $phone_number   =$_POST['phone_number'];
                $password       =$_POST['password'];
                $password_hash  =md5($password);     
                if(!empty($Email)&&!empty($phone_number)&&!empty($password))
                {
                    $admin_details_query = "SELECT * FROM `public_register` WHERE `type`='admin'";
                    //echo $admin_details_query;
                    $admin_details__run  = @mysqli_query($success_connect,$admin_details_query);
                    $admin_details__rows = @mysqli_num_rows($admin_details__run);
                    if($admin_details__rows>=1){
                        foreach ( $admin_details__run as $var ) {
                        if(($var['User_Id']!=$admin_id))
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
                              
                          } 
                   }  
                    }
                    
                    if(!$error_flag)
                        {
                            
                            $update_admin_details_query="UPDATE  `public_register`SET `Email`='$Email',`Phone_Number`='$phone_number',`Password`='$password_hash' WHERE `User_Id` = '$admin_id'";
                           // echo $update_admin_details_query;
                              if ($query_run= mysqli_query($success_connect,$update_admin_details_query))
                                {
                                  $success_msg="Successfully updated Admin Details!";
                                  $success_flag=true;
                                }
                               else{
                                  $success_msg="Error in update admin details!";
                                  $success_flag=false;
                               } 
                        }

                    
                }
                else{
                    $error_msg="Fields cannot be Empty!";
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

    <h2 style="color: white;" >My Account</h2>

    <!-- Section for New Registrations -->
    <div class="container section">
    <label for="Error_message" style="color:red;"><?php if($error_flag){ echo $error_msg; }?></label>
    <label for="Error_message" style="color:green;"><?php if($success_flag){ echo $success_msg; }?></label>    
    <form id="registration-form" method="POST" action="admin_my_account" enctype="multipart/form-data" autocomplete="off" >
        <div class="form-group">
          <label for="Doctor_id">User ID:</label>
          <input type="text" id="Doctor_id" name="admin_id" value="<?php echo $admin_id ; ?>" readonly required>
        </div>
        <div class="form-group">
          <label for="Doctor_id">Name</label>
          <input type="text" id="name" name="name" value="<?php echo $name ;?>" readonly   required>
        </div>
        <div class="form-group">
          <label for="Email">Email:</label>
          <input type="email" id="Email" name="Email" value="<?php echo $Email ;?>"readonly required>
        </div>
        <div class="form-group">
          <label for="dob">Date of birth:</label>
          <input type="date" id="dob" name="dob" value="<?php echo $dob;?>" readonly required>
        </div>
        <div class="form-group">
          <label for="phone_number">Phone Number:</label>
          <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number ;?>" readonly required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" value="********" readonly required>
        </div>
        <div class="btn-container">
          <button type="button" class="back-btn" onclick="edit_active()">Edit</button>
          <button type="submit" id="submit_form" class="submit-btn" disabled>Submit</button>
        </div>
      </form>
    </div>

</body>
<script>
    function edit_active()
    {
        document.getElementById("Email").readOnly = false;
        document.getElementById("phone_number").readOnly = false;
        document.getElementById("password").readOnly = false;
        document.getElementById("submit_form").disabled  = false;
        document.getElementById("password").value = '';
        alert("Form is Editable Now!");
    }
</script>
</html>
<?php 
}else{
    header("Location: logout"); 
}
}
else{
    header("Location: logout"); 
}
?>