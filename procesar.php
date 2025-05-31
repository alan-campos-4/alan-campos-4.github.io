<?php
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$action = $_POST['action'] ?? '';
		session_start();
		
		switch ($action) {
        case 'insert':
            insert_db();
            break;
		case 'update':
			update_db();
			break;
		case 'delete':
			delete_db();
			break;
        default:
            echo "Acción no reconocida";
		}
	}
	
	
	/*** Insert event into the database ***/
	function insert_db() {
		$name = $_POST['name'] ?? 'null';
		$start = $_POST['start'] ?? 'null';
		$end = $_POST['end'] ?? 'null';
		echo "PHP\nNombre: $name \n";
		echo "Start: $start \n";
		echo "End: $end \n";
		
		include 'connection.php';
		
		$conn = mysqli_connect($server, $_SESSION['username'], $_SESSION['password'], $database);
		if (!$conn) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "INSERT INTO events (title, start, end) VALUES ('". $name . "', '".$start."', '".$end."')";
		
		if (mysqli_query($conn, $sql)) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
	
	
	/*** Update event from the database ***/
	function update_db() {
		//
	}
	
	
	/*** Delete event from the database ***/
	function delete_db() {
		//
	}
	
	
	
?>