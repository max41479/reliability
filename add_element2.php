<?php
	session_start();
	if($_POST)
	{
		//check if its an ajax request, exit if not
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			die();
		} 
		
		//check $_POST vars are set, exit if any missing
		
		if(!isset($_POST["level"]) || !isset($_POST["circuit"]) || !isset($_POST["element_id"]) || !isset($_POST["category_id"]) || !isset($_POST["name"]) || !isset($_POST["position"]) || !isset($_POST["amount"]))
		{
			header('HTTP/1.1 500 Oh some field is missing!');
			echo 'Oh some field is missing!';
			exit();
		}

		//Sanitize input data using PHP filter_var().
		$name = $_POST["name"];
		$level = (int) $_POST["level"];
		$circuit = (int) $_POST["circuit"];
		$element_id = (int) $_POST["element_id"];
		$category_id = (int) $_POST["category_id"];
		$position = (int) $_POST["position"];
		$amount = (int) $_POST["amount"];
		$load_coefficient_diode = (float) $_POST["load_coefficient_diode"];
		$load_coefficient_capacitor = (float) $_POST["load_coefficient_capacitor"];
		$load_coefficient_resistor = (float) $_POST["load_coefficient_resistor"];
		$korpus = (float) $_POST["korpus"];

		
		//additional php validation
		if(!is_numeric($level)) //check entered data is numbers
		{
			header('HTTP/1.1 500 Only numbers allowed in level field');
			echo 'Only numbers allowed in level field';
			exit();
		}
		if(!is_numeric($circuit)) //check entered data is numbers
		{
			header('HTTP/1.1 500 Only numbers allowed in circuit field');
			echo 'Only numbers allowed in circuit field';
			exit();
		}
		if($element_id == 0) //check entered data is numbers
		{
			header('HTTP/1.1 500 Element was not selected');
			echo 'Элемент не выбран';
			exit();
		}
		if(!is_numeric($position)) //check entered data is numbers
		{
			header('HTTP/1.1 500 Only numbers allowed in position field');
			echo 'В поле позиции разрешены только цифры';
			exit();
		}
		if(!is_numeric($amount)) //check entered data is numbers
		{
			header('HTTP/1.1 500 Only numbers allowed in amount field');
			echo 'В поле количества разрешены только цифры';
			exit();
		}
		//proceed
		include "db.php";
		include "functions.php";
		add_element($level, $circuit, $element_id, $category_id, $name, $position, $amount, $load_coefficient_diode, $load_coefficient_capacitor, $load_coefficient_resistor, $korpus);
		$mysqli->close();
	}
?>