	var calendar;
	
	function loadCalendar() {
		var calendarDiv = document.getElementById('calendar');
		calendar = new FullCalendar.Calendar(calendarDiv, {
			themeSystem: 'bootstrap5',
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
			/*events: [
				{
				title: 'All Day Event',
				start: '2025-05-01',
				},
				{
				title: 'Long Event',
				start: '2025-01-07',
				end: '2025-05-10'
				},
				{
				groupId: 999,
				title: 'Repeating Event',
				start: '2025-05-09T16:00:00'
				},
				{
				groupId: 999,
				title: 'Repeating Event',
				start: '2025-05-16T16:00:00'
				},
				{
				title: 'Conference',
				start: '2023-05-11',
				end: '2025-05-13'
				},
				{
				title: 'Meeting',
				start: '2023-05-12T10:30:00',
				end: '2025-05-12T12:30:00'
				},
				{
				title: 'Lunch',
				start: '2025-05-12T12:00:00'
				},
				{
				title: 'Dinner',
				start: '2025-05-12T20:00:00'
				},
				{
				title: 'Birthday Party',
				start: '2025-05-13T07:00:00'
				},
				{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2025-05-28'
				}
			],*/
			eventClick: function(info) {eventOnClick(info)},
		});
		calendar.render();
		getEventsFromDatabase();
		
		setEventID(null);
	};
	
	
	
	/*** LocalStorage functions ***/
	
	function getEventID()		{return localStorage.getItem('event-id-to-modify');}
	function setEventID(newID)	{localStorage.setItem('event-id-to-modify', newID);}
	
	
	
	/*** Modal pop-up ***/
	
	function openModal() {
		var myModal = new bootstrap.Modal(document.getElementById('demo'), {})
		myModal.toggle()
	};
	
	
	
	/***  Adding Calendar Events ***/
	
	function addEvent() {
		var name = document.getElementById("eventName1").value;
		var startDate = $("#datepickerStart1").datepicker("getDate");
		var endDate = $("#datepickerEnd1").datepicker("getDate");
		
		if (startDate!=null && endDate!=null) {
			if ( !isNaN(startDate.valueOf()) || !isNaN(endDate.valueOf()) ) {
				calendar.addEvent({
					title: name,
					start: startDate,
					end: endDate,
					allDay: true
				});
				console.log('Event created.\n Name: ' + name + '\n Start: ' + startDate + '\n End: ' + endDate);
			} else {
				console.log('Event not created.');
			}
		} else {
			console.log('Event not created.');
		}
		
		//DB
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
		
		//DB
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
			} else {
				console.log('Event is null');
			}
		} else {
			console.log('Event id not found');
		}
	}
	
	
	
	function getEventsFromDatabase() {
		//
	}
	
	
	