<?php

	include("connection.php");
	
	session_start();
	
	$conn = mysqli_connect($server, $_SESSION['username'], $_SESSION['password'], $database);
	
	//$start = $_GET["start"];
	//$end = $_GET["end"];
	
	$sth = mysqli_query($conn, "SELECT * FROM events");
	$rows = array();
	while($r = mysqli_fetch_assoc($sth)) {
		$rows[] = $r;
	}
	print json_encode($rows);
	

?>