<?php

	$servername = "127.0.0.1:3306";
	$user = "userroot";
	$pass = "QKEBFF2025";
	$dbname = "calendar_db";
	
	
	function login_user($username, $password) {
		global $servername, $user, $pass, $dbname;
		
		$conn = new mysqli($servername, $user, $pass, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND passwrd = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		
		return $row['id'];
	}
	
	
	function signup_user($username, $email, $password) {
		global $servername, $user, $pass, $dbname;
		
		$conn = new mysqli($servername, $user, $pass, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$stmt = $conn->prepare("INSERT INTO users (username, email, passwrd) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $username, $email, $password);
		$stmt->execute();
		
		mysqli_close($conn);
	}
	
	
?>