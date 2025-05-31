<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: index.php?redirect=true");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Journal | <?php $_SESSION['title'] ?></title>
	<meta charset="UTF-8">
	
	<!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
		crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
	
	

</head>
<body>

	<button class="button" onclick="history.back()">Volver a inicio</button>
	
	<h2><center>Diario</center></h2>
	
</body>
</html>