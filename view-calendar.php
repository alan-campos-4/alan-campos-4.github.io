<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: index.php?redirect=true");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Calendar | <?php $_SESSION['title'] ?></title>
	<meta charset="UTF-8">
	
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> -->
	
	<!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
		crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
	
	<!--JQuery-->
	<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
	<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
	<script>
		$( function() {
			$("#datepickerStart1").datepicker({
				dateFormat: 'dd/mm/yy',
			});
			$("#datepickerStart2").datepicker({
				dateFormat: 'dd/mm/yy'
			});
			$("#datepickerEnd1").datepicker({
				dateFormat: 'dd/mm/yy'
			});
			$("#datepickerEnd2").datepicker({
				dateFormat: 'dd/mm/yy'
			});
			
			/*$(".datepicker .startDate").datepicker({
				onSelect: function (e) {
					alert(e);//the value
					startDate = $(this).datepicker('getDate');
					console.log('Start - '+startDate);
				}
			});*/
		});
	</script>
	
	<script src="view-calendar.js"></script>
	

</head>
<body>

	<button class="button" onclick="history.back()">Volver a inicio</button>
	
	<h2><center>Calendario</center></h2>
	
	
	<div class="container">
		
		<h3>Crear evento</h3>
		<form>
		<div class="row">
			<div class="col-4">
				Name	<input type="text" id="eventName1">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				Start <input type="text" id="datepickerStart1">
			</div>
			<div class="col-3">
				Time <input type="text" id="timeStart1">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				End		<input type="text" id="datepickerEnd1">
			</div>
			<div class="col-3">
				Time	<input type="text" id="timeEnd1">
			</div>
		</div>
		</form>
		<button onclick="addEvent()">Crear</button>
		
		<br><br>
		
		<h3>Modificar evento</h3>
		<div class="row">
			<div class="col-4">
				Name	<input type="text" id="eventName2">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				Start	<input type="text" id="datepickerStart2">
			</div>
			<div class="col-3">
				Time	<input type="text" id="timeStart2">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				End		<input type="text" id="datepickerEnd2">
			</div>
			<div class="col-3">
				Time	<input type="text" id="timeEnd2">
			</div>
		</div>
		<!--<button onclick="modifyEvent()">Modificar</button>-->
		<button onclick="getAllEvents()">Modificar</button>
		<script src="view-calendar.js"></script>
		
		
	</div>
	
	<br><hr><br>
	
	<div class="container">
		<div id="calendar-div"></div>
	</div>
	
	<br>

</body>
<script>

	document.addEventListener('DOMContentLoaded', function() {
		loadCalendar();
	});
	
</script>
</html>