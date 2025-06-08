<?php

	include("connection.php");
	
	session_start();
	
	$conn = mysqli_connect($servername, $user, $pass, $dbname);
	
	if (isset($_SESSION['user_id'])) {
		
		$stmt = mysqli_query($conn, "SELECT * FROM events WHERE user_id=".$_SESSION['user_id']);
		$rows = array();
		while($r = mysqli_fetch_assoc($stmt)) {
			$rows[] = $r;
		}
		print json_encode($rows);
		
	} else {
		http_response_code(403);
		die(json_encode(['error' => 'Sesión no iniciada']));
	}
	
?>