

	var calendar;
	
	
	function onLoadCalendar() {
		var calendarDiv = document.getElementById('calendar-div');
		calendar = new FullCalendar.Calendar(calendarDiv, {
			locale: 'es', //español
			firstDay: 1, //Monday
			//height: 'auto',
			//slotMinTime: '08:00',
			//slotMaxTime: '20:00',
			eventTimeFormat: { // 14:30:00
				hour: '2-digit',
				minute: '2-digit',
				hour12: false
			},
			headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
			},
			views: {
				dayGridMonth: { buttonText: 'Mes' },
				timeGridWeek: { buttonText: 'Semana' },
				timeGridDay: { buttonText: 'Día' },
				listMonth: { buttonText: 'Lista de Mes' },
				timeGrid: { dayMaxEventRows: 6 },
			},
			navLinks: true, // can click day/week names to navigate views
			selectable: true,
			nowIndicator: true,
			dayMaxEventRows: true,
			events: "./../db/load.php",
			eventClick: function(info)	{openModifyModal(info)},
			dateClick: function(info)	{openCreateModalOnDateClick(info)},
		});
		calendar.render();
		
		setEventID(null);
	}
	
	
	
	
	
	/***  Adding Calendar Events ***/
	
	function openCreateModal() {
		// Clears the date picker.
		$("#datepickerStart1").datepicker("setDate", null);
		
		// Open the modal to modify.
		var createEventModal = new bootstrap.Modal(document.getElementById('createModal'), {
			keyboard: false,
		});
		createEventModal.toggle();
	}
	
	function openCreateModalOnDateClick(info) {
		// Get the date cliked on.
		let dateStr = info.dateStr.split('-');
		let year = dateStr[0];
		let month = dateStr[1]-1;
		let day = dateStr[2];
		if (month<0) {
			year = year-1;
		}
		let selectedDate = new Date(year, month, day);
		
		// Display the date in the modal datepicker.
		var startDate = $.datepicker.formatDate("dd/mm/yy", selectedDate);
		$("#datepickerStart1").datepicker("setDate", startDate);
		
		// Open the modal to modify.
		var createEventModal = new bootstrap.Modal(document.getElementById('createModal'), {
			keyboard: false,
		});
		createEventModal.toggle();
	}
	
	function addEvent() {
		const name = document.getElementById("eventName1").value;
		const startDate = $("#datepickerStart1").datepicker("getDate");
		const endDate = $("#datepickerEnd1").datepicker("getDate");
		const startTime = document.getElementById("timeStart1").value;
		const endTime = document.getElementById("timeEnd1").value;
		
		if (name!=null) {  //Fails
			if ( startDate!=null && endDate!=null ) {
				if (isValidTime(startTime) && isValidTime(endTime)) {
					
					const start = datetimeToMySQL(startDate, startTime);
					const end = datetimeToMySQL(endDate, endTime);
					const color = $("#colorpicker1").val();
					
					// Pass the attributes to the php file that will handle the MySQL operation.
					fetch("../db/procesar.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						body: "table=events&action=insert&name="+name+"&start="+start+"&end="+end+"&color="+color,
					})
					.then(response => response.text())
					.then(data => {console.log("Respuesta del servidor: \n", data);});
					
					// Refresh the page.
					refresh();
				} else {
					alert('Debes introducir una hora válida.');
				}
			} else {
				alert('Debes introducir una fecha válida.');
			}
		} else {
			alert('Debes introducir un nombre.');
		}
	}
	
	
	
	
	/***  Modifying Calendar Events ***/
	
	function openModifyModal(info) {
		// Display all of the event attributes in within the modal.
		document.getElementById("eventName2").value = info.event.title;
		document.getElementById("colorpicker2").value = info.event.backgroundColor;
		var startDate = $.datepicker.formatDate("dd/mm/yy", info.event.start);
		var endDate = $.datepicker.formatDate("dd/mm/yy", info.event.end);
		$("#datepickerStart2").datepicker("setDate", startDate);
		$("#datepickerEnd2").datepicker("setDate", endDate);
		
		// Display the time of the event's start and end in the inputs.
		document.getElementById('timeStart2').value =	toDoubleDigits(info.event.start.getHours()) +':'+ toDoubleDigits(info.event.start.getMinutes());
		if (info.event.end!=null) {
			document.getElementById('timeEnd2').value =	toDoubleDigits(info.event.end.getHours()) +':'+ toDoubleDigits(info.event.end.getMinutes());
		}
		
		//Open the modal to modify.
		var modEventModal = new bootstrap.Modal(document.getElementById('modModal'), {
			keyboard: false
		});
		modEventModal.toggle();
		
		// Save the event in localStorage for modifying later.
		setEventID(info.event.id);
	}
	
	function modifyEvent() {
		// Obtain event id and check it exists.
		var event_id = getEventID();
		var event = calendar.getEventById(event_id);
		if (event!=null) {
			// Obtain all the attributes to modify from the inputs.
			const name		= document.getElementById("eventName2").value;
			const startDate = $("#datepickerStart2").datepicker("getDate");
			const endDate	= $("#datepickerEnd2").datepicker("getDate");
			const startTime = document.getElementById("timeStart2").value;
			const endTime	= document.getElementById("timeEnd2").value;
			
			const start = datetimeToMySQL(startDate, startTime);
			const end	= datetimeToMySQL(endDate, endTime);
			const color = document.getElementById("colorpicker2").value;
			
			// Pass the attributes to the php file that will handle the MySQL operation.
			fetch("../db/procesar.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				body: "table=events&action=update&id="+event_id+"&name="+name+"&start="+start+"&end="+end+"&color="+color,
			})
			.then(response => response.text())
			.then(data => {console.log("Respuesta del servidor: \n", data);});
			
			// Refresh the page.
			//refresh();
		} else {
			alert('No se pudo encontrar el evento.');
		}
	}
	
	
	
	
	/***  Deleting Calendar Events ***/
	
	function deleteEvent() {
		// Obtain event id and check it exists.
		var event_id = getEventID();
		var event = calendar.getEventById(event_id);
		if (event!=null) {
			// Ask the user if they want to delete the event.
			if (confirm("Seguro que quieres borrar este evento?") == true) {
				
				// Pass the attributes to the php file that will handle the MySQL operation.
				fetch("../db/procesar.php", {
					method: "POST",
					headers: {
						"Content-Type": "application/x-www-form-urlencoded"
					},
					body: "table=events&action=delete&id="+event_id,
				})
				.then(response => response.text())
				.then(data => {console.log("Respuesta del servidor: \n", data);});
				
				// Refresh the page.
				refresh();
			}
		} else {
			alert('No se pudo encontrar el evento.');
		}
	}
	
	
	
	