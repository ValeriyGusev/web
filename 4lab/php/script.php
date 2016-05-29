<?php 
header("Content-Type: text/html; charset=utf-8");
session_start();
if ($_SESSION['script'] == $_SERVER['REMOTE_ADDR'])  
{
//Объявляем переменные:
$Name  = $Familia = $Otchestvo = $Email ='';
$_SESSION['podps'] = ''; 
//Разделитель между записями 
$NewLine = '--------------'; 
$success = true;
//Name, Email, Tel, Date, Time - названия совпадают с названиями полей <input type="date" name="Date"...

if (filter_var($_GET["email"], FILTER_VALIDATE_EMAIL) && !empty($_GET["email"])) 
    $Email = $_GET["email"]; 
else {$success = false ; $_SESSION['podps'] = 'Неверно указан Email!'; }

if (preg_match("/[А-Я][а-я]{3,15}/", $_GET["familia"]))
	$Familia = $_GET["familia"];
else {$success = false ; $_SESSION['podps'] = 'Неверно указана фамилия!';}

if (preg_match("/[А-Я][а-я]{3,15}/", $_GET["name"]))
	$Name = $_GET["name"];
else {$success = false ; $_SESSION['podps'] = 'Неверно указано имя!';}

if (preg_match("/[А-Я][а-я]{3,20}/", $_GET["otchestvo"]))
	$Otchestvo = $_GET["otchestvo"];
else {$success = false ; $_SESSION['podps'] = 'Неверно указано отество!';}
$mysqli = mysqli_connect('localhost','valeriy','89824919799',"lab_wb");

if($success == true)
{
	$stmt = mysqli_prepare($mysqli, "INSERT INTO podpiski (fam, nam, otc, em) VALUES (?, ?, ?, ?)");
	mysqli_stmt_bind_param($stmt, 'ssss', $Familia, $Name, $Otchestvo, $Email);
	if (mysqli_stmt_execute($stmt) === TRUE) {
		$_SESSION['podps'] = 'Подписка оформлена!'; 
	}
	else {
		$_SESSION['podps'] = 'Доступ закрыт.';
	}
		mysqli_stmt_close($stmt);
 mysqli_close($mysqli);
}
}
else {$_SESSION['podps'] = 'Доступ закрыт.';}
$back = $_SERVER['HTTP_REFERER']; 
echo "
<html>
  <head>
   <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
  </head>
</html>";
?>

