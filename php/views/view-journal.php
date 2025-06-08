<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: index.php?redirect=true");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>


	<title>Diario</title>
	<meta charset="UTF-8">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="../../css/style.css" >
	
	<!-- Javascript -->
	<script src="../../js/global.js"></script>
	<script src="view-journal.js"></script>
	
	
	
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
			$("#datepicker").datepicker({
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
				<h3>Diario</h3>
			</li>
		</ul>
	</nav>
	
	
	<div class="container">
		<div class="container-fluid">
			<div class="row row-gap-3">
				<div class="col-5">
					<div class="p-2">
						<button id="addbutton" class="btn btn-info rounded-circle btn-lg" onclick="openContentToCreate()">+</button>
					</div>
					<div class="p-2">
						<div class="note-list-container">
							<table class="table table-hover" id="note-list" border="1">
								<tbody>
									<tr></tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-7">
					<div id="note-content">
						<div class="float-end">
							<button class="btn btn-secondary" onclick="closeContent()">X</button>
						</div>
						<div class="row">
							<div class="col-5"> <input id="note-title" class="form-control" id="contain_word"> </div>
							<div class="col-4"> <input type="text" id="datepicker" class="form-control" id="contain_word">  </div>
							<div class="col-3" id="note-display-date"> <span id="note-date"></span> </div>
						</div>
						<textarea id="note-textarea"></textarea>
						<button class="btn btn-success" id="saveButton" onclick="updateJournalEntry()">Guardar cambios</button>
						<button class="btn btn-success" id="createButton" onclick="createJournalEntry()">Crear nota</button>
					</div>
				</div>
			</div>
		</div>
    </div>
	
	<br>
	
	
</body>
<script>

	document.addEventListener('DOMContentLoaded', function() {
		onLoadJournal();
	});
	
	jscolor.presets.default = {
		format:'hex', previewPosition:'right', position:'left',
		palette:'#FF1E1E, #FFC530, #FFEE29, #26FF38'
	};
	
</script>
</html>