<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Администраторский раздел</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/jquery-ui.css">
		<script src="js/jquery-2.1.0.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<style>
		li {
			padding: 1px;
		}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="container">
				<h1>Администраторский раздел</h1>
				<form class="form-horizontal" role="form" action="check_pass.php" method="post">
					<div class="form-group">
						<label for="password" class="col-md-4 control-label">введите пароль:</label>
						<div class="col-md-2">
							<input type="password" class="form-control" name="password" id="password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-4 col-md-2">
							<button class="btn btn-default" id="submit">Вход</button>
						</div>
					</div>
				</form>
			</div>
			<a href="index.php" class="btn btn-default">На главную</a>
		</div>
	</body>
</html>