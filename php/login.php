<?php
	require "connection.php";
	
	error_reporting(E_ERROR | E_PARSE); //Skip error messages	
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		session_start();
		
		signup_user($_POST['username'], $_POST['email'], $_POST['password']);
		alert("Usuario ".$_POST['username']." creado.");
		header("Location: ../index.php");
		exit;
		
	}
	
?>	

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Crear cuenta</title>
	<meta charset="UTF-8">
	
	<!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
		crossorigin="anonymous">
	
</head>
<body>

	<div class="container">
		
		<h1>Crear cuenta</h1>
		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			<div class="container-fluid">
				<div class="row">
					<div class="col-1">
						Usuario
					</div>
					<div class="col-3">
						<input id="username" name="username" type="text" value="<?php if(isset($usuario)) echo $usuario;?>">
					</div>
				</div>
				<div class="row">
					<div class="col-1">
						E-mail
					</div>
					<div class="col-3">
						<input id="email" name="email" type="text"  value="<?php if(isset($email)) echo $email;?>">
					</div>
				</div>
				<div class="row">
					<div class="col-1">
						Clave
					</div>
					<div class="col-3">
						<input id="password" name="password" type="password">
					</div>
				</div>
				
				<div class="row">
					<div class="col-2">
						<input type="submit">
					</div>
				</div>
			</div>
			
		</form>
			
		
	</div>
	
	
	

</body>
</html>