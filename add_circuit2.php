<?php
	session_start();
	if($_POST)
	{
		//check if its an ajax request, exit if not
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			die();
		} 
		
		//check $_POST vars are set, exit if any missing
		if(!isset($_POST["circuit_name"]) || !isset($_POST["level_id"]))
		{
			die();
		}

		//Sanitize input data using PHP filter_var().
		$circuit_name = $_POST["circuit_name"];
		$level_id = $_POST["level_id"];
		
		//additional php validation
		if(strlen($circuit_name) < 3) // If length is less than 4 it will throw an HTTP error.
		{
			header('HTTP/1.1 500 Name too short or empty!');
			echo 'Название слишком короткое либо пустое!';
			exit();
		}
		if(!is_numeric($level_id)) //check entered data is numbers
		{
			header('HTTP/1.1 500 Only numbers allowed in level field');
			echo 'Only numbers allowed in level field';
			exit();
		}
		
		//proceed
		include "db.php";
		include "functions.php";
		add_circuit($level_id, $circuit_name);
		$mysqli->close();
	}
?>