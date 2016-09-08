<?php
require  'myconnection.php';
require  'client.php';
session_start();
if ($_SESSION['test'] == $_SERVER['REMOTE_ADDR'])  
{
	session_start();
	$Name = $_GET["name"];
	$Email = $_GET["email"];
	$Phone = $_GET["phone"];
	$Password = $_GET["password"];
	$connect = new myconnection('web_techn', 'Dasha', 'qwer', 'client', 'localhost');
	try 
	{
		$client = new Client($Name, $Email, $Phone, $Password);
		$client->insert();
		$_SESSION['message'] = 'Благодарим за регистарацию!';
	}
	catch (Exception $e)
	{
		$_SESSION['message'] = $e->getMessage();
	}
}
else 
	{$_SESSION['message'] = 'Ошибка доступа!';}
back();
?>

<?php
function back()
{
	$back = $_SERVER['HTTP_REFERER']; 
	echo "
	<html>
	  <head>
	   <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
	  </head>
	</html>";
}
?>
