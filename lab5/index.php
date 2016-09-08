<?php
header("Content-Type: text/html; charset=utf-8"); 
session_start();
$_SESSION['test'] = $_SERVER['REMOTE_ADDR']; 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>lab5</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

  <section class="container">
    <div class="login">
      <h1>Регистрация</h1>     
      <?php
              require 'php/client.php';
              echo Client::get_form('php/toclient.php');
              echo $_SESSION['message'];
              $_SESSION['message'] = ''; 
              echo Client::method('php/show_client.php', 'php/show_last_client.php', 'php/delete_last_client.php');
              echo $_SESSION['message'];
              $_SESSION['message'] = '';
      ?>
      </div>
  </section>
</form>
</body>
</html>
