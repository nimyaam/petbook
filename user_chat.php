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
$chat_messages=array();



$doctor_id		=$expl_data[0];
$user_id		=$expl_data[1];

$query= "SELECT * FROM `chat_table` WHERE `sender`='".$doctor_id."' AND `receiver`='".$user_id."' OR `sender`='".$user_id."' AND `receiver`='".$doctor_id."'";
if ($query_run= mysqli_query($success_connect,$query))
         {
         	$status=true;
         	$query__row_count= mysqli_num_rows($query_run);
         	$i=0;
         	foreach ( $query_run as $var ) {

         		$chat_messages[$i]=array();
         		$chat_messages[$i]['sl']			=$var['sl'];
         		$chat_messages[$i]['sender']		=$var['sender'];
         		$chat_messages[$i]['sender_type']	=$var['sender_type'];
         		$chat_messages[$i]['receiver']		=$var['receiver'];
         		$chat_messages[$i]['receiver_type']	=$var['receiver_type'];
         		$chat_messages[$i]['msg']			=$var['msg'];
         		$chat_messages[$i]['time_stamp']	=$var['time_stamp'];
         		$chat_messages[$i]['read_status']	=$var['read_status'];
         		$chat_messages[$i]['msg_type']		=$var['msg_type'];

         		$i++;
         	}
         }else{
         	$status=false;

         }

$return_messages['status']			=	$status;
$return_messages['no_of_msg']		=$query__row_count;
$return_messages['content']			=json_encode($chat_messages);
$return_messages_json=json_encode($return_messages);
echo $return_messages_json;
?>