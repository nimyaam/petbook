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
    if($acc_type=='admin')
        {     
            include("conn.inc.php");
            date_default_timezone_set('Asia/Calcutta'); 
            $date = date('Y-m-d')."T".date("H:i:s");

             $public_reg_details_query = "SELECT * FROM `public_register`";
             $public_reg_details__sql  = @mysqli_query($success_connect,$public_reg_details_query);
             $public_reg_details__rows = @mysqli_num_rows($public_reg_details__sql);
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
    <link rel="stylesheet" href="Assets/style/admin_public.css">
    <script src="Assets/JS/admin_Public.js"></script>
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


<h1>List of Registered Admins</h1>

<table>
    <thead>
        <tr>
            <tr>
                <th>Sl</th>
                <th>User ID</th>
                <th>Name</th>
                <th>DOB</th>
                <th>Email</th>
                <th>Phone_number</th>
                <th>Date</th>
                <th>Photo</th>
                <th>Approved</th>

            </tr>
        </tr>
    </thead>
    <tbody>
         <?php 
                if($public_reg_details__rows >= 0)
                {   
                    $slno=1;
                    foreach ( $public_reg_details__sql as $var ) {
                       if($var['type']=='admin')
                       { 
                            if($var['Photo']!='')
                                $img_dsply="<img src=\"".$var['Photo']."\" alt=\"Profile Pic\" width=\"\" height=\"60\">";
                            else
                                $img_dsply="No Image";

                            if($var['Approved']==1){
                                    $approve_status="<span class=\"remove-link\" onclick=\"removePublic('reject','".$var['User_Id']."','row".$slno."')\">Reject</span>";
                                    $bg_color="#96DBC2";
                            }
                            else{
                                $approve_status="<span class=\"remove-link\" onclick=\"removePublic('approve','".$var['User_Id']."','row".$slno."')\" style=\"color:Green;\">Approve</span>";
                                $bg_color="";                
                            }

                            echo "<tr id=\"row".$slno."\" style=\"background-color: ".$bg_color.";\">
                                    <td>".$slno."</td>
                                    <td>".$var['User_Id']."</td>
                                    <td>".$var['name']."</td>
                                    <td>".$var['DOB']."</td>
                                    <td>".$var['Email']."</td>
                                    <td>".$var['Phone_Number']."</td>
                                    <td>".$var['created time']."</td>
                                    <td>".$img_dsply."</td>
                                    <td>".$approve_status."</td>

                                    </tr>";
                          $slno++; 
                      }         
                    }
                 }else{
                    echo "<td colspan=\"13\">No data found</td>";
                    
                 }
                    
            ?>
        <!-- Add more rows for other public members -->
    </tbody>
</table>

<script>
    function removeMember(name) {
        if (confirm(`Are you sure you want to remove ${name}?`)) {
            // Remove the member from the list or perform any other action
            alert(`${name} removed successfully!`);
        }
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
