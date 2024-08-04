<?php
session_start();
//DATABASE CONNECTION FILE
include("../conn.inc.php");
date_default_timezone_set('Asia/Calcutta'); 
$date = date('Y-m-d')."T".date("H:i:s");
//$username=$_SESSION['username'];

$data1 = file_get_contents("php://input");
$data = json_decode($data1, true);
$expl_data=explode(',',$data );
$return_messages=[];
$user_id=$expl_data[0];
$operation_type=$expl_data[1];
$status=false;
$message='';

if($operation_type=='approve')
{
	$query_approve_public= "UPDATE `public_register` SET `Approved` = 1 WHERE `User_Id` = '$user_id'";		
	$run_approve_public = mysqli_query($success_connect, $query_approve_public);
			if($run_approve_public){
				//UPDATE Dotor_register table success
				$status		=	true;
				$message	=	"User with ID $user_id Approved";		
			}
			else{
				//UPDATE Dotor_register table failed.
				$status		=	false;
				$message	=	"Error in Approval, please try again!!";

			}

	$return_messages['status']			=	$status;
	$return_messages['message']			=	$message;
	$return_messages_json=json_encode($return_messages);
	echo $return_messages_json;			
}
else if($operation_type=='reject')
{
	$query_reject_public= "UPDATE `public_register` SET `Approved` = 0 WHERE `User_Id` = '$user_id'";		
	$run_reject_public = mysqli_query($success_connect, $query_reject_public);
			if($run_reject_public){
				//UPDATE Dotor_register table success
				$status		=	true;
				$message	=	"User with ID $user_id Rejected";		
			}
			else{
				//UPDATE Dotor_register table failed.
				$status		=	false;
				$message	=	"Error in Rejected, please try again!!";

			}

	$return_messages['status']			=	$status;
	$return_messages['message']			=	$message;
	$return_messages_json=json_encode($return_messages);
	echo $return_messages_json;
}
else if($operation_type=='remove')
{
	
}
//echo json_encode($return_messages);
?>