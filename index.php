<?php
	require "php/db/connection.php";
	
	error_reporting(E_ERROR | E_PARSE); //Skip error messages	
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		session_start();
		
		$user_id = login_user($_POST['username'], $_POST['password']);
		if ($user_id == null) {
			$err = true;
			$usuario = $_POST['username'];
		} else {
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
			$_SESSION['user_id'] = $user_id;
			$_SESSION['title'] = 'Tuvida';
			header("Location: php/home.php");
			exit;
		}
	}
	
?>	

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Iniciar sesi&oacute;n</title>
	<meta charset="UTF-8">
	
	<!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
		crossorigin="anonymous">
	
</head>
<body>

	<div class="container">
		
		<h1>Iniciar sesi&oacute;n</h1>
		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			<div class="container-fluid">
				<div class="row">
					<div class="col-1">
						Usuario
					</div>
					<div class="col-3">
						<input id="username" name="username" value="<?php if(isset($usuario))echo $usuario;?>" type="text">
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
			
			<a href="php/login.php">No tengo cuenta</a>
			
			<?php if(isset($_GET["redirect"])) {
				echo "<center><p>Haga login para continuar.</p></center>";
			}?>
			<?php if(isset($err) and $err == true) {
				echo "<center><p>Revise usuario y contrase&ntilde;a.</p></center>";
			}?>
			
		</form>
			
		
	</div>
	
	
	

</body>
</html>