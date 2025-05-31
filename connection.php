<?php

	$server = "127.0.0.1:3306";
	//$username = "userroot";
	//$password = "QKEBFF2025";
	$database = "calendar_db";
	//$connection = mysqli_connect("$server","$username","$password");
	//$select_db = mysqli_select_db($connection, $database);
	//if(!$select_db) {
		//echo("connection terminated");
	//}
	
	function check_user($username, $password) {
		$connection_str = 'mysql:dbname='.$database.';host='.$server;
		try {
			$db = new PDO($connection_str, $username, $password);
			return $db;
		} catch (PDOException $e) {
			echo 'Error con la base de datos: ' . $e->getMessage();
		}
	}
	
?>