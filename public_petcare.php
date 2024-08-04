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
    if($acc_type=='public')
        { 

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK </title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/public_petcare.css">
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
            color: blue;
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
            <li><a href="public_home_petcare">Home</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn" >Pet Registration <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="public_account">Pet Account</a>
                    <a href="pet_register">Pet Registration</a>
                </div>
            </li>  
            <li><a href="public_service">Services</a></li>
            <li><a href="public_medicalrecord">Medical Records</a></li>
            <li><a href="pblic_feedback">Feedback</a></li>
            <li><a href="logout" id="login-link">Logout</a></li>
        </ul>
    </nav>


    <div class="reminder-container">
        <div class="reminder-box" onclick="goToVaccinationPage()">
            <h2>DOG</h2>
            <img src="Assets/images/pet5.jpg" alt="Vaccination Image">
        </div>
        <div class="reminder-box" onclick="goToDewormingPage()">
            <h2>CAT</h2>
            <img src="Assets/images/pet6.jpg" alt="Deworming Image">
        </div>
    </div>

    <script>
        function goToVaccinationPage() {
            // Redirect to vaccination page
            window.location.href = "public_pet_healthcare1";
        }

        function goToDewormingPage() {
            // Redirect to deworming page
            window.location.href = "public_pet_healthcare2";
        }
    </script>
</body>
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