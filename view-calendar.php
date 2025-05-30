<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: index.php?redirect=true");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Tuvida</title>
	<meta charset="UTF-8">
	
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> -->
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
		crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
	
	<!--<script src="view-calendar.js">-->

</head>
<body>

	<h2><center>Javascript Fullcalendar</center></h2>
	
	
	<div class="container">
		
		<h3>Crear evento</h3>
		<div class="row">
			<div class="col-9">
				Name	<input type="text" id="eventName1">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				Start <input type="text" id="datepickerStart1">
			</div>
			<div class="col-6">
				Time <input type="text" id="timeStart1">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				End		<input type="text" id="datepickerEnd1">
			</div>
			<div class="col-6">
				Time	<input type="text" id="timeEnd1">
			</div>
		</div>
		<button onclick="addEvent()">Crear</button>
		<br><br>
		
		<h3>Modificar evento</h3>
		<div class="row">
			<div class="col-9">
				Name	<input type="text" id="eventName2">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				Start	<input type="text" id="datepickerStart2">
			</div>
			<div class="col-6">
				Time	<input type="text" id="timeStart2">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				End		<input type="text" id="datepickerEnd2">
			</div>
			<div class="col-6">
				Time	<input type="text" id="timeEnd2">
			</div>
		</div>
		<button onclick="modifyEvent()">Modificar</button>
		
	</div>
	
	
	
	<div class="container">
		<div id="calendar"></div>
	</div>
	
	<br>

</body>
<script>
	
	<?php 
		include('connection.php');
		$fetch_event = mysqli_query($connection, "select * from tbl_events");
	?>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			events: [
				<?php while($result = mysqli_fetch_array($fetch_event)) { ?>
				{
					title: '<?php echo $result['title']; ?>',
					start: '<?php echo $result['start_date']; ?>',
					end: '<?php echo $result['end_date']; ?>',
					color: 'yellow',
					textColor: 'black'
				},
				<?php } ?>
			],
		})
	});
	
</script>
</html>