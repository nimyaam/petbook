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
    <link rel="stylesheet" href="Assets/style/public_symptom2.css">
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
    
    <header>
        
    </header>
    
    <main>
        <section class="disease">
            <h1 text align="center">Common Cat Diseases and Their Symptoms</h1>
            <h2 style="color: blue;">Feline Upper Respiratory Infections (URI)</h2>
            <img src="Assets/images/hyge3.jpg" alt="Feline Upper Respiratory Infections">
            <h3>Symptoms:</h3>
            <ul>
                <li>Sneezing</li>
                <li>Runny nose</li>
                <li>Watery eyes</li>
                <li>Coughing</li>
                <li>Lethargy</li>
                <li>Fever</li>
            </ul>
            <h3>Prevention:</h3>
            <ul>
                <li>Regular vaccinations</li>
                <li>Keep your cat indoors</li>
                <li>Avoid exposure to infected cats</li>
                <li>Maintain a clean living environment</li>
            </ul>
        </section>

        <section class="disease">
            <h2 style="color: blue;">Feline Lower Urinary Tract Disease (FLUTD)</h2>
            <img src="Assets/images/hyge4.jpg" alt="Feline Lower Urinary Tract Disease">
            <h3>Symptoms:</h3>
            <ul>
                <li>Frequent urination</li>
                <li>Painful urination</li>
                <li>Blood in urine</li>
                <li>Urinating outside the litter box</li>
                <li>Licking the urinary opening</li>
            </ul>
            <h3>Prevention:</h3>
            <ul>
                <li>Ensure proper hydration</li>
                <li>Provide a balanced diet</li>
                <li>Maintain a clean litter box</li>
                <li>Regular veterinary check-ups</li>
            </ul>
        </section>

        <section class="disease">
            <h2 style="color: blue;">Feline Diabetes</h2>
            <img src="Assets/images/hyge5.jpg" alt="Feline Diabetes">
            <h3>Symptoms:</h3>
            <ul>
                <li>Increased thirst</li>
                <li>Increased urination</li>
                <li>Weight loss despite increased appetite</li>
                <li>Lethargy</li>
                <li>Vomiting</li>
            </ul>
            <h3>Prevention:</h3>

<ul>
                <li>Maintain a healthy diet</li>
                <li>Regular exercise</li>
                <li>Monitor weight and body condition</li>
                <li>Regular veterinary check-ups</li>
            </ul>
        </section>
    </main>
    
    
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