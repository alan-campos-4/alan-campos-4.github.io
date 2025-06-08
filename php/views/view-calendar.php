<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: ../../index.php?redirect=true");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>


	<title>Calendario</title>
	<meta charset="UTF-8">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="../../css/style.css" >
	
	<!-- Javascript -->
	<script src="../../js/global.js"></script>
	<script src="view-calendar.js"></script>
	
	
	
	<!-- FullCalendar -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
	
	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
		crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
		crossorigin="anonymous">
	</script>
	
	<!-- JSColor - Color picker -->
	<script src="../../js/jscolor.js"></script>
	
	<!-- JQuery - Datepicker -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
	<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
	<script>
		$( function() {
			$("#datepickerStart1").datepicker({
				dateFormat: 'dd/mm/yy',
				firstDay: 1
			});
			$("#datepickerStart2").datepicker({
				dateFormat: 'dd/mm/yy',
				firstDay: 1
			});
			$("#datepickerEnd1").datepicker({
				dateFormat: 'dd/mm/yy',
				firstDay: 1
			});
			$("#datepickerEnd2").datepicker({
				dateFormat: 'dd/mm/yy',
				firstDay: 1
			});
		});
	</script>
	

</head>
<body>	

	<nav>
		<ul class="nav justify-content-between">
			<li class="nav-item">
				<button class="btn btn-outline-secondary me-2" type="button" onclick="history.back()">Volver al inicio</button>
			</li>
			<li class="nav-item">
				<h3>Calendario</h3>
			</li>
		</ul>
	</nav>


	
	
	<div class="container">
		
		<!-- Modal for creating events -->
		
		<div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" 
			aria-labelledby="createModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="createModalLabel">Crear evento</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-3">
									Name	<input type="text" id="eventName1">
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									Start <input type="text" id="datepickerStart1">
								</div>
								<div class="col-md-3">
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
							<div class="row">
								<div class="col-4">
									<input id="colorpicker1" data-jscolor="">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-success" onclick="addEvent()">Crear</button>
					</div>
				</div>
			</div>
		</div>
		
		
		
		<!-- Modal for modifying events -->
		
		<div class="modal fade" id="modModal" data-bs-backdrop="static" data-bs-keyboard="false" 
			aria-labelledby="modModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="modModalLabel">Modificar evento</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-2">	Name </div>
								<div class="col-md-2"> <input type="text" id="eventName2"> </div>
							</div>
							<!-- <div class="col-md-3">
								<div class="form-outline">
									<label class="form-label" for="typeEmail">Email</label>
									<input type="email" id="typeEmail" class="form-control" />
								</div>
							</div>-->
							<div class="row">
								<div class="col-md-2">	Start </div>
								<div class="col-md-3"> <input type="text" id="datepickerStart2"> </div>
								<div class="col-md-2">	Time </div>
								<div class="col-md-2"> <input type="text" id="timeStart2"> </div>
							</div>
							<div class="row">
								<div class="col-md-2">	End </div>
								<div class="col-md-3"> <input type="text" id="datepickerEnd2"> </div>
								<div class="col-md-2">	Time </div>
								<div class="col-md-2"> <input type="text" id="timeEnd2"> </div>
							</div>
							<div class="row">
								<div class="col-xs-2">	Color </div>
								<div class="col-xs-4"> <input id="colorpicker2" data-jscolor=""> </div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" onclick="deleteEvent()">Borrar</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-success" onclick="modifyEvent()">Modificar</button>
					</div>
				</div>
			</div>
		</div>
		
		
		<div id="calendar-div"></div>
		
		
		<br>
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
			  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
			</svg>
			Crear evento
		</button>
		
	</div>
	
	<br>
	
	
</body>
<script>

	document.addEventListener('DOMContentLoaded', function() {
		onLoadCalendar();
	});
	
	jscolor.presets.default = {
		palette:'#FF1E1E, #FFC530, #FFEE29, #26FF38',
		format:'hex', previewPosition:'right', position:'right',
		hideOnPaletteClick:true,
	};
	
</script>
</html>