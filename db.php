<?php
include "config.php";
$mysqli = new mysqli($host, $login, $pass, $db);
/* проверка соединения */
if ($mysqli->connect_errno) {
	printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
	exit();
}
$mysqli->query('SET NAMES utf8');