<?php
session_start();
$error_msg="";
$type="";
$flag=false;
$doctor_form_display='none';
$public_form_display='none';
$User_Id        ='';
$name           ='';
$Email          ='';
$Phone_number   ='';
$acc_type       ='';
if(isset($_GET['msg'])&&isset($_GET['type'])&&isset($_GET['flag'])){
    $error_msg  =$_GET['msg'];
    $type       =$_GET['type'];
    $flag       =$_GET['flag'];
}

if(($type=='doctor')&&($flag==true))
{
    $doctor_form_display='block';
}
if(($type=='public')&&($flag==true))
{
    $public_form_display='block';
}



if(isset($_SESSION['User_Id']) && isset($_SESSION['name']) && isset($_SESSION['Email'])&& isset($_SESSION['Phone_number'])&& isset($_SESSION['type']))
  {
        
        $User_Id        =$_SESSION['User_Id'];
        $name           =$_SESSION['name'];
        $Email          =$_SESSION['Email'];
        $Phone_number   =$_SESSION['Phone_number'];
        $acc_type       =$_SESSION['type'];

        echo '$acc_type '.$acc_type ;

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
        else if($acc_type=='staff')
{
    header("Location: staff_home");  
}         

   }
  else
  {  

  
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
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <link rel="stylesheet" href="Assets/style/index.css">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
            <span class="logo-text">PETBOOK</span>
        </div>
        <ul>
            <!-- Add separate login options for doctors and public -->
            <li><a href="#" id="doctor-login">Doctor Login</a></li>
            <li><a href="#" id="public-login">Public Login</a></li>
            
            <!-- Add dark mode / light mode toggle icon -->
            <li><a href="#" id="dark-mode-toggle"><i class="far fa-moon"></i></a></li>
        </ul>
    </nav>

    <div class="content">
        <p style="display:inline-block ;">Welcome to Pet Book!<br> where we prioritize your pets' health and happiness..<br> Our dedicated veterinary care team offers personalized services and valuable resources to support you in being the best pet parent possible...<br> Join our community and ensure your furry friends thrive!</p>
        <button class="login-button" id="login-button">Get Start </button>
    </div>

    <div id="doctor-login-form" class="login-form" style="display: <?php echo $doctor_form_display; ?>;">
        <span style="color: red;"><?php echo $error_msg; ?></span>
        <span class="close" id="close-doctor-form">&times;</span>
        <form method="POST" action="login">
            <label for="email" style="color: #000;"></label><br>
            <div class="input-group">
                <input type="text" id="email" name="email" placeholder="Doctor id,email or phone number" required>
                <i class="far fa-envelope"></i>
            </div>
            <label for="password" style="color: #000;"></label><br>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder=" password" required>
                <i class="far fa-eye" id="togglePassword"></i>
            </div>
            <input type="text" id="user_type" name="user_type" value="doctor" style="display: none;">
            <input type="submit" value="Login">
        </form>
        <p style="color: #000;">Don't have an account? <a href="doctor_register">Register Now</a></p>
        <p style="color: #000;">Forgot your password? <a href="forgot?page=doctor">Reset it</a></p>
    </div>

    <div id="public-login-form" class="login-form" style="display: <?php echo $public_form_display; ?>;">
        <span style="color: red;"><?php echo $error_msg; ?></span>
        <span class="close" id="close-public-form">&times;</span>
        <form method="POST" action="login">
            <label for="email" style="color: #000;"></label><br>
            <div class="input-group">
                <input type="text" id="email" name="email" placeholder="User id,email or phone number" required>
                <i class="far fa-envelope"></i>
            </div>
            <label for="password" style="color: #000;"></label><br>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder=" password" required>
                <i class="far fa-eye" id="togglePassword"></i>
            </div>
           
            <input type="text" id="user_type" name="user_type" value="public" style="display: none;">
            <input type="submit" value="Login">
        </form>
        <p style="color: #000;">Don't have an account? <a href="public_register">Register Now</a></p>
        <p style="color: #000;">Forgot your password? <a href="forgot?page=public">Reset it</a></p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const doctorLogin = document.getElementById("doctor-login");
            const publicLogin = document.getElementById("public-login");
            const doctorLoginForm = document.getElementById("doctor-login-form");
            const publicLoginForm = document.getElementById("public-login-form");
            const closeDoctorForm = document.getElementById("close-doctor-form");
            const closePublicForm = document.getElementById("close-public-form");

            doctorLogin.addEventListener("click", function() {
                doctorLoginForm.style.display = "block";
                publicLoginForm.style.display = "none";
            });

            publicLogin.addEventListener("click", function() {
                publicLoginForm.style.display = "block";
                doctorLoginForm.style.display = "none";
            });

            closeDoctorForm.addEventListener("click", function() {
                doctorLoginForm.style.display = "none";
            });

            closePublicForm.addEventListener("click", function() {
                publicLoginForm.style.display = "none";
            });

            // Toggle password visibility
            document.getElementById('togglePassword').addEventListener('click', function() {
                var passwordInput = document.getElementById('password');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });

            // Dark mode / light mode toggle
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            darkModeToggle.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');
            });
        });
    </script>
</body>
</html>
<?php
}
?>