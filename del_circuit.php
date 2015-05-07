<?php
	session_start();
	include "db.php";
	include "functions.php";
	global $mysqli;
	del_circuit($_POST['id'], $_POST['level']);
	$mysqli->close();
?>