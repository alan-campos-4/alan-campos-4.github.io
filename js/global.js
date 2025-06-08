

	/*** LocalStorage functions ***/
	
	// get and set for the id of calendar event to be modified.
	function getEventID()		{return localStorage.getItem('event-id-to-modify');}
	function setEventID(newID)	{localStorage.setItem('event-id-to-modify', newID);}
	
	// get and set for the id of a note to be modified.
	function getNoteID()		{return localStorage.getItem('note-id-to-modify');}
	function setNoteID(newID)	{localStorage.setItem('note-id-to-modify', newID);}
	
	// get and set for the note sort and sort order.
	function getOrder()			{return localStorage.getItem('note-order');}
	function setOrder(sort)		{localStorage.setItem('note-order', sort);}
	function getOrderSort()			{return localStorage.getItem('note-order-sort');}
	function setOrderSort(order)	{localStorage.setItem('note-order-sort', order);}
	
	// get and set for the id of a journal entry to be modified.
	function getJEntryID()		{return localStorage.getItem('entry-id-to-modify');}
	function setJEntryID(newID)	{localStorage.setItem('entry-id-to-modify', newID);}
	
	// get and set for the all of the dates used in the journal.
	function getJDates()		{return JSON.parse(localStorage.getItem('journal-entry-dates'));}
	function setJDates(dates)	{localStorage.setItem('journal-entry-dates', JSON.stringify(dates));}
	
	
	
	
	/*** Date Formatting functions ***/
	
	//Creates a Date variable from a Date and a time text and adjusts the for the timezone.
	function getDatetime(date, time) {
		let timeSplit = time.split(':');
		let hours = Number.parseInt(timeSplit[0])+2; //UTC+2
		let mins = timeSplit[1];
		let newDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), hours, mins);
		return newDate;
	}
	
	//Formats the date and time strings to be stored in the MySQL database.
	function datetimeToMySQL(date, time) {
		let formattedDate = getDatetime(date, time);
		return formattedDate.toISOString().slice(0, 19).replace('T', ' ');
	}
	
	//Creates a Date variable from a Date object and adjusts the for the timezone.
	function getDatetime(date) {
		let hours = Number.parseInt(date.getHours())+2; //UTC+2
		let newDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), hours, date.getMinutes(), date.getSeconds());
		return newDate;
	}
	
	//Formats the Date variable to be stored in the MySQL database.
	function dateToMySQL(date) {
		let formattedDate = getDatetime(date);
		return formattedDate.toISOString().slice(0, 19).replace('T', ' ');
	}
	
	//Checks if the text in the time picker is valid as a time.
	function isValidTime(time) {
		let timeSplit = time.split(':');
		let hours = timeSplit[0];
		let mins = timeSplit[1];
		if (hours>=0 && hours<=23 && mins>=0 && mins<=59) {
			return true;
		} else {
			return false;
		}
	}
	
	
	
	
	/*** Other functions ***/
	
	
	function toDoubleDigits(num) {
		if (num<10) return ('0'+num);
		else return num;
	}
	
	//Refreshes the page after updating the database.
	function refresh() {
		//setTimeout(function() {location.reload();}, 200);
	}
	
	
	