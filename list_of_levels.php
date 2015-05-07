<?php
	include('db.php');
	global $mysqli;
	switch ($_POST['id'])
	{
		case 1:
			$table = "k_r_is_coefficients";
			break;
		case 2:
			$table = "k_r_rezist_coefficients";
			break;
		case 5:
			$table = "k_r_kondensator_coefficients";
			break;
		case 4:
			$table = "k_r_diod_coefficients";
			break;
		case 3:
		case 6:
		case 7:
		case 8:
		case 9:
		case 10:
		case 11:
			$table = "0";
			break;
		case 12:
			$table = "k_r_transformator_coefficients";
			break;
		default:
			echo "неизвестная категория";
	}
	if ($table != "0")
	{
		echo '<option value="-1" selected disabled>Выберите тип</option>';
		$result = $mysqli->query("SELECT id, name FROM " . $table);
		while ($row = $result->fetch_assoc())
		{
			echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
		}
	}
	else
	{
		header('HTTP/1.1 500 Internal Server Error');
		echo '<option value="0">Общий тип</option>';
	}
?>