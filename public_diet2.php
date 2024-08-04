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
    <link rel="stylesheet" href="Assets/style/public_diet2.css">
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
        <div class="diet-section">
            <h2>Cat Diet and Nutrition Guide</h2>
            <img src="Assets/images/catdiet.jpg" alt="Cat Diet" style="display: block; margin: 0 auto; max-width: 100%;" />

            <p>Providing the right nutrition is crucial for the health and happiness of your feline friend. A balanced diet supports overall well-being and helps prevent health issues.</p>

            <h3 style="color: blue;">Importance of Nutrition at Every Stage of Growth</h3>
            <p>Understanding your cat's nutritional needs at different life stages is essential:</p>
            <ul>
                <li><strong>Kittenhood:</strong> Kittens require a diet rich in protein, fat, vitamins, and minerals to support growth and development. Feed them specialized kitten food multiple times a day.</li>
                <li><strong>Adulthood:</strong> Adult cats need a balanced diet to maintain optimal weight and energy levels. Choose high-quality cat food formulated for adult cats.</li>
                <li><strong>Senior Cats:</strong> Older cats may benefit from diets lower in calories but rich in nutrients like joint-supporting compounds and antioxidants. Adjust their diet based on activity level and health conditions.</li>
            </ul>

            <h3 style="color: blue;">Essential Nutrients for Cats</h3>
            <p>Cats require specific nutrients for optimal health:</p>
            <ul>
                <li>Protein: Vital for muscle growth and repair.</li>
                <li>Fats: Provide energy and support skin and coat health.</li>
                <li>Carbohydrates: Offer energy and aid in digestion.</li>
                <li>Vitamins and Minerals: Essential for various metabolic functions.</li>
                <li>Taurine: Crucial for heart and eye health in cats.</li>
                <li>Water: Ensure your cat stays hydrated with fresh water available at all times.</li>
            </ul>

            <h3 style="color: blue;">Feeding Guidelines</h3>
            <p>Follow these guidelines to ensure your cat's diet is balanced and nutritious:</p>
            <ul>
                <li>Provide a diet suitable for your cat's age, weight, and activity level.</li>
                <li>Offer high-quality commercial cat food or balanced homemade meals approved by a veterinarian.</li>
                <li>Feed your cat at regular intervals, typically twice a day for adult cats.</li>
                <li>Ensure clean, fresh water is always accessible.</li>
                <li>Avoid overfeeding and monitor your cat's body condition regularly.</li>
            </ul>

            <h3 style="color: blue;">Foods to Avoid</h3>
            <p>Some foods can be harmful or toxic to cats:</p>
            <ul>
                <li>Chocolate</li>
                <li>Grapes and raisins</li>
                <li>Onions and garlic</li>
                <li>Alcohol</li>
                <li>Caffeine</li>
                <li>Lilies (highly toxic to cats)</li>
                <li>Xylitol (found in sugar-free products)</li>
            </ul>

            <h3 style="color: blue;">Special Dietary Needs</h3>
            <p>If your cat has specific health conditions or dietary requirements, consult with your veterinarian for personalized advice and dietary recommendations.</p>

            <h3 style="color: blue;">How to Transition Your Cat's Diet</h3>
            <p>When changing your cat's diet, do so gradually over several days to avoid digestive upset. Mix small amounts of the new food with the old food, increasing the proportion of the new food gradually until the transition is complete.</p>
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