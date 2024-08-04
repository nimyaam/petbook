<?php
$mysql_host='localhost';
$mysql_user='petbook_admin';
$mysql_pass='Project@123';
$mysql_db='project';
$conn = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

$success_connect=0;
//||!mysqli_select_db($mysql_db)

//echo "hello";

if(!mysqli_connect($mysql_host, $mysql_user, $mysql_pass,$mysql_db))
{
  die('<font color="red">Database connection Failed!</font>');
  echo "failed";

}
else{
  $success_connect=mysqli_connect($mysql_host, $mysql_user, $mysql_pass,$mysql_db);
  //echo "succcess !";
  //echo "failed";
}



?>