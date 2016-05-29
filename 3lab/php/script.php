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



if($success == true)
{
$_SESSION['podps'] = 'Подписка оформлена!'; 
//Открываем файл для записи 
$fp  = fopen('notes.txt', 'a+'); 
//Записываем построчно каждое значение из полей формы
fwrite($fp, $NewLine."\n");
fwrite($fp, $Familia."\n");
fwrite($fp, $Name."\n");  
fwrite($fp, $Otchestvo."\n"); 
fwrite($fp, $Email."\n"); 
//Закрываем файл
fclose($fp); 
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
