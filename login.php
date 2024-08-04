<?php
session_start();
require 'conn.inc.php';
$loginerr="";
$user_data=array();
if(isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['user_type']))
{
 $user_name=$_POST['email'];
 $password=$_POST['password'];
 $user_type=$_POST['user_type'];
 $password_hash=md5($password);
 $error_flag=false;
 if($user_type=='doctor')
 {
 	if(!empty($user_name)&&!empty($password))
  	{
  		$name_q                 =mysqli_real_escape_string($success_connect,$user_name);
    	$password_hash_q        =mysqli_real_escape_string($success_connect,$password_hash);
    	$query= "SELECT * FROM `doctor_register` WHERE `Doctor_ID`='".$name_q."' AND `password`='".$password_hash_q."' OR `Email`='".$name_q."' AND `password`='".$password_hash_q."' OR `Phone_number`='".$name_q."' AND `password`='".$password_hash_q."'";
    	if ($query_run= mysqli_query($success_connect,$query))
         {
         	$query_num= mysqli_num_rows($query_run);
         	if($query_num ==0)
             {
	         	$loginerr= "Invalid user or password!";
	         	$error_flag=true;
	         	header("Location: index?msg=$loginerr&type=$user_type&flag=$error_flag");
	         }
	        else if($query_num ==1)
             {	
             	while ($row=mysqli_fetch_array($query_run))
                 {
                    $_SESSION['sl']  			=$row['sl'];
                    $_SESSION['User_Id']  		=$row['Doctor_ID'];
                    $_SESSION['name']			=$row['Doctor_Name'];
                    $_SESSION['Address']		=$row['Address'];
                    $_SESSION['Qualification']	=$row['Qualification'];
                    $_SESSION['Licence_Number']	=$row['Licence_Number'];
                    $_SESSION['Experience']		=$row['Experience'];
                    $_SESSION['Specialization']	=$row['Specialization'];
                    $_SESSION['Hospital_Name']	=$row['Hospital_Name'];
                    $_SESSION['Email']      	=$row['Email'];
                    $_SESSION['Phone_number']   =$row['Phone_number'];
                    $_SESSION['Photo']      	=$row['Photo'];
                    $_SESSION['Approved']       =$row['Approved'];
                    $_SESSION['type']   		=$user_type;
                    $_SESSION['Approved']       =$row['Approved'];
                    if($_SESSION['type']=='doctor')
	                  {
	                    	header("Location: doctor_home"); 
	                  }
                 } 

             }
         }
         else{
         	$loginerr= "Failed to fetch databse data.Please try again!";
         	$error_flag=true;
	        header("Location: index?msg=$loginerr&type=$user_type&flag=$error_flag");
         }
  	}
  	else{
         	$loginerr= "Please fill necessary fields!";
         	$error_flag=true;
	        header("Location: index?msg=$loginerr&type=$user_type&flag=$error_flag");
         }

 }
 else if($user_type=='public')
 {
 	if(!empty($user_name)&&!empty($password))
  	{
  		$name_q                 =mysqli_real_escape_string($success_connect,$user_name);
    	$password_hash_q        =mysqli_real_escape_string($success_connect,$password_hash);
    	$query= "SELECT * FROM `public_register` WHERE `User_Id`='".$name_q."' AND `password`='".$password_hash_q."' OR `Email`='".$name_q."' AND `password`='".$password_hash_q."' OR `Phone_Number`='".$name_q."' AND `password`='".$password_hash_q."'";
    	if ($query_run= mysqli_query($success_connect,$query))
         {
         	$query_num= mysqli_num_rows($query_run);
         	if($query_num ==0)
             {
	         	$loginerr= "Invalid user or password!";
	         	$error_flag=true;
	         	header("Location: index?msg=$loginerr&type=$user_type&flag=$error_flag");
	         }
	        else if($query_num ==1)
             {	
             	while ($row=mysqli_fetch_array($query_run))
                 {
                    $_SESSION['User_Id']  		=$row['User_Id'];
                    $_SESSION['name']			=$row['name'];
                    $_SESSION['DOB']			=$row['DOB'];
                    $_SESSION['Email']      	=$row['Email'];
                    $_SESSION['Phone_number']   =$row['Phone_Number'];
                    $_SESSION['type']   		=$row['type'];
                    $_SESSION['Approved']       =$row['Approved'];
                    if($_SESSION['type']=='admin')
	                  {
	                    //echo $_SESSION['User_Id'].",".$_SESSION['name'].",".$_SESSION['Email'].",".$_SESSION['Phone_number'].",".$_SESSION['type'];
	                    	header("Location: admin_home"); 
	                  }
	                else if($_SESSION['type']=='public')
	                  {
	                    	header("Location: public_home"); 
	                  }  
					  else if($_SESSION['type']=='staff')
	                  {
	                    	header("Location: staff_home"); 
	                  }  
                 } 

             }

         }else{
         	$loginerr= "Failed to fetch databse data.Please try again!";
         	$error_flag=true;
	        header("Location: index?msg=$loginerr&type=$user_type&flag=$error_flag");
         }
  	}
  	else{
     	$loginerr= "Please fill necessary fields!";
     	$error_flag=true;
        header("Location: index?msg=$loginerr&type=$user_type&flag=$error_flag");
     }

 }
}
?>