<?php
session_start();
include "db.php";
include "functions.php";
global $mysqli;
if (!isset($_POST['circuit_id']) && !isset($_POST['element_id'])) {  //deletion of level
	del($_POST['level_id'], "", "");
}
else if (!isset($_POST['element_id'])) {  //deletion of circuit
	del($_POST['level_id'], $_POST['circuit_id'], "");
}
else {  //deletion of element
	del($_POST['level_id'], $_POST['circuit_id'], $_POST['element_id']);
}
$mysqli->close();