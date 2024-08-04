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
    <title>PETBOOK</title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/public_hygiene2.css">
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
            color: black;
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
            <li><a href="public_pet_healthcare2">Home</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Pet Registration <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="public_account">Pet Account</a>
                    <a href="pet_register">Pet Registration</a>
                </div>
            </li>  
            <li><a href="public_service">Services</a></li>
            <li><a href="public_medicalrecord">Medical Records</a></li>
            <li><a href="public_feedback">Feedback</a></li>
            <li><a href="logout" id="login-link">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="hygiene-section">
            <img src="Assets/images/cathyge.jpg" alt="Cat Hygiene" style="display: block; margin: 0 auto; max-width: 40%;" /><br>
                     <br><p>Cats are known for their cleanliness, but they still need assistance with grooming to maintain their health and well-being.</p>

            <h2 >Tips to keep up with your cat's hygiene routine</h2>

            <p>Here are a few tips to help you maintain your cat's hygiene:</p>

            <h3 style="color: blue;">Grooming tips</h3>
            <ul>
                <li><strong>Brush regularly:</strong> Brushing your cat's fur removes loose hair and prevents mats. It also stimulates circulation and distributes natural oils.</li><br><br>
                <li><strong>Trim nails:</strong> Regular nail trimming helps prevent overgrowth and reduces the risk of ingrown nails.</li>
                <li><strong>Ear cleaning:</strong> Check your cat's ears regularly for signs of dirt or wax buildup. Use a damp cotton ball to gently clean the outer ear.</li><br><br>
                <li><strong>Oral hygiene:</strong> Brush your cat's teeth regularly to prevent dental issues. You can use a cat-specific toothbrush and toothpaste.</li><br><br>
            </ul>

            <h3 style="color: blue;">Hygiene tips</h3>
            <ul>
                <li><strong>Litter box maintenance:</strong> Keep the litter box clean by scooping it daily and changing the litter regularly. Cats are fastidious creatures and prefer a clean environment.</li><br><br>
                <li><strong>Bathing:</strong> Most cats do not require regular baths, as they are capable of grooming themselves. However, if your cat gets into something sticky or dirty, you may need to give them a bath using a cat-specific shampoo.</li><br><br>
                <li><strong>Flea control:</strong> Use flea prevention products recommended by your veterinarian to keep your cat free from fleas and ticks.</li><br><br>
            </ul>
        </div>
    </div>
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