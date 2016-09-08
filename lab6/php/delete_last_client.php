<?php
require  'myconnection.php';
require  'client.php';
session_start();


$connect = new myconnection('web_techn', 'Dasha', 'qwer', 'client', 'localhost');

$datas = Client::delete_last_client();
$back = $_SERVER['HTTP_REFERER']; 
		echo "
		<html>
  		<head>
  		<meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
  		</head>
		</html>";	
?>