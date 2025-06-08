<?php
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		$table = $_POST['table'] ?? '';
		$action = $_POST['action'] ?? '';
		session_start();
		
		include 'connection.php';
		
		$conn = mysqli_connect($servername, $user, $pass, $dbname);
		if (!$conn) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		switch ($table) {
			case 'events':
				events_actions();
			break;
			case 'notes':
				notes_actions();
			break;
			case 'journal':
				journal_actions();
			break;
			default:
				echo "Tabla no reconocida";
			break;
		}
		
		mysqli_close($conn);
	}
	
	
	
	
	
	/*** Database operations for calendar events ***/
	
	function events_actions() {
		global $conn, $action;
		
		$id		= $_POST['id'] ?? 'null';
		$name	= $_POST['name'] ?? 'null';
		$start	= $_POST['start'] ?? 'null';
		$end	= $_POST['end'] ?? 'null';
		$color	= $_POST['color'] ?? 'null';
		
		switch ($action) {
			case 'insert': {
				$sql="INSERT INTO events (user_id, title, start, end, color) VALUES (".$_SESSION['user_id'].", '".$name."', '".$start."', '".$end."', '".$color."')";
				if (mysqli_query($conn, $sql)) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			} break;
			
			case 'update': {
				$sql = "UPDATE events SET title='". $name . "', start='".$start."', end='".$end."', color='".$color."' WHERE id=".$id;
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			} break;
			
			case 'delete': {
				$sql = "DELETE FROM events WHERE id=".$id;
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			} break;
			
			default: echo "Acción no reconocida"; break;
		}
	}
	
	
	
	
	
	/*** Database operations for notes ***/
	
	function notes_actions() {
		global $conn, $action;
		
		$id		= $_POST['id'] ?? 'null'; 
		$title	= $_POST['title'] ?? 'null';
		$content	= $_POST['content'] ?? 'null';
		$dcreated	= $_POST['created'] ?? 'null';
		$dmodified	= $_POST['modified'] ?? 'null';
		$color		= $_POST['color'] ?? 'null';
		$order		= $_POST['order'] ?? 'null';
		$sort		= $_POST['sort'] ?? 'null'; 
		
		switch($action) {
			case 'get': {
				$stmt = mysqli_query($conn, "SELECT * FROM notes WHERE user_id=".$_SESSION['user_id']." ORDER BY ".$order." ".$sort);
				$rows = array();
				while($r = mysqli_fetch_assoc($stmt)) {
					$rows[] = $r;
				}
				print json_encode($rows);
			} break;
			
			case 'insert': {
				$sql="INSERT INTO notes (user_id, title, date_created, date_modified, color, content) VALUES (".$_SESSION['user_id'].", '".$title."', '".$dcreated."', '".$dmodified."', '".$color."', '".$content."')";
				if (mysqli_query($conn, $sql)) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			} break;
			
			case 'update': {
				$sql = "UPDATE notes SET title='".$title."', content='".$content."', color='".$color."', date_modified='".$dmodified."' WHERE id=".$id;
				
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			} break;
			
			case 'delete': {
				$sql = "DELETE FROM notes WHERE id=".$id;
				if (mysqli_query($conn, $sql)) {
					echo "Record ".$title." deleted successfully";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			} break;
			
			default: echo "Acción no reconocida"; break;
		}
	}
	
	
	
	
	
	/*** Database operations for journal entries ***/
	
	function journal_actions() {
		global $conn, $action;
		
		$id		= $_POST['id'] ?? 'null'; 
		$title	= $_POST['title'] ?? 'null';
		$content	= $_POST['content'] ?? 'null';
		$date		= $_POST['date'] ?? 'null';
		$dcreated	= $_POST['created'] ?? 'null';
		$dmodified	= $_POST['modified'] ?? 'null';
		$color		= $_POST['color'] ?? 'null';
		
		switch($action) {
			case 'get': {
				$stmt = mysqli_query($conn, "SELECT * FROM journal_entries WHERE user_id=".$_SESSION['user_id']." ORDER BY date DESC");
				$rows = array();
				while($r = mysqli_fetch_assoc($stmt)) {
					$rows[] = $r;
				}
				print json_encode($rows);
			} break;
			
			case 'getdates': {
				$stmt = mysqli_query($conn, "SELECT date FROM journal_entries WHERE user_id=".$_SESSION['user_id']." ORDER BY date DESC");
				$rows = array();
				while($r = mysqli_fetch_assoc($stmt)) {
					$rows[] = $r;
				}
				print json_encode($rows);
			} break;
			
			case 'insert': {
				$sql="INSERT INTO journal_entries (user_id, title, date_created, date_modified, date, content) VALUES (".$_SESSION['user_id'].", '".$title."', '".$dcreated."', '".$dmodified."', '".$date."', '".$content."')";
				if (mysqli_query($conn, $sql)) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			} break;
			
			case 'update': {
				$sql = "UPDATE journal_entries SET title='".$title."', content='".$content."', date_modified='".$dmodified."' WHERE id=".$id;
				if (mysqli_query($conn, $sql)) {
					echo "Record updated successfully";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			} break;
			
			case 'delete': {
				$sql = "DELETE FROM journal_entries WHERE id=".$id;
				if (mysqli_query($conn, $sql)) {
					echo "Record deleted successfully";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			} break;
			
			default: echo "Acción no reconocida"; break;
		}
	}
	
	
	
	
?>