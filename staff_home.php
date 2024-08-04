<?php
session_start();
require 'conn.inc.php'; // Include database connection file
date_default_timezone_set('Asia/Calcutta');

if (isset($_SESSION['User_Id'], $_SESSION['name'], $_SESSION['Email'], $_SESSION['Phone_number'], $_SESSION['type'], $_SESSION['Approved'])) {
    $User_Id = $_SESSION['User_Id'];
    $name = $_SESSION['name'];
    $Email = $_SESSION['Email'];
    $Phone_number = $_SESSION['Phone_number'];
    $acc_type = $_SESSION['type'];
    $Approved = $_SESSION['Approved'];

    if ($acc_type == 'staff') {
        
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
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('Assets/images/staff3.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li:last-child {
            margin-right: 0;
        }

        nav ul li a {
            text-decoration: none;
            font-size: 18px;
            color:white;
            position: relative;
        }

        nav ul li a:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: blue; /* Change underline color to white */
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        nav ul li a:hover:after,
        nav ul li a.active:not([href="landing_page.html"]):after {
            transform: scaleX(1);
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
            padding: 8px 0; /* Adjusted padding */
            min-width: 120px; /* Reduced minimum width */
            text-align: left;
        }

        .dropdown-content a {
            color: #333;
            padding: 10px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #f9f9f9;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropbtn {
            color: white;
            padding: 16px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            background-color: transparent;
        }

        .dropbtn:hover, .dropbtn:focus {
            background-color: #f1f1f1;
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
        <li class="dropdown">
                <a href="staff_home" class="dropbtn">Home <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="staff_account">My Account</a>
                </div>
            <li><a href="staff_appointment_grooming">Appointment status</a></li>
            <li><a href="logout.php" id="login-link">Logout</a></li>

            
        </ul>
    </nav>

    <!-- Content Here -->

</body>
</html>
<?php
       
    } else {
        header("Location: logout.php");
    }
} else {
    header("Location: logout.php");
}
?>