<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Расчет</title>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/black-tie/jquery-ui.css">
		<script src="//code.jquery.com/jquery-2.1.0.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	</head>
	<body>
		<div class="container">
			<h1>Интенсивность отказов:</h1>
			<?php
				include ("db.php");
				$levels						= $_SESSION['levels'];
				$circuits					= $_SESSION['circuits'];
				$elements					= $_SESSION['elements'];
				$intensity					= (double) 0;
				$mech_vozd					= $_POST['environment'];
				$temperature				= (float) $_POST['temperature'];
				$nagruzka_po_napr			= (float) $_POST['nagruzka_po_napr'];
				$pryamoy_tok				= (float) $_POST['pryamoy_tok'];
				$rabochee_napr				= (float) $_POST['rabochee_napr'];
				$vysota						= (float) $_POST['vysota'];
				$korpus						= (float) $_POST['korpus'];
				$priemka					= (float) $_POST['priemka'];
				$t_expl						= (float) $_POST['t_expl'];
				$pri						= $_POST['pri'];
				$level						= $_POST['level'];
				$circuit					= $_POST['circuit'];
				$intensity_is				= 0;
				$intensity_rezist			= 0;
				$intensity_kondensator		= 0;
				$intensity_diod				= 0;
				$intensity_paika			= 0;
				$intensity_transformator	= 0;
				$sql = "SELECT " . $pri . " FROM `mechanicheskoe_vozdeistvie` WHERE usloviya = '" . $mech_vozd . "'";
				$result = $mysqli->query($sql);
				$rez_vozd = $result->fetch_row();
				$result->close();
				$mech_factory = $rez_vozd[0];
				foreach ($elements[$level][$circuit] as $element_id => $element)
				{
					$sql = "SELECT intensivnost, int_hran, elementtype, group_id FROM spravochnik WHERE id = " . $element_id;
					$result2 = $mysqli->query($sql);
					$row2 = $result2->fetch_assoc();
					switch ($row2["elementtype"])
					{
						case 1:
							$sql = "SELECT a, b FROM k_r_is_coefficients WHERE id = " . $row2["group_id"];
							$result = $mysqli->query($sql);
							$row = $result->fetch_assoc();
							$k_rezh_is = $row["a"] * exp($row["b"] * ($temperature + 273));
							$result->close();
							$intensity_is = $intensity_is + $row2["intensivnost"] * $element['amount'] * $k_rezh_is * 14 * $korpus * $mech_factory * $vysota * $priemka;
							break;
						case 2:
							$sql = "SELECT a, b, n_t, g, n_s, j, h FROM k_r_rezist_coefficients WHERE id = " . $row2["group_id"];
							$result = $mysqli->query($sql);
							$row = $result->fetch_assoc();
							$k_rezh_resist = $row['a'] * exp($row['b'] * pow(($temperature + 273) / $row['n_t'], $row['g'])) * exp(pow($nagruzka_po_napr / $row['n_s'] * pow(($temperature + 273) / 273, $row['j']), $row['h']));
							$result->close();
							$intensity_rezist = $intensity_rezist + $row2["intensivnost"] * $element['amount'] * $k_rezh_resist * pow(1.13, $nagruzka_po_napr) * $mech_factory * $vysota * $priemka;
							break;
						case 5:
							$sql = "SELECT a, b, n_t, g, n_s, h FROM k_r_kondensator_coefficients WHERE id = " . $row2["group_id"];
							$result = $mysqli->query($sql);
							$row = $result->fetch_assoc();
							$k_rezh_kondensator = $row['a'] * (pow(($rabochee_napr / 50) / $row['n_s'], $row['h']) + 1) * exp($row['b'] * pow(($temperature + 273) / $row['n_t'], $row['g']));
							$result->close();
							$intensity_kondensator = $intensity_kondensator + $row2["intensivnost"] * $element['amount'] * $k_rezh_kondensator * $mech_factory * $vysota * $priemka;
							break;
						case 4:
							$sql = "SELECT a, n_t, t_m, l, delta_t FROM k_r_diod_coefficients WHERE id = " . $row2["group_id"];
							$result = $mysqli->query($sql);
							$row = $result->fetch_assoc();
							$k_el_diod = $pryamoy_tok / 3;
							$f = 273 + $temperature + (175 - 175) + ($row['delta_t'] * $k_el_diod) / 150 * (175 - 25);
							$k_rezh_diod = $row['a'] * exp($row['n_t'] / $f) * exp(pow($f / $row['t_m'], $row['l']));
							$result->close();
							$intensity_diod = $intensity_diod + $row2["intensivnost"] * $element['amount'] * $k_rezh_diod * pow(1.06, $nagruzka_po_napr) * $mech_factory * $vysota * $priemka;
							break;
						case 3:
						case 6:
						case 7:
						case 8:
						case 9:
						case 10:
							$intensity = $intensity + $row2["intensivnost"] * $element['amount'] * pow(1.12,$temperature) * $mech_factory * $vysota * $priemka;
							break;
						case 11:
							$intensity_paika = $intensity_paika + $row2["intensivnost"] * $element['amount'] * $mech_factory * $vysota * $priemka;
							break;
						case 12:
							$sql = "SELECT a, g, t_m FROM k_r_transformator_coefficients WHERE id = " . $row2["group_id"];
							$result = $mysqli->query($sql);
							$row = $result->fetch_assoc();
							$t_m = $temperature + 35.85;
							$k_rezh_transformator = $row['a'] * exp(pow(($t_m + 273) / $row['t_m'], $row['g']));
							$result->close();
							$intensity_transformator = $intensity_transformator + $row2["intensivnost"] * $element["amount"] * $k_rezh_transformator * $mech_factory * $vysota * $priemka;
							break;
						default:
							exit("element type is not defined");
					}
					//$intensity_storage = $intensity_storage + $row2["int_hran"] * $element['amount'];
					$result2->close();
				}
				$mysqli->close();
				if($intensity_is != 0)
				{
					echo "Интенсивность отказов ИМС: " . $intensity_is . "<br>";
				}
				if($intensity_rezist != 0)
				{
					echo "Интенсивность отказов резисторов: " . $intensity_rezist . "<br>";
				}
				if($intensity_kondensator != 0)
				{
					echo "Интенсивность отказов конденсаторов: " . $intensity_kondensator . "<br>";
				}
				if($intensity_diod != 0)
				{
					echo "Интенсивность отказов диодов: " . $intensity_diod . "<br>";
				}
				if($intensity_paika != 0)
				{
					echo "Интенсивность отказов пайки: " . $intensity_paika . "<br>";
				}
				if($intensity_transformator != 0)
				{
					echo "Интенсивность отказов тансформаторов: " . $intensity_transformator . "<br>";
				}
				if($intensity != 0)
				{
					echo "Интенсивность отказов прочих элементов: " . $intensity . "<br>";
				}
				$intensity = $intensity + $intensity_is + $intensity_rezist + $intensity_kondensator + $intensity_diod + $intensity_paika + $intensity_transformator;
				$lyambda_pict = "<img src='img/lyambda_pict.JPG'width=240 height=30 align = middle>";
				echo "<br>Общая интенсивность отказов: ",$lyambda_pict," = ",round($intensity,8), " 1/ч";
				$VBR = exp(-$intensity * $t_expl);
				$VBR_pict = "<img src='img/VBR_pict.JPG'align = middle>";
				echo " <br>ВБР ",$VBR_pict," = ", round($VBR,7);
				$T_gamma = (1 / $intensity) * log10(100 / 95);
				$T_gamma_pict = "<img src='img/t_gamma_pict.JPG'align = middle>";
				echo " <br>Гамма-процентная наработка до отказа ", $T_gamma_pict," = ", round($T_gamma, 2), " ч <br>";
				echo '<a href="index.php"><button class="btn btn-default">На главную</button></a>';
			?>
		</div>
	</body>
</html>