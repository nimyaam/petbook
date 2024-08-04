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
    <link rel="stylesheet" href="Assets/style/public_symptom.css">
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

    <!-- Content Here -->
    
    <h2 style="color: blue;">Babesiosis in Dogs</h2>
    <div class="content">
        <img src="Assets/images/disease1.jpg" alt="Babesiosis Disease">
        <div class="symptoms">
            <h3><u>Symptoms</u></h3>
            <ul>
                <li>Lethargy</li>
                <li>Fever</li>
                <li>Anemia</li>
                <li>Pale mucous membranes</li>
                <li>Swollen lymph nodes</li>
                <li>Dark, red, or brown-colored urine</li>
                <li>Weakness</li>
                <li>Enlarged spleen</li>
            </ul>
        </div>
    </div>

    <p>
        Babesia is a protozoal parasite that is transmitted to the bloodstream of dogs through the bite of an infected tick. The tick species that most frequently carry Babesia are found more prominently in the southern United States, so while Babesia can be found throughout the country, dogs in southern states are more commonly affected. All dog breeds can contract Babesia but racing Greyhounds and Pit Bull Terriers have historically been most affected.
        <br>
        When an infected tick bites a dog, this allows the Babesia organism to pass into the bloodstream. Once in the bloodstream, the organism will invade the dog’s red blood cells. Once in the red blood cells, the immune system will try to fight off the Babesia by destroying the infected cells. In some instances, the immune system may overreact, which will lead to the destruction of infected red blood cells, as well as uninfected blood cells.
    </p>

    <h3><u>How to Prevent Babesiosis in Dogs</u></h3>
    <p>
        The number one way to prevent Babesia infection in your pet is with tick control! There are many products to protect your dog from tick bites including topical or oral products. Please discuss these options with your veterinarian or our vets at FirstVet to determine what product may be best for you and your pet.
        <br>
        Also, a tick needs to feed for 2-3 days to pass Babesia to your dog so checking your dog for ticks daily, especially after walks through the woods or tall grass is very beneficial.
        <br>
        If you’re concerned your dog may have had prolonged exposure to ticks or is exhibiting any of the symptoms above, it is important to contact your vet immediately.
    </p>

    
    <h2 style="color: blue;">Ehrlichiosis in Dogs</h2>
    <div class="content">
        <img src="Assets/images/dise2.jpg" alt=" Ehrlichiosis Disease">
        <div class="signs">
            <p>Ehrlichiosis is caused by a bacteria called Ehrlichia, which is spread to dogs through the bite of a tick. Brown dog ticks are the most common tick to spread Ehrlichiosis, although it has been spread by the lone star tick, deer tick, and American dog tick. All dog breeds can be infected with Ehrlichia but not every infected dog will become seriously ill from the disease.</p>

            <h3><u>Signs of disease in dogs</u></h3>
            <ul>
                <li>Ehrlichiosis is a serious disease that can cause
                    life-threatening complications.</li>
                <li>Dogs develop clinical signs 1-3 weeks after the
                    bite of an infected tick. </li>
                <li>Clients may report new onset of lethargy,
                    inappetence, and lameness. 
                    </li>
                <li>Dogs may have a fever, joint pain, evidence of
                    bleeding, anemia, thrombocytopenia, or uveitis</li>
                
            </ul>
        </div>
    </div>
    <h2 style="color: blue;">Colitis in Dogs</h2>

    <div class="content">
        <img src="Assets/images/diss.jpg" alt=" Colitis Disease">
        <div class="signs">
<p>Colitis in dogs means that the patient is suffering from inflammation of the large intestine (colon). Many dogs will suffer from colitis at one stage in their lives and this is also a common puppy problem. There are some characteristic symptoms of colitis and it can be a condition which appears suddenly and resolves quickly (acute) or, for some pets, this can be an ongoing issue, which takes some time to resolve (chronic)</p>
            <h3><u>Signs of disease in dogs</u></h3>
            <ul>
                <li>Frequent, small bouts of runny stools</li>
                <li>Diarrhea</li>
                <li>Obvious pain or strain during defecation</li>
                <li>Traces of red blood in stools</li>
                <li>A sense of urgency</li>
                <li>Vomiting (though this is not as common)</li>
                <li>Mucus or fat in fecal matter (this is more likely in a chronic case)</li>
                
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