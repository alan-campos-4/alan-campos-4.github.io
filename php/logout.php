<?php

	session_start();
	if (!isset($_SESSION['usuario'])) {
		header("Location: ../index.php?redirect=true");
	} else {
		session_destroy();
		//localStorage.clear();
		header("Location: ../index.php");
	}

?>