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


             $doctor_reg_details_query = "SELECT * FROM `doctor_register`";
             $doctor_reg_details__sql  = @mysqli_query($success_connect,$doctor_reg_details_query);
             $doctor_reg_details__rows = @mysqli_num_rows($doctor_reg_details__sql);

             $doctor_details_data=array();
             $i=0;
             $j=0;
             foreach ( $doctor_reg_details__sql as $var ) {
                $doctor_details_data[$i]=array();
                $doctor_details_data[$i]['sl']              =$var['sl'];
                $doctor_details_data[$i]['Doctor_ID']       =$var['Doctor_ID'];
                $doctor_details_data[$i]['Doctor_Name']     =$var['Doctor_Name'];
                $doctor_details_data[$i]['Qualification']   =$var['Qualification'];
                $doctor_details_data[$i]['Hospital_Name']   =$var['Hospital_Name'];
                $doctor_details_data[$i]['Photo']           =$var['Photo'];

                $i++;
             }


?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK</title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="Assets/style/public_chatting_page.css">
    <script>
        let doctor_details_data         = <?php echo json_encode($doctor_details_data);?>;
        let doctor_reg_details__rows    =<?php echo $doctor_reg_details__rows;?>;
        let user_id                     = <?php echo json_encode($User_Id);?>;
        let universal_doctor_id         =null;    
        
    </script>

    <style>
     
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="sidebar" id="sidebar">
            <div class="menu-bar" onclick="toggleSidebar()"><i class="fas fa-bars"></i></div>
           
            <ul class="menu">
                <li class="active" onclick="goToHomePage()"><i class="fas fa-home"></i>Home</li>
                <li onclick="goToServicesPage()"><i class="fas fa-concierge-bell"></i>Services</li>
                <li onclick="goToMedicalRecordsPage()"><i class="fas fa-notes-medical"></i>Medical Records</li>
                <li onclick="goToFeedbackPage()"><i class="fas fa-comment-dots"></i>Feedback</li>
                <li onclick="logout()"><i class="fas fa-sign-out-alt"></i>Logout</li>
            </ul>
        </div>
        <div class="chat">
            <div class="chat-header">
                
                <input type="text" placeholder="Search">
            </div>
            <div class="chat-list">
                <?php

                if($doctor_reg_details__rows)
                 {
                    
                    foreach ( $doctor_reg_details__sql as $var ) {

                        if($var['Approved']){
                            $profil_pic="";
                            
                            if($var['Photo']==''){
                               $profil_pic="Assets/images/No_image_available.svg.png"; 
                            }
                            else{
                                $profil_pic=$var['Photo'];
                            }
                            ?>
                            <div class="chat-item" onclick="openChat(<?php echo $var['sl']; ?>)">
                                <img src="<?php echo $profil_pic; ?>" alt="User Picture" onerror="this.onerror=null;this.src='Assets/images/No_image_available.svg.png';">
                                <div class="chat-info">
                                    <h4><?php echo $var['Doctor_Name'] ?></h4>
                                    <!--<p>The quick brown fox jumps over the lazy dog...</p>-->
                                </div>
                            </div>
                            <?php
                        }
                    }

                 }
                 else{

                 }   

                ?>


               <!-- <div class="chat-item" onclick="openChat(1)">
                    <img src="Assets/images/charlie67.jpg" alt="User Picture" onerror="this.onerror=null;this.src='default.jpg';">
                    <div class="chat-info">
                        <h4>Camille</h4>
                        <p>The quick brown fox jumps over the lazy dog...</p>
                    </div>
                    <span class="chat-time">15 Mar</span>
                </div>
                <div class="chat-item" onclick="openChat(2)">
                    <img src="Assets/images/dr.jpg" alt="User Picture" onerror="this.onerror=null;this.src='default.jpg';">
                    <div class="chat-info">
                        <h4>Lowey Gray</h4>
                        <p>Ready participant...</p>
                    </div>
                    <span class="chat-time">12 Mar</span>
                </div>-->
                <!-- Add more chat items here -->
            </div>
        </div>
        <div class="chat-window" id="chat-window-1">
            <div class="chat-header">
                
            </div>
            <div class="chat-content" id="chat_content">
                <!--<div class="message">
                    <p>Your very own custom mobile business card...</p>
                </div>
                <div class="message reply">
                    <p>I'm always keen on the <b>Top 3%...</b></p>
                </div>-->
                <!-- Add more messages here -->
            </div>
            <div class="chat-input">
                <input type="text" id="chat_msg_type" placeholder="Type a message...">
                <button onclick="chatMessageSener()">Send</button>
                
                
            </div>
        </div>
        <div class="chat-window" id="chat-window-2">
            <div class="chat-header">
              
            </div>
            <div class="chat-content">
                <div class="message">
                </div>
                <!-- Add more messages here -->
            </div>
            <div class="chat-input">
                <input type="text" id="chat_msg_type" placeholder="Type a message...">
                <button>Send</button>
                
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('expanded');
        }

        function goToHomePage() {
            // Replace 'home.html' with the actual home page URL
            window.location.href = 'public_home';
        }

        function goToServicesPage() {
            // Replace 'services.html' with the actual services page URL
            window.location.href = 'public_service';
        }

        function goToMedicalRecordsPage() {
            // Replace 'medical_records.html' with the actual medical records page URL
            window.location.href = 'public_medicalrecord';
        }

        function goToFeedbackPage() {
            // Replace 'feedback.html' with the actual feedback page URL
            window.location.href = 'public_feedback';
        }

        function logout() {
            // Add logout functionality here, like clearing session or redirecting to login page
            window.location.href = 'logout';
        }

        function updateProfilePicture() {
            var input = document.getElementById('profile-input');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profile-picture').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function openChat(doctorSL) {
           /* var chatWindows = document.getElementsByClassName('chat-window');
            for (var i = 0; i < chatWindows.length; i++) {
                console.log(doctor_details_data);
                chatWindows[i].classList.remove('active');
            }
            */
            document.getElementById('chat-window-1').classList.add('active');
            //console.log(doctor_details_data);
            //console.log(doctor_reg_details__rows);
            //console.log(doctorSL);
            var Doctor_Name     ='';
            var Qualification   ='';
            var profile_image   ='Assets/images/No_image_available.svg.png';
            var doctor_id='';
            for(i=0;i<doctor_reg_details__rows;i++)
            {
                if(doctor_details_data[i]['sl']==doctorSL)
                {
                    var Doctor_Name     =doctor_details_data[i]['Doctor_Name'];
                    var Qualification   =doctor_details_data[i]['Qualification'];
                    var doctor_id        =doctor_details_data[i]['Doctor_ID'];
                    if(doctor_details_data[i]['Photo']!='')
                        var profile_image=doctor_details_data[i]['Photo'];

                }
            }
            document.getElementById('chatNameShow').innerHTML="<img src=\""+profile_image+"\" alt=\"Profile Picture\" style=\"width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;\">" +Doctor_Name;

           // var profile_image=
            check_mesg(doctor_id);
            universal_doctor_id=doctor_id;
          //  alert(universal_doctor_id);
        }
    var univer_msg_counter=1;     
    function check_mesg(doctor_id)
    {
      let database_response         ='';  
      let database_response_status  = '';
      let database_response_no_of_msg = '';
      let database_response_content='';

      var chatContent = document.getElementById('chat_content');
     // chatContent.innerHTML='';
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "DB/user_chat.php");
      xhr.setRequestHeader("Accept", "application/json");
      xhr.setRequestHeader("Content-Type", "application/json");

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
         // console.log(xhr.status);
          //console.log(xhr.responseText);
          database_response = JSON.parse(xhr.responseText);
          //database_response = xhr.responseText;

          database_response_status      = database_response["status"];
          database_response_no_of_msg   = database_response["no_of_msg"] ;
          database_response_content     = JSON.parse(database_response["content"]);
         if(database_response_status){

            //console.log(database_response);
           // console.log(database_response_content);
            if(database_response_no_of_msg>0)
            {
                var changeContent="";
                var msg_counter=0;
                database_response_content.forEach(function(msg){
                    msg_counter++;
                    if((msg['sender'])==user_id)
                    {
                     changeContent=changeContent+"<div class=\"message reply\" id=\"msg"+msg_counter+"\"><p>"+msg['msg']+"<span style=\"font-size: 9px;text-align: right; float: right; padding-top: 2%;\">"+msg['time_stamp']+" </span></p></div>";
                     //   chatContent.innerHTML=chatContent.innerHTML+"<div class=\"message reply\"><p>"+msg['msg']+"<span style=\"font-size: 9px;text-align: right; float: right; padding-top: 2%;\">"+msg['time_stamp']+" </span></p></div>";
                    }
                    else if((msg['sender'])==doctor_id){
                         changeContent=changeContent+"<div class=\"message\" id=\"msg"+msg_counter+"\"><p>"+msg['msg']+"<span style=\"font-size: 9px;text-align: right; float: right; padding-top: 2%;\">"+msg['time_stamp']+" </span></p></div>";
                        //chatContent.innerHTML=chatContent.innerHTML+"<div class=\"message\"><p>"+msg['msg']+"<span style=\"font-size: 9px;text-align: right; float: right; padding-top: 2%;\">"+msg['time_stamp']+" </span></p></div>";
                    }
                    //console.log(msg['receiver']);

                });

                if(univer_msg_counter!=msg_counter)
                   {
                    chatContent.innerHTML='';
                    chatContent.innerHTML=changeContent; 
                    }
               univer_msg_counter=msg_counter;

            }else{

                chatContent.innerHTML=chatContent.innerHTML+"<p>Start your conversation!</p>";

            }
            


         }
         else{
            alert("Some error happens please try later!");
         }  
      }};   

      let data      = doctor_id+`,`+user_id;
      let json_data=JSON.stringify(data);

      xhr.send(json_data);

      //console.log(database_response);
      //console.log(database_response_content);
      setTimeout(function() {check_mesg(universal_doctor_id); }, 5000);

    } 
    function chatMessageSener(){


        const currentDate = new Date();
        const yyyy = currentDate.getFullYear();
        let mm = currentDate.getMonth() + 1; // Months start at 0!
        let dd = currentDate.getDate();
        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;
        let hh=currentDate.getHours();
        let min=currentDate.getMinutes();
        let ss=currentDate.getSeconds();
        if (hh < 10) dd = '0' + hh;
        if (min < 10) min = '0' + min;
        if (ss < 10) dd = '0' + ss;
        
        const formattedToday = yyyy + '-' + mm + '-' + dd + ' ' + hh + ':' + min + ':'+ ss;
        const timestamp = currentDate. getTime();
        var chatContent = document.getElementById('chat_content');
        var message = document.getElementById('chat_msg_type').value;

        if(message=='')
        {
           // alert("No message entered!");
            return;
        }
        chatContent.innerHTML=chatContent.innerHTML+"<div class=\"message reply\"><p>"+message+"<span style=\"font-size: 9px;text-align: right; float: right; padding-top: 2%;\">"+formattedToday+" </span></p></div>";
       // alert(currentDate);

          let database_response         ='';  
          let database_response_status  = '';
          let database_response_message = '';

          let xhr = new XMLHttpRequest();
          xhr.open("POST", "DB/chat_msg_db_entry.php");
          xhr.setRequestHeader("Accept", "application/json");
          xhr.setRequestHeader("Content-Type", "application/json");

          xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
              console.log(xhr.status);
              console.log(xhr.responseText);
              database_response = JSON.parse(xhr.responseText);
              //database_response = xhr.responseText;

              database_response_status  = database_response["status"];
              database_response_message  = database_response["message"] ;
             if(database_response_status){

                
             }
             else{
                alert("Some Error happen Please try later");
             }  
          }};   

          let data = universal_doctor_id+`,`+user_id+','+message+','+formattedToday;
          let json_data=JSON.stringify(data);

          xhr.send(json_data);

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