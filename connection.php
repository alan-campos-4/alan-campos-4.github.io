<?php
$server = "127.0.0.1:3306";
$username = "userroot";
$password = "QKEBFF2025";
$database = "calendar_db";
$connection = mysqli_connect("$server","$username","$password");
$select_db = mysqli_select_db($connection, $database);
if(!$select_db)
{
	echo("connection terminated");
}
?>