<?php
function add_level($name)
{
	if (empty($_SESSION['levels']))
	{
		$_SESSION['levels'] = array();
		$_SESSION['levels'][] = $name;
	}
	else
	{
		$_SESSION['levels'][] = $name;
	}
	end($_SESSION['levels']);
	echo "Добавлен уровень с ID " . key($_SESSION['levels']) . "<br />";
}

function add_circuit($level, $name)
{
	if (empty($_SESSION['circuits']))
	{
		$_SESSION['circuits'] = array();
		$_SESSION['circuits'][$level][] = $name;
	}
	else
	{
		$_SESSION['circuits'][$level][] = $name;
	}
	end($_SESSION['circuits'][$level]);
	echo "Добавлена схема с ID " . key($_SESSION['circuits'][$level]) . "<br />";
}

function add_element($level, $circuit, $id, $category_id, $name, $position, $amount)
{
	if (empty($_SESSION['elements'][$level][$circuit]))
	{
			$_SESSION['elements'][$level][$circuit] = array();
			$_SESSION['elements'][$level][$circuit][$id] = array('name' => $name, 'category_id' => $category_id, 'position' => $position, 'amount' => $amount);
			end($_SESSION['elements'][$level][$circuit]);
			echo "Добавлен элемент с ID " . key($_SESSION['elements'][$level][$circuit]) . "<br />";
	}
	else
	{
		if(!array_key_exists($id, $_SESSION['elements'][$level][$circuit]))
		{
			$_SESSION['elements'][$level][$circuit][$id] = array('name' => $name, 'category_id' => $category_id, 'position' => $position, 'amount' => $amount);
			end($_SESSION['elements'][$level][$circuit]);
			echo "Добавлен элемент с ID " . key($_SESSION['elements'][$level][$circuit]) . "<br />";
		}
		else
		{
			header('HTTP/1.1 500 Internal Server Error');
			echo "Элемент с ID " . key($_SESSION['elements'][$level][$circuit]) . " уже существует<br />";
		}
	}
}

function del($level_id, $circuit_id, $element_id) //todo: replace Internal Server Error with meaningful message
{
	if ( ($circuit_id == "") && ($element_id == "") ) //deletion of level
	{
		if(!isset($_SESSION['circuits'][$level_id]))
		{
			if (!isset($_SESSION['levels'][$level_id]))
			{
				header('HTTP/1.1 500 Level "' . $_SESSION['levels'][$level_id] . '" does not exists.');
				echo "Уровень \"" . $_SESSION['levels'][$level_id] . "\" не существует.<br />";
			}
			else
			{
				echo "Уровень \"" . $_SESSION['levels'][$level_id] . "\" успешно удален.<br />";
				unset($_SESSION['levels'][$level_id]);
			}
		}
		else
		{
			header('HTTP/1.1 500 Level "' . $_SESSION['levels'][$level_id] . '" contain elements.');
			echo "Уровень \"" . $_SESSION['levels'][$level_id] . "\" содержит элементы.<br />";
			exit();
		}
	}
	else if ( $element_id == "" ) //deletion of circuit
	{
		if(!isset($_SESSION['elements'][$level_id][$circuit_id]))
		{
			if (!isset($_SESSION['circuits'][$level_id][$circuit_id]))
			{
				header('HTTP/1.1 500 Circuit "' . $_SESSION['circuits'][$level_id][$circuit_id] . '" does not exists.');
				echo "Схема \"" . $_SESSION['circuits'][$level_id][$circuit_id] . "\" не существует.<br />";
			}
			else
			{
				echo "Схема \"" . $_SESSION['circuits'][$level_id][$circuit_id] . "\" успешно удалена.<br />";
				unset($_SESSION['circuits'][$level_id][$circuit_id]);
				if (empty( $_SESSION['circuits'][$level_id]))
				{
					unset($_SESSION['circuits'][$level_id]);
				}
			}
		}
		else
		{
			header('HTTP/1.1 500 Circuit "' . $_SESSION['circuits'][$level_id][$circuit_id] . '" contain elements.');
			echo "Схема \"" . $_SESSION['circuits'][$level_id][$circuit_id] . "\" содержит элементы.<br />";
		}
	}
	else //deletion of element
	{
		if (!isset($_SESSION['elements'][$level_id][$circuit_id][$element_id]))
		{
			header('HTTP/1.1 500 Element "' . $_SESSION['elements'][$level_id][$circuit_id][$element_id] . '" does not exists.');
			echo "Элемент \"" . $_SESSION['elements'][$level_id][$circuit_id][$element_id] . "\" не существует<br />";
		}
		else
		{
			echo "Элемент \"" . $_SESSION['elements'][$level_id][$circuit_id][$element_id]['name'] . "\" успешно удален<br />";
			unset($_SESSION['elements'][$level_id][$circuit_id][$element_id]);
			if (empty( $_SESSION['elements'][$level_id][$circuit_id]))
			{
				unset($_SESSION['elements'][$level_id]);
			}
		}
	}
}