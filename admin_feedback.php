<?php
session_start();
require 'conn.inc.php';
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
    if($acc_type=='admin')
        {     
            $fetch_feedback_query = "SELECT * FROM `feedback`";
            //echo $admin_details_query;
            $fetch_feedback_run  = @mysqli_query($success_connect,$fetch_feedback_query);
            $fetch_feedback__rows = @mysqli_num_rows($fetch_feedback_run);
            if($fetch_feedback__rows>=1){

            }

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
    <link rel="stylesheet" href="Assets/style/admin_feedback.css">
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
            <li><a href="admin_home">Home</a></li>
            <li><a href="admin_Public">Public</a></li>
            <li><a href="admin_admin">Admin</a></li>
            <li><a href="admin_doctor">Doctor</a></li>
            <li><a href="admin_staff">staff</a></li>

            <li><a href="admin_feedback">Feedback</a></li>
            <li><a href="admin_my_account">My Account</a></li>
            <li><a href="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li> <!-- Added logout icon -->
        </ul>
    </nav>

    <!-- Content Here -->
    <h1>View Feedback </h1>
    <table>
        <thead>
            <tr>
                <tr>
                    <th>Sl</th>
                    <th>Feedback ID</th>
                    <th>User Id</th>
                    <th>Pet Id</th>
                    <th>Doctor Id</th>
                    <th>Comment</th>
                    <th>Rating</th>
                    

                </tr>
            </tr>
        </thead>
        <tbody>
            <?php 
                if($fetch_feedback__rows >= 0)
                {   
                    $slno=1;
                    foreach ( $fetch_feedback_run as $var ) {
                        echo "<tr id=\"feedback_row".$slno."\" >
                                    <td>".$slno."</td>
                                    <td>".$var['sl_no']."</td>
                                    <td>".$var['user_id']."</td>
                                    <td>".$var['Pet_Id']."</td>
                                    <td>".$var['Doctor_Id']."</td>
                                    <td style=\"width:600px;\">".$var['Comment']."</td>
                                    <td>".$var['Rating']."</td>
                                </tr>";
                          $slno++; 
                    }
                }
            ?>            
        </tbody>
    </table>


    <script>
    
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