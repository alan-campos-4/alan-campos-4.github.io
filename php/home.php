<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: ../index.php?redirect=true");
	}
?>

<!DOCTYPE html>
<html lang='en'>
<head>

	<title>Home</title>
	<meta charset="UTF-8">
	
	<!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
		crossorigin="anonymous">

</head>
<body>

	<div class="container">
		
		<h3>Bienvenido, <?php echo $_SESSION['username'] ?> : <?php echo $_SESSION['user_id'] ?></h3>
	
		<button onclick="window.open('views/view-calendar.php','_self')">Calendario</button>
		<br>
		<button onclick="window.open('views/view-notes.php','_self')">Notas</button>
		<br>
		<button onclick="window.open('views/view-journal.php','_self')">Diario</button>
		<br>
		<a href="logout.php">Salir</a>
		
	<div>

</body>
</html>