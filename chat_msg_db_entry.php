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
$status=false;
$messages='';



$doctor_id		=$expl_data[0];
$user_id		=$expl_data[1];
$chat_message	=$expl_data[2];
$time			=$expl_data[3];


$enter_chat_message_query="INSERT INTO `chat_table` (`sl`, `sender`,`sender_type`,`receiver`,`receiver_type`,`msg`,`time_stamp`,`read_status`,`msg_type`) VALUES (' ' , '$user_id','public_register','$doctor_id','doctor_register','$chat_message','$time','not_read','text')";
$enter_chat_message_query_run  =mysqli_query($success_connect, $enter_chat_message_query);

if($enter_chat_message_query_run)
{
	$status=true;	
	$messages="Successs";
}
else{
	
	$status=false;	
	$messages="Faluire";
}


$return_messages['status']			=$status;
$return_messages['message']			=$messages;
$return_messages_json=json_encode($return_messages);
echo $return_messages_json;

?>