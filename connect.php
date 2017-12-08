<?php

class DB_Connect{
	function __construct(){}
	function __destruct(){}

	public function system_env(){
		if($_SERVER['SERVER_NAME'] == "www.munafood.com" || $_SERVER['SERVER_NAME'] == "munafood.com")
			return "Production munafood";
		else if($_SERVER['SERVER_NAME'] == "www.dapurnanda.com" || $_SERVER['SERVER_NAME'] == "dapurnanda.com")
			return "Production dapurnanda";
		else if($_SERVER['SERVER_NAME'] == "localhost")
			return "Development munafood";
			//return "Development dapurnanda";
	}

	public function connect(){
		if($this->system_env() == "Production munafood")
		{
			$DB_SERVER = "localhost";
			$DB_USER = "u177270944_root";
			$DB_PASSWORD = "h1b4h1bm";
			$DB_DATABASE = "u177270944_ukm";
		}
		else if($this->system_env() == "Production dapurnanda")
		{
			$DB_SERVER = "localhost";
			$DB_USER = "u528535703_root";
			$DB_PASSWORD = "h1b4h1bm";
			$DB_DATABASE = "u528535703_ukm";
		}
		else if($this->system_env() == "Development munafood")
		{
			$DB_SERVER = "localhost";
			$DB_USER = "root";
			$DB_PASSWORD = "";
			$DB_DATABASE = "ukm";
		}
		else if($this->system_env() == "Development dapurnanda")
		{
			$DB_SERVER = "localhost";
			$DB_USER = "root";
			$DB_PASSWORD = "";
			$DB_DATABASE = "ukm";
		}

		$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_DATABASE, "3306") or die(mysqli_connect_error());

        mysqli_select_db($con, $DB_DATABASE)or die(mysqli_error());

		return $con;
	}

	public function close(){mysql_close();}
}
?>
