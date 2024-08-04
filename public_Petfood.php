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
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/public_petfood.css">
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
            color: white;
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
            <li><a href="public_home_petfood">Home</a></li>
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
            <li><a href="logout" id="logout-link">Logout</a></li>
        </ul>
    </nav>

    <div class="pet-food-section">
        <div class="pet-food-category">
            <h2 class="category-title">Dog Best Food</h2>
            <div class="food-box-container" id="dog-food-container">
                <div class="food-box">
                    <img src="Assets/images/dfood1.jpg" alt="Dog Food 1">
                    <p>Pedigree Adult Dry Dog Food (High Protein Variant) Chicken, Egg & Rice, 10kg Pack & All Life Stages Biscrok Dry Dog Biscuits (Above 4 Months), Chicken Flavor, 900g Pack </p>
                    <a href="https://amzn.in/d/9nLxvke" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <!-- Add more dog food boxes here -->
                <div class="food-box">
                    <img src="Assets/images/dfood2.jpg" alt="Dog Food 2">
                    <p>Drools Adult Dry Dog Food Chicken and Egg, 3kg with Free 1.2kg, Total 4.2 kg Pack</p>
                    <a href="https://amzn.in/d/aOq6nHJ" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box">
                    <img src="Assets/images/dfood3.jpg" alt="Dog Food 3">
                    <p>Pedigree Puppy Dry Dog Food, Chicken & Milk, 1.2kg Pack </p>
                    <a href="https://amzn.in/d/2R0KMLu" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box">
                    <img src="Assets/images/dfood4.jpg" alt="Dog Food 4">
                    <p>Drools Focus Adult Super Premium Dry Dog Food , 1.2kg Pack </p>
                    <a href="https://amzn.in/d/2AYJuDK" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box">
                    <img src="Assets/images/dfood5.jpg" alt="Dog Food 5">
                    <p>Chappi Adult Dry Dog Food, Chicken & Rice, 2.8 kg Pack </p>
                    <a href="https://amzn.in/d/3TUw0QS" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box hidden">
                    <img src="Assets/images/dfood6.jpg" alt="Dog Food 6">
                    <p>Canine Creek Puppy Dry Dog Food, Ultra Premium 4kg Pack </p>
                    <a href="https://amzn.in/d/4v8ndFG" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box hidden">
                    <img src="Assets/images/dfood7.jpg" alt="Dog Food 7">
                    <p>Himalaya Healthy Powder Pet Food, Meat & Rice, Adult Dog, 10 Kg (10000 Gram) </p>
                    <a href="https://amzn.in/d/9IEIul4" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box hidden">
                    <img src="Assets/images/dfood8.jpg" alt="Dog Food 8">
                    <p>SmartHeart Adult Dry Dog Food Chicken & Egg Flavour 3 Kg. </p>
                    <a href=" https://amzn.in/d/gsUi2H0" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                
            
            <div class="view-all" onclick="toggleView('dog-food-container')">View All</div>
        </div>


<div class="pet-food-category">
            <h2 class="category-title">Cat Best Food</h2>
            <div class="food-box-container" id="cat-food-container">
                <div class="food-box">
                    <img src="Assets/images/cfood1.jpg" alt="Cat Food 1">
                    <p>Purepet Dry Cat Adult Food Ocean Fish Flavour, 1 kg Pack </p>
                    <a href="https://amzn.in/d/99kDHLn" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <!-- Add more cat food boxes here -->
                <div class="food-box">
                    <img src="Assets/images/cfood2.jpg" alt="Cat Food 2">
                    <p>Whiskas Kitten (2-12 months) Dry Cat Food, Ocean Fish, 450g Pack </p>
                    <a href="https://amzn.in/d/8Z6nZty" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box">
                    <img src="Assets/images/cfood3.jpg" alt="Cat Food 3">
                    <p>Maxi Persian Dry Cat Food, Ocean Fish Flavor 1.2 Kg (Buy 1 Get 1 Free ) Total 2.4 Kg Pack For Adult </p>
                    <a href="https://amzn.in/d/1Qje4UP" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                
                <div class="food-box">
                    <img src="Assets/images/cfood5.jpg" alt="Cat Food 5">
                    <p>Limited-time deal: Meat Up Dry Kitten(1-12 months) Cat Food, Ocean Fish, 1.2kg (Buy 1 Get 1 Free),Total 2.4 Kg Pack </p>
                    <a href="https://amzn.in/d/73ZB0Hc" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box hidden">
                    <img src="Assets/images/cfood6.jpg" alt="Cat Food 6">
                    <p>Limited-time deal: Drools Adult Dry Cat Food, Ocean Fish, 3kg with Free 1.2kg, Tatal 4.2 Kg Pack </p>
                    <a href="https://amzn.in/d/1e7y8cH" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box hidden">
                    <img src="Assets/images/cfood7.jpg" alt="Cat Food 7">
                    <p>Kennel Kitchen Wet Cat Food for Adults and Kittens, Fish Chunks in Gravy, 12 Pouches (12 X 80 GMS) </p>
                    <a href="https://amzn.in/d/87m5PCm" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                
            </div>
            <div class="view-all" onclick="toggleView('cat-food-container')">View All</div>
        </div>

        <div class="pet-food-category">
            <h2 class="category-title">Bird Best Food</h2>
            <div class="food-box-container" id="bird-food-container">
                <div class="food-box">
                    <img src="Assets/images/bfood1.jpg" alt="Bird Food 1">
                    <p>Green view|Premium|Seed Mix for Wild Birds Sparrow|Dove| Pigeon|Ring Neck Parrot|Net Weight 480 GM More Than 10 Different Seed Blend in Perfect Ratio </p>
                    <a href="https://amzn.in/d/hZsOuOv" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <!-- Add more bird food boxes here -->

<div class="food-box">
                    <img src="Assets/images/bfood2.jpg" alt="Bird Food 2">
                    <p>Limited-time deal: Congo® 900gm Mineral Grit for Healthy Bird Digestive System for Conure, Cockatoos, African Grey, Macaw and Other Big Birds (900gm) </p>
                    <a href="https://amzn.in/d/aCrKEYN" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box">
                    <img src="Assets/images/bfood3.jpg" alt="Bird Food 3">
                    <p>Green view|Premium|Seed Mix for Wild Birds Sparrow|Dove| Pigeon|Ring Neck Parrot|Net Weight 480 GM More Than 10 Different Seed Blend in Perfect Ratio </p>
                    <a href="https://amzn.in/d/hZsOuOv" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box">
                    <img src="Assets/images/bfood4.jpg" alt="Bird Food 4">
                    <p>Nutribles Macaw Munch- 450GMS | with 14 Natural Seeds Mix | Surge of Seeds for Macaw Parrot | Supports Mental & Physical Stimulation | Prevents Overgrowth | for Macaws and Other Parrots </p>
                    <a href="https://amzn.in/d/3UPukCD" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box">
                    <img src="Assets/images/bfood5.jpg" alt="Bird Food 5">
<p>RAFOLA Big Parrot Food-Premium Bird Food Granule For Exotic Birds For All Life Stages(1 Kg Bag) Long-Lasting Nourishment And Optimal Health High-Variety Formula Mix Blend </p>
                    <a href="https://amzn.in/d/dp5yNh5" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box hidden">
                    <img src="Assets/images/bfood6.jpg" alt="Bird Food 6">
                    <p>Boltz Bird Food for Budgies - 500gm | Natural & Healthy Premium Mix Seeds, | Daily Bird Budgies Food Seeds| All Life Stages - Mix Seeds (500 GM) </p>
                    <a href="https://amzn.in/d/fAvn10S" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box hidden">
                    <img src="Assets/images/bfood7.jpg" alt="Bird Food 7">
                    <p>PETSLIFE Hand Feeding Formula for Baby Birds, 250g </p>
                    <a href="https://amzn.in/d/2yvPzmK" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                <div class="food-box hidden">
                    <img src="Assets/images/bfood8.jpg" alt="Bird Food 8">
<p>Boltz Parrot Food 1Kg for Big Parrot,African Grey Parrot,Sun Conure,Macaw,Lovebird and Alexander - All Life Stages Mix Seeds,1 Kg </p>
                    <a href="https://amzn.in/d/ayN3lbn" target="_blank" class="amazon-button">Buy on Amazon</a>
                </div>
                
            </div>
            <div class="view-all" onclick="toggleView('bird-food-container')">View All</div>
        </div>
    </div>

    <script>
        function toggleView(containerId) {
            const container = document.getElementById(containerId);
            const hiddenItems = container.querySelectorAll('.hidden');
            hiddenItems.forEach(item => {
                item.classList.toggle('hidden');
            });
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