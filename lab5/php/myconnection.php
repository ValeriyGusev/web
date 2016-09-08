<?php
	
class myconnection
{
	private static  $dbname = '';//'web_techn';
	private static  $user = '';//'dasha';
	private static  $pass = '';//'qwer';
	private static  $table = '';//'client';
	private static  $server = '';//localhost
	
	function __construct($name, $usr, $pw, $tbl, $serv) 
	{
       self::$dbname = $name;
	   self::$user = $usr;
	   self::$pass = $pw;
	   self::$table = $tbl;
	   self::$server = $serv;	  
	}

	static function get_dbname()
	{
		return self::$dbname;
	}
	
	static function get_user()
	{
		return self::$user;
	}
	
	static function get_pass()
	{
		return self::$pass;
	}
	
	static function get_table()
	{
		return self::$table;
	}
	
	static function get_server()
	{
		return self::$server;
	}
	
}
?>