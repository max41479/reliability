<?php
	include('db.php');
	global $mysqli;
	$type = $_POST['type'];
	$group_id = $_POST['group_id'];

	$result = $mysqli->query("SELECT id, nazvanie FROM `spravochnik` WHERE elementtype = " . $type . " AND group_id = " . $group_id);
	if($result->num_rows != 0)
	{
		echo '<option value="0" selected disabled>Выберите элемент</option>';
		while ($row = $result->fetch_assoc())
		{
			echo '<option value="' . $row['id'] . '">' . $row['nazvanie'] . '</option>';
		}
	}
	else
	{
		header('HTTP/1.1 500 Internal Server Error');
		echo '<option>Элементов такого типа нет</option>';
	}
?>