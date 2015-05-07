<?php
	session_start();
	include "db.php";
	include "functions.php";
	global $mysqli;
	del_level($_POST['id']);
	$mysqli->close();
?>