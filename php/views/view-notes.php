<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: index.php?redirect=true");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>


	<title>Notas</title>
	<meta charset="UTF-8">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="../../css/style.css" >
	
	<!-- Javascript -->
	<script src="../../js/global.js"></script>
	<script src="view-notes.js"></script>
	
	
	
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
		<button class="btn btn-outline-success me-2" type="button" onclick="history.back()">Volver al inicio</button>
		<ul class="nav justify-content-center">
			<li class="nav-item">
				<h3>Notas</h3>
			</li>
		</ul>
	</nav>
	
	
	<div class="container">
		<div class="container-fluid">
			<div class="row row-gap-3">
				<div class="col-5">
					<div class="p-2 row align-items-center">
						<div class="col-2">
							<button type="button" class="btn btn-info rounded-circle btn-lg" onclick="createNote()">+</button>
						</div>
						<div class="col-10">
							<select id="sort1" onchange="onOrderChange();">
								<option value="title">Nombre</option>
								<option value="color">Color</option>
								<option value="date_created">Fecha de creación</option>
								<option value="date_modified">Fecha de modificación</option>
							</select>
							<select id="sort2" onchange="onOrderChange();">
								<option value="ASC">Ascendente</option>
								<option value="DESC">Descendente</option>
							</select>
						</div>
					</div>
					<div class="p-2">
						<div class="note-list-container">
							<table class="table table-striped table-hover" id="note-list" border="1">
								<tbody class="">
									<tr></tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-7">
					<div id="note-content">
						<div class="row justify-content-end">
							<div class="col-1">
								<button class="btn btn-secondary" onclick="closeContent()">X</button>
							</div>
						</div>
						<div class="row align-items-center">
							<div class="col-4"> <input id="colorpicker" data-jscolor="" class="form-control" id="contain_word" > </div>
							<div class="col-4"> <input id="note-title" class="form-control" id="contain_word"> </div>
							<div class="col-4" id="note-display-date"> <span id="note-date"></span> </div>
						</div>
						<textarea id="note-textarea"></textarea>
						<button class="btn btn-success" onclick="updateNote()">Guardar cambios</button>
					</div>
				</div>
			</div>
		</div>
    </div>
	
	<br>
	
	
</body>
<script>

	document.addEventListener('DOMContentLoaded', function() {
		onLoadNotes();
	});
	
	jscolor.presets.default = {
		format:'hex', previewPosition:'right', position:'right',
		palette:'#FF1E1E, #FFC530, #FFEE29, #26FF38'
	};
	
</script>
</html>