<?php
	include ("db.php");
	global $mysqli;
	if(strlen($_POST["nazvanie"]) < 3) // If length is less than 4 it will throw an HTTP error.
	{
		header('HTTP/1.1 500 Name too short or empty!');
		echo "Название отсутствует, либо короче 3х симовлов";
		exit();
	}
	if(!is_numeric($_POST["category_id"]) or $_POST["category_id"] == -1) //check entered data is numbers
	{
		header('HTTP/1.1 500 Only numbers allowed in category_id field');
		echo 'Категория не выбрана';
		exit();
	}
	if(!is_numeric($_POST["type_id"])  or $_POST["type_id"] == -1)
	{
		header('HTTP/1.1 500 Only numbers allowed in type_id field');
		echo 'Подтип не выбран';
		exit();
	}
	if(!is_numeric($_POST["bazov_int"])) //check entered data is numbers
	{
		header('HTTP/1.1 500 Only numbers allowed in bazov_int field');
		echo 'Базовая интенсивность отказов не введена, либо поле содержит не цифры';
		exit();
	}
	$sql = "insert into spravochnik (nazvanie, elementtype, intensivnost, int_hran,kolichestvo, variant, group_id) values 
		('" . $_POST["nazvanie"] . "', '" . $_POST["category_id"] . "', '" . $_POST["bazov_int"] . "', '0', '0', '0', '" . $_POST["type_id"] . "')";
	$result = $mysqli->query($sql);
	if (!$result)
	{
		header('HTTP/1.1 500 Internal Server Error');
		echo ($mysqli->error);
		exit();
	}
	else
	{
		unset ($result);
		echo "<p>Элемент ", $_POST["nazvanie"], " успешно добавлен</p>";
	}
	
?>
