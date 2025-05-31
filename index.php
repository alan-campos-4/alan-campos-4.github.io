<?php
	require "connection.php";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		session_start();
		$_SESSION['title'] = 'Tuvida';
		$usu = check_user($_POST['username'], $_POST['password']);
		if ($usu == false) {
			$err = true;
			$usuario = $_POST['username'];
		} else {
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
			header("Location: home.php");
			exit;
		}
	}
	
	/*
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$usu = check_user($_POST['usuario'], $_POST['clave']);
		if ($usu==false) {
			$err = true;
			$usuario = $_POST['usuario'];
		} else {
			session_start();
			$found = true;
			$_SESSION['usuario'] = $_POST['usuario'];
			$_SESSION['clave'] = $_POST['clave'];
			header("Location: home.php");
			
		}
	}
	*/
?>	

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Iniciar sesi&oacute;n | <?php $_SESSION['title'] ?></title>
	<meta charset="UTF-8">
	
</head>
<body>

	<h1>Iniciar sesi&oacute;n</h1>
	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
		Usuario	<input id="username" name="username" value="<?php if(isset($usuario))echo $usuario;?>" type="text">
		<br>
		Clave <input id="password" name="password" type="password">
		<br>
		<input type="submit">
	</form>
	
	
	<?php if(isset($_GET["redirect"])) {
		echo "<p>Haga login para continuar</p>";
	}?>
	<?php if(isset($err) and $err == true) {
		echo "<p>Revise usuario y contrase&ntilde;a</p>";
	}?>

</body>
</html>