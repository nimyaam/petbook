<?php
session_start();
//echo $_SESSION['User_Id'].",".$_SESSION['name'].",".$_SESSION['Email'].",".$_SESSION['Phone_number'].",".$_SESSION['type'];
if(isset($_SESSION['User_Id']) && isset($_SESSION['name']) && isset($_SESSION['Email'])&& isset($_SESSION['Phone_number'])&& isset($_SESSION['type']))
  {
        
        $User_Id        =$_SESSION['User_Id'];
        $name           =$_SESSION['name'];
        $Email          =$_SESSION['Email'];
        $Phone_number   =$_SESSION['Phone_number'];
        $acc_type       =$_SESSION['type'];
    if($acc_type=='doctor')
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
    <link rel="stylesheet" href="Assets/style/doctor_services.css">
    <style>
     
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
            <span class="logo-text">PETBOOK</span>
        </div>
        <ul>
            <li><a href="doctor_home">Home</a></li>
            <li><a href="doctor_services">Services</a></li>
            <li><a href="doctor_medical_record">Medical Records</a></li>
            <li><a href="doctor_feedback">Feedback</a></li>
            <li><a href="logout" id="login-link">Logout</a></li>
            <!-- Add dark mode / light mode toggle icon -->
            <li><a href="#" id="dark-mode-toggle"><i class="far fa-moon"></i></a></li>
        </ul>
    </nav>

    <div class="content">
        <h1>Our Services</h1>
        <div class="container">
            <div class="box" onclick="location.href='doctor_appointment_consultation';">
                <h2>Appointment</h2>
                <p>Easily schedule pet Consultations click it..</p>
                <div class="underline"></div>
            </div>
            <div class="box" onclick="location.href='doctor_vaccination_page.php';">
                <h2>Reminders</h2>
                <p>Send reminders for pet vaccinations..</p>
                <div class="underline"></div>
            </div>
            
            <div class="box" onclick="location.href='doctor_chatroom';">
                <h2>ChatRoom</h2>
                <p>A virtual space for vets and pet parents to connect and care for furry friends..</p>
                <div class="underline"></div>
            </div>
        </div>
    </div>

    <script>
        // Dark mode / light mode toggle
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        darkModeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
        });
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
