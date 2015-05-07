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

function del_level($id)
{
	if(empty($_SESSION['circuits'][$id]))
	{
		if (empty($_SESSION['levels'][$id]))
		{
			header('HTTP/1.1 500 Internal Server Error');
			echo "уровень с ID " . $id . " не существует<br />";
		}
		else
		{
			unset($_SESSION['levels'][$id]);
			echo "уровень с ID " . $id . " успешно удален<br />";
		}
	}
	else
	{
		header('HTTP/1.1 500 Internal Server Error');
		echo "уровень с ID " . $id . " содержит элементы<br />";
		exit();
	}

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

function del_circuit($id, $level)
{
	if(empty($_SESSION['elements'][$level][$id]))
	{
		if (empty($_SESSION['circuits'][$level][$id]))
		{
			header('HTTP/1.1 500 Internal Server Error');
			echo "схема с ID " . $id . " не существует<br />";
		}
		else
		{
			unset($_SESSION['circuits'][$level][$id]);
			echo "схема с ID " . $id . " успешно удалена<br />";
		}
	}
	else
	{
		header('HTTP/1.1 500 Internal Server Error');
		echo "схема с ID " . $id . " содержит элементы<br />";
	}
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
			echo "Элемент с ID " . key($_SESSION['elements'][$level][$circuit]) . " уже существует<br />";
		}
	}
}

function del_element($level, $circuit, $id)
{
	if (empty($_SESSION['elements'][$level][$circuit][$id]))
	{
		header('HTTP/1.1 500 Internal Server Error');
		echo "элемент с ID " . $id . " не существует<br />";
	}
	else
	{
		unset($_SESSION['elements'][$level][$circuit][$id]);
		echo "элемент с ID " . $id . " успешно удален<br />";
	}
}