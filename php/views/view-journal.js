	

	function onLoadJournal() {
		fetch("../db/procesar.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "table=journal&action=get",
		})
		.then(response => response.json())
        .then((json) => createTable(json));
    }
	
    function createTable(elements) {
		var tbodyRef = document.getElementById('note-list').getElementsByTagName('tbody')[0];
		var textArea = document.getElementById('note-textarea');
		var contentArea = document.getElementById('note-content');
		contentArea.style.display = "none";
        for (let i=0; i<elements.length; i++) {
            var newRow = tbodyRef.insertRow();
			let cell1 = newRow.insertCell(0);
			let cell2 = newRow.insertCell(1);
			let cell3 = newRow.insertCell(2);
			cell1.id = 'journal-table-date';
			cell1.innerHTML = elements[i].date;
            cell2.innerHTML = elements[i].title;
			cell3.id = 'table-delete-btn';
			cell3.innerHTML = '<button class="btn btn-danger" onclick="removeJournalEntry()">-</buton>';
			
			var createClickHandler = function(cell) {
				return function() {
					// If the content is hidden, show it.
					if (contentArea.style.display === "none") {
						contentArea.style.display = "block";
					}
					// Set all the values so that the note can be modified.
					setJEntryID(elements[i].id);
					textArea.value = elements[i].content;
					document.getElementById('note-title').value = elements[i].title;
					document.getElementById('note-date').innerHTML = elements[i].date_modified;
					var date = $.datepicker.formatDate("dd/mm/yy", new Date(elements[i].date));
					$("#datepicker").datepicker("setDate", date);
					// Show the appropiate button.
					document.getElementById("saveButton").style.display = "block";
					document.getElementById("createButton").style.display = "none";
				};
			};
			cell1.onclick = createClickHandler(cell1);
			cell2.onclick = createClickHandler(cell2);
        }
		
		setJEntryID(null);
    }
	
	
	
	/* Closes the note content */
	
	function closeContent() {
		var contentArea = document.getElementById('note-content');
		contentArea.style.display = "none";
		setJEntryID(null);
	}
	
	
	
	
	
	/* Creates a new note. */
	
	function openContentToCreate() {
		const c_date = dateToMySQL(new Date());
		setJEntryID(null)
		
		document.getElementById('note-content').style.display = "block";
		document.getElementById("saveButton").style.display = "none";
		document.getElementById("createButton").style.display = "block";
		
		document.getElementById('note-title').value = 'Nueva entrada';
		document.getElementById('note-textarea').value = '...';
		document.getElementById('note-date').innerHTML = c_date;
	}
	
	function createJournalEntry() {
		const m_date = dateToMySQL(new Date());
		
		var title	= document.getElementById('note-title').value;
		var content	= document.getElementById('note-textarea').value;
		var c_date	= document.getElementById('note-date').innerHTML;
		
		const date	= $("#datepicker").datepicker("getDate");
		let month	= toDoubleDigits(Number.parseInt(date.getMonth())+1);
		let day		= toDoubleDigits(date.getDate());
		const formattedDate	= date.getFullYear()+'-'+month+'-'+day;
		const date_exists	= isDateInJournal(formattedDate);
		
		if (date_exists==false) {
			fetch("../db/procesar.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				body: "table=journal&action=insert&title="+title+"&content="+content+"&date="+formattedDate+"&created="+c_date+"&modified="+m_date,
			})
			.then(response => response.text())
			.then(data => {console.log("Respuesta del servidor: \n", data);});
			
			refresh();
		} else {
			alert('Ya hay una entrada de diario para ese día');
		}
	}
	// Checks that if date given is already used in the journal.
	function isDateInJournal(fdate) {
		
		fetch("../db/procesar.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "table=journal&action=getdates",
		})
		.then(response => response.json())
		.then(json => {setJDates(json); console.log(json);});
		
		var found = false;
		var json = getJDates();
		
		for (let i=0; i<json.length; i++) {
			if (json[i].date == fdate) {
				found = true;
			}
		}
		return found;
	}
	
	
	
	
	
	/* Modify the note selected and save it to the database. */
	
	function updateJournalEntry() {
		if (getJEntryID()!=null) {
			
			var title = document.getElementById('note-title').value;
			var content = document.getElementById('note-textarea').value;
			var date = new Date();
			var newDate = dateToMySQL(date);
			
			fetch("../db/procesar.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				body: "table=journal&action=update&id="+getJEntryID()+"&title="+title+"&content="+content+"&modified="+newDate,
			})
			.then(response => response.text())
			.then(data => {console.log("Respuesta del servidor: \n", data);});
			
			refresh();
		}
	}
	
	
	
	
	
	/* Delete the journal entry selected from the database. */
	
	function removeJournalEntry() {
		if (getJEntryID()!=null) {
			if (confirm("¿Seguro que quieres borrar esta entrada de diario?")) {
				
				fetch("../db/procesar.php", {
					method: "POST",
					headers: {
						"Content-Type": "application/x-www-form-urlencoded"
					},
					body: "table=journal&action=delete&id="+getJEntryID(),
				})
				.then(response => response.text())
				.then(data => {console.log("Respuesta del servidor: \n", data);});
				
				refresh();
			}
		}
	}
	
	
	