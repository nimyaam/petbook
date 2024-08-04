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
    <link rel="stylesheet" href="Assets/style/public_hygiene.css">
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
        <div class="hygiene-section">
            <img src="Assets/images/hyge.jpg" alt="Dog Diet" style="display: block; margin: 0 auto; max-width: 40%;" /><br>
                     <br><p>We all know how moody dogs can be when it comes to bathing and hygiene routines but we also know how important it is. Your dear fur babies love a little mud therapy but water therapy is what they need.</p>

            <h2 >Tips to keep up with your pet's hygiene routine</h2>

            <p>Here are a few tips to that can help you maintain their hygiene routine while also keeping them happy:</p>

            <h3 style="color: blue;">Bathing tips</h3>
            <ul>
                <li><strong>Find the right product:</strong> Use a nourishing dog shampoo that can gently rehydrate their coat and enhance its shine. While it becomes very difficult to keep your dog interested in bathing, Aroma Groom's wide range of aromatherapy products surely does wonders in keeping your pet interested in the process. The products are made to cater to their heightened sense of smell. With natural ingredients and healing components, these products can soothe their skin, fight fungal infections, control inflammation and even repel ticks. A rejuvenating conditioner should also be added to the bathing routine. It will not only make your dog's coat healthier, it will also make removing tangles a lot easier so that the after-bath brush will beeasy breezy.</li><br><br>
                <li><strong>Clean every spot:</strong> While giving them a bath, make sure that you focus more on the sensitive zones such as behind the ears, paws and under the tail because if not cleaned properly, the water or shampoo residue can lead to rashes and infections. </li>
                <li><strong>Protect the puppy eyes:</strong> Your fur babies need some extra attention and pampering during their bath time. In the process of trying to run away from water, they might jump, which may lead to shampoo getting into their eyes and nose. Hence, it's always advised to avoid applying shampoo on their face.</li><br><br>
                <li><strong>Be gentle:</strong> A scrubber or glove can be used for deep cleansing. Although, make sure that you're super gentle while scrubbing as their coat is sensitive and harsh scrubbing can lead to extra shedding.</li><br><br>
                <li><strong>Use the right towel:</strong> Once cleaned nicely, dry them up properly with a quick absorbent towel.</li><br><br>
            </ul>

            <h3 style="color: blue;">General hygiene tips</h3>
            <ul>
                <li><strong>Dental hygiene:</strong> Brush their teeth from time to time with a doggie toothbrush for better dental hygiene. Other than that, Snackers Dental treats and chews are also an easy and effective way of combating oral issues in the doggos.</li><br><br>
                <li><strong>Coat care:</strong> Dogs with longer hair have a higher tendency of attracting ticks and so it is better to give them regular hair trimming sessions. Additionally, their coat should be brushed regularly as it helps remove loose fur, which means less shedding.</li><br><br>
                <li><strong>Visit the spa regularly:</strong> Moreover, regular spa and grooming sessions play a major role in maintaining a good level of hygiene amongst dogs.</li><br><br>
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