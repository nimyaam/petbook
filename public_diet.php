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
    <link rel="stylesheet" href="Assets/style/public_diet.css">
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
            <li><a href="public_pet_healthcare1">Home</a></li>
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

<h2 text align="center">Dog Diet and Nutrition Advice</h2>
<img src="Assets/images/diet2.jpg" alt="Dog Diet" style="display: block; margin: 0 auto; max-width: 100%;" />

           <br> <p>Proper nutrition is essential for the health and wellbeing of your dog. A balanced diet ensures that your dog receives the necessary nutrients to maintain energy levels, support growth, and prevent health issues.</p>

            <h3 style="color: blue;">Importance of Nutrition at Every Stage of Growth</h3>
            <p>Nutrition needs vary throughout a dog’s life. Here’s how to support your dog at different stages:</p>
            <ul>
                <li><strong>Puppyhood:</strong> Puppies require high-calorie diets rich in protein and fat to support rapid growth and development. Feed them 3-4 times a day.</li><br><br>
                <li><strong>Adulthood:</strong> Adult dogs need a balanced diet to maintain a healthy weight and energy levels. Meals should be fed twice a day.</li><br><br>
                <li><strong>Senior Dogs:</strong> Older dogs often benefit from diets lower in calories but rich in fiber and joint-supporting nutrients. Adjust feeding to their activity level and health conditions.</li><br><br>
            </ul>

            <h3 style="color: blue;">Essential Nutrients for Dogs</h3>
            <ul>
                <li>Protein: Essential for growth and repair of tissues.</li><br><br>
                <li>Fats: Provide energy and support cell function.</li><br><br>
                <li>Carbohydrates: Supply energy and support digestive health.</li><br><br>
                <li>Vitamins: Necessary for metabolic function.</li><br><br>
                <li>Minerals: Important for bone health and enzymatic processes.</li><br><br>
                <li>Water: Vital for hydration and overall health.</li><br><br>
            </ul>

            <h3 style="color: blue;">Feeding Guidelines</h3>
            <p>Follow these guidelines to ensure your dog’s diet is balanced and nutritious:</p>
            <ul>
                <li>Provide a diet appropriate for your dog's age, size, and activity level.</li> <br><br>
                <li>Offer high-quality commercial dog food or balanced homemade meals.</li><br><br>
                <li>Feed your dog at regular intervals, usually twice a day.</li><br><br>
                <li>Ensure fresh water is always available.</li><br><br>
                <li>Limit treats to no more than 10% of daily caloric intake.</li><br><br>
            </ul>

            <h3 style="color: blue;">Foods to Avoid</h3>
            <p>Certain foods can be harmful or toxic to dogs. Avoid feeding your dog the following:</p>
            <ul>
                <li>Chocolate</li><br><br>
                <li>Grapes and raisins</li><br><br>
                <li>Onions and garlic</li><br><br>
                <li>Alcohol</li><br><br>
                <li>Caffeine</li><br><br>
                <li>Macadamia nuts</li><br><br>
                <li>Xylitol (found in sugar-free products)</li><br><br>
            </ul>

            <h3 style="color: blue;">Special Dietary Needs</h3>
            <p>If your dog has specific health conditions or dietary needs, consult with your veterinarian for tailored advice. Common issues include allergies, obesity, and chronic conditions like diabetes or kidney disease.</p>

            <h3 style="color: blue;">How to Diet Your Dog</h3>
            <p>When planning your dog’s diet, consider their individual needs and lifestyle. Gradually transition between foods to avoid digestive upset. Monitor their weight and adjust portions accordingly. Regular veterinary check-ups can help ensure your dog’s diet supports their health.</p>
            <br><br>
            
            <p>Maintaining a balanced diet is crucial for your dog's health and happiness. Always consult with your veterinarian before making significant changes to your dog's diet to ensure their specific needs are met.</p>
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