<?php
@session_start();
include "db.php";
include "functions.php";
if (!empty($_SESSION['levels']))
{
	$sql = "SELECT * FROM element_types";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc())
	{
		$element_types[$row['id']] = $row['name'];
	}
	$result->close();
	$levels = $_SESSION['levels'];
	foreach ($levels as $lvl_id => $lvl_name)
	{
		if (!empty($levels[$lvl_id]))
		{
			echo '<li data-value="level-' . $lvl_id . '"><span><a href="#" class="add_circuit"><span class="glyphicon glyphicon-plus" aria-hidden="true" data-toggle="tooltip" title="Добавить плату"></span></a> ' . $lvl_name . '<button type="button" name="close" class="close" style="display: none; color: red; margin-left: 3px;" data-toggle="tooltip" title="Удалить уровень">&times;</button></span>';

			if (!empty($_SESSION['circuits'][$lvl_id]))
			{
				$circuits = $_SESSION['circuits'];
				echo '<ul id="level-' . $lvl_id . '">';
				foreach ($circuits[$lvl_id] as $circuit_id => $circuit_name)
				{
					if (!empty($_SESSION['elements'][$lvl_id][$circuit_id]))
					{
						echo '<li data-value="circuit-' . $lvl_id . '-' . $circuit_id . '"><span><a href="#" class="add_element"><span class="glyphicon glyphicon-plus" aria-hidden="true" data-toggle="tooltip" title="Добавить элемент"></span></a> ' . $circuit_name . ' <a href="calculate.php?level=' . $lvl_id . '&circuit=' . $circuit_id . '">[расчет]</a><button type="button" name="close" class="close" style="display: none; color: red; margin-left: 3px;" data-toggle="tooltip" title="Удалить плату">&times;</button></span>';
						$elements = $_SESSION['elements'];
						echo '<ul id="elements-' . $lvl_id . '-' . $circuit_id . '">';
						foreach ($elements[$lvl_id][$circuit_id] as $element_id => $element)
						{
							echo '<li data-value="element-' . $lvl_id . '-' . $circuit_id . '-' . $element_id . '"><span>' . $element['name'] . ' <span class="label label-default">'. $element_types[$element['category_id']] . '</span> x ' . $element['amount'] . '<button type="button" name="close" class="close" style="display: none; color: red; margin-left: 3px;" data-toggle="tooltip" title="Удалить элемент">&times;</button></span>';
						}
						echo '</ul>';
					}
					else
					{
						echo '<li data-value="circuit-' . $lvl_id . '-' . $circuit_id . '"><span><a href="#" class="add_element"><span class="glyphicon glyphicon-plus" aria-hidden="true" data-toggle="tooltip" title="Добавить элемент"></span></a> ' . $circuit_name . ' <button type="button" name="close" class="close" style="display: none; color: red; margin-left: 3px;" data-toggle="tooltip" title="Удалить плату">&times;</button></span>';
					}
				}
				echo "</ul>";
			}
			echo "</li>";
		}
	}
}
$mysqli->close();
