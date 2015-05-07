<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Выбираем условия</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/jquery-ui.css">
		<script src="js/jquery-2.1.0.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<h1>Выбираем условия</h1>
			<div id="result"></div>
			<form class="form-horizontal" role="form" action="calculate2.php" method="post">
				<div class="form-group">
					<label for="temperature" class="col-md-4 control-label">Температура:</label>
					<div class="col-md-1">
						<select name="temperature" id="temperature" class="form-control">
							<option value="0">25</option>
							<option value="1">30</option>
							<option value="2">35</option>
							<option value="3">40</option>
							<option value="4">45</option>
							<option value="5">50</option>
							<option value="6">55</option>
							<option value="7">60</option>
						</select>
					</div>
					<div class="col-md-1">
						<p>°C</p>
					</div>
				</div>
				<div class="form-group">
					<label for="environment" class="col-md-4 control-label">Условия эксплуатации:</label>
					<div class="col-md-2">
						<?php
							include ("db.php");
							global $mysqli;
							echo "<select name=\"environment\" id=\"environment\" class=\"form-control\">";
							$sql = "SELECT * FROM `mechanicheskoe_vozdeistvie`";
							$result = $mysqli->query($sql);
							while ($row = $result->fetch_row())
							{
								echo '<option value="'.$row['0'].'">'.$row['0'];
							}
							$result->close();
							$mysqli->close();
							echo "</select>";
						?>
					</div>
					<label class="radio-inline">
						<input type="radio" name="pri" id="pri" value="vibraciya" checked="checked"> при вибрации
					</label>
					<label class="radio-inline">
						<input type="radio" name="pri" id="pri" value="udarn_nagr"> при ударных нагрузках
					</label>
					<label class="radio-inline">
						<input type="radio" name="pri" id="pri" value="summarnoe"> суммарное воздействие
					</label>
				</div>
				<fieldset disabled>
					<div class="form-group">
						<label for="vlazhnost" class="col-md-4 control-label">Влажность:</label>
						<div class="col-md-1">
							<select name="vlazhnost" id="vlazhnost" class="form-control">
								<option value="">60..70</option>
								<option value="">90..98</option>
							</select>
						</div>
						<div class="col-md-1">
							<p>%</p>
						</div>
					</div>
				</fieldset>
				<div class="form-group">
					<label for="nagruzka_po_napr" class="col-md-4 control-label">Коэффициент нагрузки по напряжению:</label>
					<div class="col-md-2">
						<select name="nagruzka_po_napr" id="nagruzka_po_napr" class="form-control">
							<option value="0">0.2</option>
							<option value="1">0.4</option>
							<option value="2">0.6</option>
							<option value="3">0.8</option>
							<option value="4">1.0</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="vysota" class="col-md-4 control-label">Высота:</label>
					<div class="col-md-2">
						<select name="vysota" id="vysota" class="form-control">
							<option value="1.0">0..1</option>
							<option value="1.05">1..2</option>
							<option value="1.10">2..3</option>
							<option value="1.14">3..5</option>
							<option value="1.16">5..6</option>
							<option value="1.20">6..8</option>
							<option value="1.25">8..10</option>
							<option value="1.30">10..15</option>
							<option value="1.35">15..20</option>
							<option value="1.38">20..25</option>
							<option value="1.40">25..30</option>
							<option value="1.45">30..40</option>
						</select>
					</div>
					<div class="col-md-1">
						<p>км</p>
					</div>
				</div>
				<div class="form-group">
					<label for="t_expl" class="col-md-4 control-label">Время эксплуатации:</label>
					<div class="col-md-2">
						<input type="text" class="form-control" name="t_expl">
					</div>
					<div class="col-md-1">
						<p>ч</p>
					</div>
				</div>
				<div class="form-group">
					<label for="pryamoy_tok" class="col-md-4 control-label">Рабочая величина среднего прямого тока через диод:</label>
					<div class="col-md-2">
						<input type="text" class="form-control" name="pryamoy_tok">
					</div>
					<div class="col-md-1">
						<p>А</p>
					</div>
				</div>
				<div class="form-group">
					<label for="rabochee_napr" class="col-md-4 control-label">Рабочее напряжение (конденсатор):</label>
					<div class="col-md-2">
						<input type="text" class="form-control" name="rabochee_napr">
					</div>
					<div class="col-md-1">
						<p>В</p>
					</div>
				</div>
				<div class="form-group">
					<label for="korpus" class="col-md-4 control-label">Материал корпуса:</label>
					<div class="col-md-2">
						<select name="korpus" id="korpus" class="form-control">
							<option value="3.0">пластмасса</option>
							<option value="1.0">металл</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="priemka" class="col-md-4 control-label">Приемка:</label>
					<div class="col-md-2">
						<label class="radio-inline">
							<input type="radio" name="priemka" id="priemka" value="1" checked="checked"> 5
						</label>
						<label class="radio-inline">
							<input type="radio" name="priemka" id="priemka" value="0.285"> 9
						</label>
					</div>
				</div>
				
				<input type="hidden" name="level" value="<?php echo $_GET['level'] ?>"/>
				<input type="hidden" name="circuit" value="<?php echo $_GET['circuit'] ?>"/>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-2">
						<button class="btn btn-default" id="submit">Расчет</button>
					</div>
				</div>
			</form>
			<br>
			<a href="index.php" class="btn btn-default">На главную</a>
		</div>
	</body>
</html>