

	function onLoadNotes() {
		if (getOrder()==null)		{setOrder('title');}
		if (getOrderSort()==null)	{setOrderSort('ASC');}
		document.getElementById('sort1').value = getOrder();
		document.getElementById('sort2').value = getOrderSort();
		
		fetch("../db/procesar.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "table=notes&action=get&order="+getOrder()+"&sort="+getOrderSort(),
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
			let cell4 = newRow.insertCell(3);
			cell1.id = 'note-table-color';
			cell1.innerHTML = ' ';
			cell1.style.backgroundColor = elements[i].color;
			cell2.id = 'note-table-title';
			cell2.innerHTML = elements[i].title;
			cell3.innerHTML = elements[i].date_created;
			cell4.id = 'table-delete-btn';
			cell4.innerHTML = '<button class="btn btn-danger" onclick="removeNote()">-</buton>';
			
			var createClickHandler = function(cell) {
				return function() {
					// If the content is hidden, show it.
					if (contentArea.style.display === "none") {
						contentArea.style.display = "block";
					}
					// Set all the values so that the note can be modified.
					setNoteID(elements[i].id);
					textArea.value = elements[i].content;
					document.getElementById('note-title').value = elements[i].title;
					document.getElementById('note-date').innerHTML = elements[i].date_modified;
					document.getElementById('colorpicker').value = elements[i].color;
				};
			};
			cell1.onclick = createClickHandler(cell1);
			cell2.onclick = createClickHandler(cell2);
			cell3.onclick = createClickHandler(cell3);
        }
		
		setNoteID(null);
    }
	
	
	
	/* When a new note order is selected */
	
	function onOrderChange() {
		var order = document.getElementById("sort1").value;
		var sort = document.getElementById("sort2").value;
		setOrder(order);
		setOrderSort(sort);
		
		var tbodyRef = document.getElementById('note-list').getElementsByTagName('tbody')[0];
		tbodyRef.innerHTML = "";
		onLoadNotes();
	}
	
	
	
	/* Closes the note content */
	
	function closeContent() {
		var contentArea = document.getElementById('note-content');
		//if (contentArea.style.display === "block") {
			contentArea.style.display = "none";
		//}
		setNoteID(null);
	}
	
	
	
	
	
	/* Creates a new note. */
	
	function createNote() {
		closeContent();
		
		document.getElementById('note-title').value = 'Nueva nota';
		document.getElementById('note-textarea').value = '...';
		
		var title = document.getElementById('note-title').value;
		var content = document.getElementById('note-textarea').value;
		var color = document.getElementById('colorpicker').value;
		var date = new Date();
		var newDate = dateToMySQL(date);
		
		fetch("../db/procesar.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "table=notes&action=insert&title="+title+"&content="+content+"&color="+color+"&created="+newDate+"&modified="+newDate,
		})
		.then(response => response.text())
		.then(data => {console.log("Respuesta del servidor: \n", data);});
		
		refresh();
	}
	
	
	
	
	
	/* Modify the note selected and save it to the database. */
	
	function updateNote() {
		if (getNoteID!=null) {
			var title = document.getElementById('note-title').value;
			var content = document.getElementById('note-textarea').value;
			var color = document.getElementById('colorpicker').value;
			var date = new Date();
			var formattedDate = dateToMySQL(date);
			
			fetch("../db/procesar.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				body: "table=notes&action=update&id="+getNoteID()+"&title="+title+"&content="+content+"&color="+color+"&modified="+formattedDate,
			})
			.then(response => response.text())
			.then(data => {console.log("Respuesta del servidor: \n", data);});
			
			refresh();
		}
	}
	
	
	
	
	
	/* Delete the note selected from the database. */
	
	function removeNote() {
		if (getNoteID()!=null) {
			if (confirm("¿Seguro que quieres borrar esta nota?")) {
				
				closeContent();
				
				fetch("../db/procesar.php", {
					method: "POST",
					headers: {
						"Content-Type": "application/x-www-form-urlencoded"
					},
					body: "table=notes&action=delete&id="+getNoteID(),
				})
				.then(response => response.text())
				.then(data => {console.log("Respuesta del servidor: \n", data);});
				
				refresh();
			}
		} else {
			alert('Note not selected');
		}
	}
	
	