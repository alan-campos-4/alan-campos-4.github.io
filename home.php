<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: index.php?redirect=true");
	}
?>

<!DOCTYPE html>
<html lang='en'>
<head>

	<title>Home | <?php $_SESSION['title'] ?></title>
	<meta charset="UTF-8">

</head>
<body>

	<div class="container">
		
		<h3>Bienvenido, <?php echo $_SESSION['username'] ?></h3>
	
		<button onclick="openPage('view-calendar.php')">Calendario</button>
		<br>
		<button onclick="openPage()">Notas</button>
		<br>
		<button onclick="openPage()">Diario</button>
		<br>
		<a href="logout.php">Salir</a>
		
	<div>

</body>
<script>

	function openPage(page)	{window.open(page,"_self");}

</script>
</html>