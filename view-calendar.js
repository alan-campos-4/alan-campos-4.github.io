
	var calendar;
	
	
	
	function loadCalendar() {
		var calendarDiv = document.getElementById('calendar-div');
		calendar = new FullCalendar.Calendar(calendarDiv, {
			themeSystem: 'bootstrap5',
			firstDay: 1, //Monday
			height: 'auto',
			slotMinTime: '08:00',
			slotMaxTime: '20:00',
			headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
			},
			views: {
				dayGridMonth: { buttonText: 'Month' },
				timeGridWeek: { buttonText: 'Week' },
				timeGridDay: { buttonText: 'Day' },
				listMonth: { buttonText: 'List Month' },
				timeGrid: { dayMaxEventRows: 6 },
			},
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			selectable: true,
			nowIndicator: true,
			dayMaxEventRows: true,
			events: "load.php",
			eventClick: function(info) {eventOnClick(info)},
		});
		calendar.render();
		
		setEventID(null);
	}
	
	
	
	
	/*** LocalStorage functions ***/
	
	function getEventID()		{return localStorage.getItem('event-id-to-modify');}
	function setEventID(newID)	{localStorage.setItem('event-id-to-modify', newID);}
	
	
	
	/*** Modal pop-up ***/
	
	function openModal() {
		var myModal = new bootstrap.Modal(document.getElementById('demo'), {})
		myModal.toggle()
	}
	
	
	/*** Date Formatting functions ***/
	
	//Creates a Datetime variable from a Date and a time text.
	function getDatetime(date, time) {
		let timeSplit = time.split(':');
		let hours = timeSplit[0];
		let mins = timeSplit[1];
		return new Date(date.getFullYear(), date.getMonth(), date.getDate(), hours, mins);
	}
	//Formats the Datetime variable to be store in the MySQL database.
	function datetimeToMySQL(date, time) {
		var formattedDate = getDatetime(date, time);
		return formattedDate.toISOString().slice(0, 19).replace('T', ' ');
	}
	//Checks if the text in the time picker is valid as a time.
	function isValidTime(time) {
		let timeSplit = time.split(':');
		let hours = timeSplit[0];
		let mins = timeSplit[1];
		console.log(hours+'...'+mins)
		if (hours>=0 && hours<=23 && mins>=0 && mins<=59) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/***  Adding Calendar Events ***/
	
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
					//console.log('JS\n Name: '+name+'\nStart: '+start+'\nEnd: '+end);
					
					fetch("procesar.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						body: "action=insert&name="+name+"&start="+start+"&end="+end,
					})
					.then(response => response.text())
					.then(data => {console.log("Respuesta del servidor: \n", data);});
					
				} else {
					alert('Debes introducir una hora válida.');
				}
			} else {
				alert('Debes introducir una fecha válida.');
			}
		} else {
			alert('Debes introducir un nombre.');
		}
	};
	
	
	
	/***  Modifying Calendar Events ***/
	
	function eventOnClick(info) {
		// Display event name in input.
		document.getElementById("eventName2").value = info.event.title;
		
		// Display the dates of the event's start and end in the datepickers.
		var startDate = $.datepicker.formatDate("dd/mm/yy", info.event.start);
		var endDate = $.datepicker.formatDate("dd/mm/yy", info.event.end);
		$("#datepickerStart2").datepicker("setDate", startDate);
		$("#datepickerEnd2").datepicker("setDate", endDate);
		
		// Display the time of the event's start and end in the input.
		document.getElementById('timeStart2').value =	toDoubleDigits(info.event.start.getHours()) +':'+ toDoubleDigits(info.event.start.getMinutes());
		if (info.event.end!=null) {
			document.getElementById('timeEnd2').value =	toDoubleDigits(info.event.end.getHours()) +':'+ toDoubleDigits(info.event.end.getMinutes());
		} else {
			document.getElementById('timeEnd2').value =	'';
		}
		
		// Log the event and save in localStorage for modifying later.
		console.log('Event selected.\n Name: ' + info.event.title + '\n Start: ' + startDate + '\n End: ' + endDate);
		setEventID(info.event.id);
	}
	
	function toDoubleDigits(num) {
		if (num<10) return ('0'+num);
		else return num;
	}
	
	function modifyEvent() {
		var event_id = getEventID();
		if (event_id!=null) {
			var event = calendar.getEventById(event_id);
			if (event!=null) {
				
				var name = document.getElementById("eventName2").value;
				var start = $("#datepickerStart2").datepicker("getDate");
				var end =   $("#datepickerEnd2").datepicker("getDate");
				
				let startTime = document.getElementById('timeStart2').value.split(':');
				let startHour = startTime[0];
				let startMin = startTime[1];
				let newStart = new Date(start.getFullYear(), start.getMonth(), start.getDate(), startHour, startMin);
				event.setStart(newStart);
				console.log('Event '+name+' changed start to:\n '+newStart);
				
				if (end!=null) {
					let endTime = document.getElementById('timeEnd2').value.split(':');
					let endHour = endTime[0];
					let endMin = endTime[1];
					let newEnd = new Date(end.getFullYear(), end.getMonth(), end.getDate(), endHour, endMin);
					event.setEnd(newEnd);
					console.log('Event '+name+' changed end to:\n '+newEnd);
				}
				
				/*
				fetch("procesar.php", {
					method: "POST",
					headers: {
						"Content-Type": "application/x-www-form-urlencoded"
					},
					body: "action=insert&name="+name+"&start="+start+"&end="+end,
				})
				.then(response => response.text())
				.then(data => {console.log("Respuesta del servidor: \n", data);});
				*/
				
			} else {
				console.log('Event is null');
			}
		} else {
			console.log('Event id not found');
		}
	}



