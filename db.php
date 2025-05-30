<?php

	$server = "127.0.0.1:3306";
	$database = "calendar_db";

	function check_user($username, $password) {
		$connection_str = 'mysql:dbname=calendar_db;host=127.0.0.1:3306';
		try {
			$db = new PDO($connection_str, $username, $password);
			return $db;
		} catch (PDOException $e) {
			echo 'Error con la base de datos: ' . $e->getMessage();
		}
	}
	
	function get_connection() {
		return mysqli_connect("$server", $_SESSION['username'], $_SESSION['username']);
	}
	
?>