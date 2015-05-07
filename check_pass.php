<!DOCTYPE html>
<style type="text/css">
P {
 margin: 2em 35px 1em /* Отступ сверху, справа-слева и снизу */
 }
 </style>
<?php 
	/*проверяем, заполнены ли все поля формы*/
	if ($_POST['password'] == "")
	/*если не заполнены, выводится сообщение*/
	{
		echo "<p>Пароль не введен!</p>";
		exit (); /*и программа останавливается*/
	}
	$right_pass = "nad";
	if ($_POST['password'] == $right_pass)
	{
		include("add.php");
	}
	else
	{
		echo "<p>неправильный пароль</p>";
	}
?>