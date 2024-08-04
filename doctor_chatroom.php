<?php
session_start();
include("conn.inc.php");
date_default_timezone_set('Asia/Calcutta'); 
$date = date('Y-m-d')."T".date("H:i:s");

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
            $doctor_id=$User_Id;
            $chat_user_list=array();
            $chat_user_list_details=array();
            $query= "SELECT * FROM `chat_table` WHERE `sender`='".$doctor_id."' OR `receiver`='".$doctor_id."'";
            if ($query_run= mysqli_query($success_connect,$query))
             {
                $query__row_count= mysqli_num_rows($query_run);
                $i=1;
                foreach ( $query_run as $var ) {
                    if($var['sender']==$doctor_id)
                        $chat_user_list[$i]=$var['receiver'];
                    else if($var['receiver']==$doctor_id)    
                        $chat_user_list[$i]=$var['sender'];
                    $i++;
                }

               $chat_user_list_final=array_unique($chat_user_list) ;
               $j=0;   
               foreach ( $chat_user_list_final as $loop_user_id ) {
                 
                 $query= "SELECT * FROM `public_register` WHERE `User_Id`='".$loop_user_id."'";

                // echo $query;
                 $query_run= mysqli_query($success_connect,$query);
                 $query__row_count= mysqli_num_rows($query_run);
                 if($query__row_count){
                    foreach ( $query_run as $var ) {
                        $chat_user_list_details[$j]['User_Id']  =$var['User_Id'];
                        $chat_user_list_details[$j]['name']     =$var['name'];
                        $chat_user_list_details[$j]['Email']    =$var['Email'];
                        $chat_user_list_details[$j]['Photo']    =$var['Photo'];
                    }
                 }
                 $j++;
               }
               //print_r($chat_user_list_final) ;
               $chat_user_count=$j;
              // print_r($chat_user_list_details) ;
             }       

?>
<!DOCTYPE html>
<script>
        let chat_user_list_details          = <?php echo json_encode($chat_user_list_details);?>;
        let chat_user_count                 =<?php echo $chat_user_count;?>;
        let user_id                         = <?php echo json_encode($User_Id);?>;
        let universal_chat_user_id          =null;    
        
</script>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK</title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .chat-container {
            display: flex;
            width: 100%;
        }

        .sidebar {
            width: 0;
            background-color: #3b3f58;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            overflow: hidden;
            transition: width 0.3s;
        }

        .sidebar.expanded {
            width: 250px;
        }

        .sidebar .profile {
            display: none;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar.expanded .profile {
            display: block;
        }

        .profile-picture {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .menu-bar {
            width: 100%;
            text-align: center;
            cursor: pointer;
            background-color: #555977;
            padding: 10px 0;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .menu {
            list-style: none;
            padding: 0;
            width: 100%;
            display: none;
        }

        .sidebar.expanded .menu {
            display: block;
        }

        .menu li {
            padding: 15px;
            cursor: pointer;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu li:hover, .menu li.active {
            background-color: #555977;
        }

        .menu li i {
            margin-right: 10px;
        }

        .chat {
            flex: 0 0 300px;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header input {
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }

        .chat-list {
            flex: 1;
            overflow-y: auto;
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 15px;
            cursor: pointer;
            border-bottom: 1px solid #ddd;
        }

        .chat-item:hover, .chat-item.active {
            background-color: #f4f4f4;
        }

        .chat-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-info {
            flex: 1;
        }

        .chat-time {
            font-size: 0.8em;
            color: #999;
        }

        .chat-window {
            flex: 1;
            display: flex;
            flex-direction: column;
            display: none;
        }

        .chat-window.active {
            display: flex;
        }

        .chat-window .chat-header {
            padding: 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f9f9f9;
        }


        .message {
            margin-bottom: 20px;
        }

        .message p {
            background: #ececec;
            padding: 15px;
            border-radius: 10px;
            max-width: 70%;
        }

        .message.reply p {
            background: #0084ff;
            color: #fff;
            margin-left: auto;
        }

        .chat-input {
            display: flex;
            border-top: 1px solid #ddd;
            padding: 20px;
            align-items: center;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }

        .chat-input button, .chat-input .pin-button, .chat-input .emoji-button {
            background-color: #0084ff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            margin-left: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .chat-input button:hover, .chat-input .pin-button:hover, .chat-input .emoji-button:hover {
            background-color: #0073e6;
        }

        .chat-input .pin-button, .chat-input .emoji-button {
            padding: 10px;
            border-radius: 50%;
        }

        .file-input {
            display: none;
        }
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
                
                if($chat_user_count>0)
                 {
                    
                    foreach ( $chat_user_list_details as $var ) {

                        
                            $profil_pic="";
                            
                            if($var['Photo']==''){
                               $profil_pic="Assets/images/No_image_available.svg.png"; 
                            }
                            else{
                                $profil_pic=$var['Photo'];
                            }
                            ?>
                            <div class="chat-item" onclick="openChat('<?php echo $var['User_Id']; ?>')">
                                <img src="<?php echo $profil_pic; ?>" alt="User Picture" onerror="this.onerror=null;this.src='Assets/images/No_image_available.svg.png';">
                                <div class="chat-info">
                                    <h4><?php echo $var['name'] ?></h4>
                                    <!--<p>The quick brown fox jumps over the lazy dog...</p>-->
                                </div>
                                <span class="chat-time">15 Mar</span>
                            </div>
                            <?php
                       
                    }

                 }
                 else{

                 } ?>


                <!--<div class="chat-item" onclick="openChat(1)">
                    <img src="user1.jpg" alt="User Picture" onerror="this.onerror=null;this.src='default.jpg';">
                    <div class="chat-info">
                        <h4>Camille</h4>
                        <p>The quick brown fox jumps over the lazy dog...</p>
                    </div>
                    <span class="chat-time">15 Mar</span>
                </div>
                <div class="chat-item" onclick="openChat(2)">
                    <img src="user2.jpg" alt="User Picture" onerror="this.onerror=null;this.src='default.jpg';">
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
                <h3 id="chatNameShow"><img src="profile_camille.jpg" alt="Profile Picture" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">Camille</h3>
            </div>
            <div class="chat-content" id="chat_content">
                <div class="message">
                </div>
                <div class="message reply">
                </div>
                <!-- Add more messages here -->
            </div>
            <div class="chat-input">
                <input type="text" id="chat_msg_type" placeholder="Type a message...">
                <button onclick="chatMessageSener()">Send</button>
                <button class="pin-button" onclick="document.getElementById('file-input-1').click()">📎</button>
                <input type="file" id="file-input-1" class="file-input" multiple>
                
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
                <input type="text" placeholder="Type a message...">
                <button>Send</button>
                <button class="pin-button" onclick="document.getElementById('file-input-2').click()">📎</button>
                <input type="file" id="file-input-2" class="file-input" multiple>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('expanded');
        }

        function goToHomePage() {
            // Replace 'home.html' with the actual home page URL
            window.location.href = 'doctor_home';
        }

        function goToServicesPage() {
            // Replace 'services.html' with the actual services page URL
            window.location.href = 'doctor_services';
        }

        function goToMedicalRecordsPage() {
            // Replace 'medical_records.html' with the actual medical records page URL
            window.location.href = 'doctor_medical_record';
        }

        function goToFeedbackPage() {
            // Replace 'feedback.html' with the actual feedback page URL
            window.location.href = 'doctor_feedback';
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

        function openChat(userID) {
            /*var chatWindows = document.getElementsByClassName('chat-window');
            for (var i = 0; i < chatWindows.length; i++) {
                chatWindows[i].classList.remove('active');
            }
            document.getElementById('chat-window-' + chatId).classList.add('active');
            */
            document.getElementById('chat-window-1').classList.add('active');
            //console.log(chat_user_list_details);
            //console.log(chat_user_count);
            var User_Name     ='';
            var profile_image ='Assets/images/No_image_available.svg.png';
            
            for(i=0;i<chat_user_count;i++)
            {
                if(chat_user_list_details[i]['User_Id']==userID)
                {
                    var User_Name       =chat_user_list_details[i]['name'];
                    var Email           =chat_user_list_details[i]['Email'];
                    if(chat_user_list_details[i]['Photo']!='')
                        var profile_image=chat_user_list_details[i]['Photo'];

                }
            }

            document.getElementById('chatNameShow').innerHTML="<img src=\""+profile_image+"\" alt=\"Profile Picture\" style=\"width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;\">" +User_Name;
            check_mesg(userID);
            universal_chat_user_id=userID;
        }

    var univer_msg_counter=1;    
    function check_mesg(doctor_id)
    {
      let database_response         ='';  
      let database_response_status  = '';
      let database_response_no_of_msg = '';
      let database_response_content='';

      var chatContent = document.getElementById('chat_content');
      //chatContent.innerHTML='';
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "DB/user_chat.php");
      xhr.setRequestHeader("Accept", "application/json");
      xhr.setRequestHeader("Content-Type", "application/json");

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          //console.log(xhr.status);
          //console.log(xhr.responseText);
          database_response = JSON.parse(xhr.responseText);
          //database_response = xhr.responseText;

          database_response_status      = database_response["status"];
          database_response_no_of_msg   = database_response["no_of_msg"] ;
          database_response_content     = JSON.parse(database_response["content"]);
         if(database_response_status){

           // console.log(database_response);
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
                        //if(chatContent.innerHTML!=changeContent)
                       // chatContent.innerHTML=chatContent.innerHTML+"<div class=\"message reply\"><p>"+msg['msg']+"<span style=\"font-size: 9px;text-align: right; float: right; padding-top: 2%;\">"+msg['time_stamp']+" </span></p></div>";
                    }
                    else if((msg['sender'])==doctor_id){
                        changeContent=changeContent+"<div class=\"message\" id=\"msg"+msg_counter+"\"><p>"+msg['msg']+"<span style=\"font-size: 9px;text-align: right; float: right; padding-top: 2%;\">"+msg['time_stamp']+" </span></p></div>";
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
      setTimeout(function() {check_mesg(universal_chat_user_id); }, 5000);

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

          let data = universal_chat_user_id+`,`+user_id+','+message+','+formattedToday;
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
