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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:wght@300;400;508;600;700&display=swap">
<link rel="stylesheet" href="Assets/style/doctor_chatting_page.css">
<style>
  
</style>
</head>
<body>

<div class="container">
  <div class="left-side">
    <!-- Menu icon -->
    <i class="fas fa-bars menu-icon"></i>
    <!-- Search bar -->
    <div class="search-bar">
      <input type="text" placeholder="Search..." class="form-control search">
      <button><i class="fas fa-search"></i></button>
    </div>
    <!-- List of chatting friends -->
    <ul class="chat-friends-list">
      <!-- List of chatting friends goes here -->
      <li>
        <img src="Assets/images/lucky.jpg" class="profile-pic">
        <span >Lucky</span>
      </li>
      <li>
        <img src="Assets/images/leo.jpg" class="profile-pic">
        <span>Leo</span>
      </li>
    </ul>
    <!-- Menu list -->
    
  </div>
  <div class="right-side">
    <!-- Right side with conversation header, chat messages, and input group -->
    <div class="conversation-header">
      <img src="Assets/images/lucky.jpg" class="profile-pic">
      <h2>Lucky</h2>
    </div>
    <div class="chat-messages">
      <!-- Chat messages go here -->
    </div>
    <div class="input-group">
      <textarea name="" class="form-control type_msg" placeholder="Type your message..."></textarea>
      <div class="input-group-append">
        <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
      </div>
      <div class="input-group-append">
        <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
      </div>
    </div>
  </div>
</div>
<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    $('.chat-friends-list li').click(function() {
      var name = $(this).find('span').text();
      $('#chat-with').text(name);
      $('.right-side').show();
    });
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
