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

     //   echo '$acc_type '.$acc_type ;

        if($acc_type=='doctor')
        {
            header("Location: doctor_home"); 
        }
        else if($acc_type=='admin')
        {   
            header("Location: admin_home"); 
        }
        else if($acc_type=='public')
        {
           header("Location: public_home");  
        }          

   }
  else
  {  
        $from_page='';

        if(isset($_GET['page'])){
        $from_page  =$_GET['page'];
        
        }
        $dob_error_flag=false;
        $dob_error_msg="";
        $pass_match_error_flag=false;
        $pass_match_error_msg="";
        $pass_updated_success_msg="";

       if(isset($_POST['email'])&&isset($_POST['dob']) &&isset($_POST['from_page']))
        {
             $user_name =$_POST['email'];
             $dob  =$_POST['dob'];
             $from_page =$_POST['from_page'];

             if($from_page=='doctor')
             {
                if(!empty($user_name)&&!empty($dob))
                {
                    $name_q =mysqli_real_escape_string($success_connect,$user_name);
                    $dob_q  =mysqli_real_escape_string($success_connect,$dob);
                    $query= "SELECT * FROM `doctor_register` WHERE `Doctor_ID`='".$name_q."' AND `DOB`='".$dob_q."' OR `Email`='".$name_q."' AND `DOB`='".$dob_q."' OR `Phone_number`='".$name_q."' AND `DOB`='".$dob_q."'";
                    if ($query_run= mysqli_query($success_connect,$query))
                     {
                        $query_row_num= mysqli_num_rows($query_run);
                        if($query_row_num ==0)
                        {
                            $dob_error_flag=false;
                            $dob_error_msg="Date of Birth and Username notmach Please try again!";
                        }
                        else if($query_row_num ==1)
                        {
                            $dob_error_flag=true;
                            
                        }
                     }
                }

             }else if($from_page=='public')
             {
                if(!empty($user_name)&&!empty($dob))
                {
                    $name_q =mysqli_real_escape_string($success_connect,$user_name);
                    $dob_q  =mysqli_real_escape_string($success_connect,$dob);
                    $query= "SELECT * FROM `public_register` WHERE `User_Id`='".$name_q."' AND `DOB`='".$dob_q."' OR `Email`='".$name_q."' AND `DOB`='".$dob_q."' OR `Phone_Number`='".$name_q."' AND `DOB`='".$dob_q."'";
                    if ($query_run= mysqli_query($success_connect,$query))
                     {
                        $query_row_num= mysqli_num_rows($query_run);
                        if($query_row_num ==0)
                        {
                            $dob_error_flag=false;
                            $dob_error_msg="Date of Birth and Username notmach Please try again!";
                        }
                        else if($query_row_num ==1)
                        {
                            $dob_error_flag=true;

                        }
                     }
                }
             }

        } 
       // echo "heelo1";

        if(isset($_POST['new_password']) &&isset($_POST['confirm_password']) &&isset($_POST['from_page']) &&isset($_POST['user_id']))
        {
            //echo "heelo2";
            $user_name        =$_POST['user_id'];
            $new_password     =$_POST['new_password'];
            $confirm_password =$_POST['confirm_password'];
            $from_page        =$_POST['from_page'];
            if($from_page=='doctor')
             {
                if(!empty($user_name)&&!empty($new_password)&&!empty($confirm_password))
                {
                    
                    $new_password_hash      =md5($new_password);
                    $confirm_password_hash  =md5($confirm_password);
                    if($new_password_hash==$confirm_password_hash)
                    {
                        $name_q                 =mysqli_real_escape_string($success_connect,$user_name);
                        $new_password_hash_q    =mysqli_real_escape_string($success_connect,$new_password_hash);
                        $confirm_password_hash_q=mysqli_real_escape_string($success_connect,$confirm_password_hash);
                        
                        $update_pass_query= "UPDATE  `doctor_register` SET `Password`='$confirm_password_hash_q' WHERE `Doctor_ID`='".$name_q."' OR `Email`='".$name_q."' OR `Phone_number`='".$name_q."' ";
                        if ($update_pass_query_run= mysqli_query($success_connect,$update_pass_query))
                        {
                          $pass_match_error_flag=false;
                          $dob_error_flag=false;
                          $pass_updated_success_msg="Successfully updated Password!";
                        }
                        else{
                          $pass_match_error_flag=true;
                          $dob_error_flag=true;
                          $pass_match_error_msg="Some eroor. Please try again!";
                        }

                    }else{
                        
                        $dob_error_flag=true;
                        $pass_match_error_flag=true;
                        $pass_match_error_msg="Two Passwords are not maching. Please try again!";
                    }
                }

             }else if($from_page=='public')
             {
                 if(!empty($user_name)&&!empty($new_password)&&!empty($confirm_password))
                {
                    
                    $new_password_hash      =md5($new_password);
                    $confirm_password_hash  =md5($confirm_password);
                    if($new_password_hash==$confirm_password_hash)
                    {
                        $name_q                 =mysqli_real_escape_string($success_connect,$user_name);
                        $new_password_hash_q    =mysqli_real_escape_string($success_connect,$new_password_hash);
                        $confirm_password_hash_q=mysqli_real_escape_string($success_connect,$confirm_password_hash);
                        
                        $update_pass_query= "UPDATE  `public_register` SET `Password`='$confirm_password_hash_q' WHERE `User_Id`='".$name_q."' OR `Email`='".$name_q."' OR `Phone_Number`='".$name_q."' ";
                        if ($update_pass_query_run= mysqli_query($success_connect,$update_pass_query))
                        {
                          $pass_match_error_flag=false;
                          $dob_error_flag=false;
                          $pass_updated_success_msg="Successfully updated Password!";
                        }
                        else{
                          $pass_match_error_flag=true;
                          $dob_error_flag=true;
                          $pass_match_error_msg="Some eroor. Please try again!";
                        }

                        
                    }else{
                        
                        $dob_error_flag=true;
                        $pass_match_error_flag=true;
                        $pass_match_error_msg="Two Passwords are not maching. Please try again!";
                    }
                }


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
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <link rel="stylesheet" href="Assets/style/forgot.css">
    <style>

    </style>
</head>
<body>
<div class="container">
        <?php
        if(!$dob_error_flag)
            {
        ?>
                <form class="forgot-password-form" id="forgot-password-form" action="forgot" method="POST">
                    <div class="logo-container">
                    <img src="Assets/images/logo.jpg" alt="Petbook Logo">
                    </div>
                    <h2>Forgot Password</h2>
                    <span style="color: red;"><?php echo $dob_error_msg; ?></span>
                    <span style="color: green;"><?php echo $pass_updated_success_msg; ?></span>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                    <input type="text" id="from_page" name="from_page" value="<?php echo $from_page ;?>" style="display: none;"required>
                    <button type="button" onclick="submitForm()">Reset Password</button>
                    <div class="form-links">
                        <p>Remember your password? <a href="index.php">Login</a></p>
                    </div>
                </form>
        <?php
            }
        if($dob_error_flag)
            {
                ?>

                <form class="forgot-password-form" id="forgot-password-form" action="forgot" method="POST">
                    <div class="logo-container">
                    <img src="Assets/images/logo.jpg" alt="Petbook Logo">
                    </div>
                    <h2>Please Enter New Password</h2>
                    <span style="color: red;"><?php echo $pass_match_error_msg; ?></span>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" placeholder="new password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="confirm password" required>
                    </div>
                    <input type="text" id="from_page" name="from_page" value="<?php echo $from_page ;?>" style="display: none;"
                    required>
                    <input type="text" id="user_id" name="user_id" value="<?php echo $user_name ;?>" style="display: none;"
                    required>
                    <button type="submit" >Reset Password</button>
                    <div class="form-links">
                        <p>Remember your password? <a href="index.php">Login</a></p>
                    </div>
                </form>


                <?php
            }

        ?>

    </div>

    <script>
        function submitForm() {
            var email = document.getElementById('email').value;
            if (email !== '') {
                document.getElementById('forgot-password-form').submit();
            }
        }
        
    </script>
</body>
</html>
<?php
}
?>