<?php
	session_start();
	if($_POST)
	{
		//check if its an ajax request, exit if not
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			die();
		} 
		
		//check $_POST vars are set, exit if any missing
		if(!isset($_POST["name"]))
		{
			die();
		}

		//Sanitize input data using PHP filter_var().
		$name = $_POST["name"];
		
		//additional php validation
		if(strlen($name)<3) // If length is less than 4 it will throw an HTTP error.
		{
			header('HTTP/1.1 500 Name too short or empty!');
			echo "Название слишком короткое либо пустое!";
			exit();
		}
		
		//proceed
		include "db.php";
		include "functions.php";
		add_level($name);
		$mysqli->close();
	}
?>