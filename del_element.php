<?php
	session_start();
	include "db.php";
	include "functions.php";
	global $mysqli;
	del_element($_POST['level'], $_POST['circuit'], $_POST['id']);
	$mysqli->close();
?>