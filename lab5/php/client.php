<?php 
require 'medoo.php';


class Client
{
	private static $Name = '';
	private static $Email = '';
	private static $Phone = '';
	private static $Password = '';
	private static $patternName = '([A-z0-9_.-]{1,50})';
	private static $patternEmail = '([A-z0-9_.-]{1,})@([A-z0-9_.-]{1,}).([A-z]{2,8})';
	private static $patternPhone = '^\d{1}-\d{3}-\d{3}-\d{2}-\d{2}$';
	private static $patternPassword = '^[A-zА-Яа-яЁё-0-9\s-]{7,20}$';
	private static $lastID = '';
	
	function __construct($name, $email, $phone, $password) 
	{
		self::$Name = $name;//$_GET["name"];
		self::$Email = $email;//$_GET["email"];
		self::$Phone = $phone;//$_GET["phone"];
		self::$Password = $password;//$_GET["password"];	
		if ($this->check_length(self::$Name, 1, 50) || !filter_var($_GET["email"], FILTER_VALIDATE_EMAIL) || $this->check_length(self::$Phone, 1, 15) || $this->check_length(self::$Password, 5, 20)) 
			throw new Exception("Ошибка!");	
		if($this->check_Name())		
			throw new Exception("Пользователь с таким именем уже существует!");	
		if(!preg_match(self::$patternName, self::$Name) || !preg_match("/\d{1}-\d{3}-\d{3}-\d{2}-\d{2}/", self::$Phone) || !preg_match("/[A-zА-Яа-яЁё0-9\s-]{7,20}/", self::$Password))
			throw new Exception("Ошибка формата ввода!");	
	}	

	function check_Name()
	{
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => myconnection::get_dbname(),
		'server' => myconnection::get_server(),
		'username' => myconnection::get_user(),
		'password' => myconnection::get_pass()));
		
		$datas = $database->select(myconnection::get_table(), array(
		"ID"),
		array(
		"Name" => self::$Name
		));
		if($datas[0]['ID'] == '')
				return false;
			else
				return true;
	}
	
	function clean($value = "") 
	{
		$value = htmlspecialchars(strip_tags(stripslashes(trim($value))));
	
		return $value;
	}

	function check_length($value = "", $min, $max) 
	{
		$result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
		
		return $result;
	}
	
	function insert() 
	{			
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => myconnection::get_dbname(),
		'server' => myconnection::get_server(),
		'username' => myconnection::get_user(),
		'password' => myconnection::get_pass()));	
		
		$database->insert(myconnection::get_table(), array(
		"Name" => self::$Name,
		"Email" => self::$Email,
		"Phone" => self::$Phone,
		"Password" => self::$Password));
	}	
	
	static function show_client() 
	{		
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => myconnection::get_dbname(),
		'server' => myconnection::get_server(),
		'username' => myconnection::get_user(),
		'password' => myconnection::get_pass()));		
	
		$datas = $database->select(myconnection::get_table(), array(
		"Name",
		"Email",
		"Phone",
		"Password"));
		return $datas;		
	}

	static function show_last_client() 
	{		
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => myconnection::get_dbname(),
		'server' => myconnection::get_server(),
		'username' => myconnection::get_user(),
		'password' => myconnection::get_pass()));		
		
		$data = $database->query("select max(ID) from ".myconnection::get_table())->fetchAll();					
		$ID = $data[0]['max(ID)'];
	
		$datas = $database->select(myconnection::get_table(), array(
		"Name",
		"Email",
		"Phone",
		"Password"),
		array(
		"ID" => $ID
		));
		
		return $datas;
	}

	static function delete_last_client()
	{
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => myconnection::get_dbname(),
		'server' => myconnection::get_server(),
		'username' => myconnection::get_user(),
		'password' => myconnection::get_pass()));		
		$data = $database->query("select max(ID) from ".myconnection::get_table())->fetchAll();					
		$ID = $data[0]['max(ID)'];
		$database->delete(myconnection::get_table(), array(
		"ID" => $ID
		));
	}

	static function get_form($action)
    {
		$form = "<form id=\"input\" action=".$action." method=\"get\">					
		<label for=\"alpha\">Имя пользователя:</label>
		<input id=\"alpha\" name=\"name\" type=\"text\" pattern=".self::$patternName." placeholder=\"User name\" required> <br/>
		<label for=\"alpha\">Email:</label>
		<input name=\"email\" type=\"email\" pattern=".self::$patternEmail." placeholder=\"Email\" > <br/>				
		<label for=\"alpha\">Телефон:</label>
		<input name=\"phone\" type=\"tel\" pattern=".self::$patternPhone." placeholder=\"Phone\" > <br/>
		<label for=\"alpha\">Пароль:</label>
		<input type=\"password\" name=\"password\" pattern=".self::$patternPassword." placeholder=\"password\">	<br/>			
		<br/>
		<input type=\"submit\" name=\"submit\" value=\"Зарегистрироваться\"> <br/>		
		<br/>	
		</form>";    
		return $form;
    }

	static function method($actionshow, $actionshowlast, $actiondellast)
    {
		$form1 = "<form id=\"input\" action=".$action." method=\"get\">		
		<br>	
		<input type=\"submit\" name=\"show_client\" value=\"Список клиентов\" formaction=".$actionshow."><br/>	
		<br/>
		<input type=\"submit\" name=\"show_last_client\" value=\"Последний зарегистрированный клиент\" formaction=".$actionshowlast."><br/>
		<br/>
		<input type=\"submit\" name=\"delete_last_client\" value=\"Удалить последнего клиента\" formaction=".$actiondellast."><br/>
		</form>";      
		return $form1;
    }

}
?>
