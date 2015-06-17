<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Добавление элемента</title>
		<link rel="stylesheet" href="css/bootstrap.css">
	</head>
	<body>
		<script src="js/jquery-2.1.4.js"></script>
		<script src="js/bootstrap.js"></script>
		<div class="container">
			<h1>Добавление элемента</h1>
			<div id="result"></div>
			<form class="form-horizontal" role="form" action="add_db.php" method="post">
				<div class="form-group">
					<label for="nazvanie" class="col-md-6 control-label">Название элемента:</label>
					<div class="col-md-3">
						<input type="text" class="form-control" name="nazvanie">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-6 control-label" for="category_id">Выберите категорию</label>
					<div class="col-md-3">
						<select id="category_id" class="form-control">
							<option value="-1 " selected disabled>Выберите категорию</option>
							<?php
								include ("db.php");
								global $mysqli;

								$sql = "SELECT id, name FROM `element_types`";
								$result = $mysqli->query($sql);
								while ($row = $result->fetch_assoc())
								{
									echo '<option value="'.$row['id'].'">'.$row['name'];
								}
								$result->close();
								$mysqli->close();

							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-6 control-label" for="type_id">Выберите подтип</label>
					<div class="col-md-3">
						<select id="type_id" class="form-control" disabled>
							<option value="-1" selected disabled>Выберите тип</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="bazov_int" class="col-md-6 control-label">Базовая интенсивность отказов</label>
					<div class="col-md-3">
						<input type="text" class="form-control" name="bazov_int">
					</div>
					<div class="col-md-3">
						<p>(1.5e-9) 1/ч</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-3">
						<button class="btn btn-default" id="submit">Добавить</button>
					</div>
				</div>
			</form>
			<a href="index.php" class="btn btn-default">На главную</a>
		</div>
		<script>
			$(document).ready(function() {
				$( "#submit" ).click(function(event) {
					event.preventDefault();
					//collect input field values
					var nazvanie = $('input[name=nazvanie]').val();
					var category_id = $('#category_id').val();
					var type_id = $('#type').val();
					var bazov_int = $('input[name=bazov_int]').val();
					//data to be sent to server
					var post_data = {'nazvanie':nazvanie, 'category_id':category_id, 'type_id':type_id, 'bazov_int':bazov_int};
					//Ajax post data to server
					$.post('add_db.php', post_data, function(data){ 
						
						//load success massage in #result div element, with slide effect.       
						$("#result").hide().html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>').slideDown();
						
						//reset values in all input fields
						$('input').val('');
						
					}).fail(function(err) {  //load any error data
						$("#result").hide().html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+err.responseText+'</div>').slideDown();
					});
				});
				$( "#category_id" ).change(function()
				{
					var category_id = $('#category_id').val();
					var post_data = {'id':category_id};
					$.post('list_of_levels.php', post_data, function(data){
						$("#type_id").html(data).prop('disabled', false);
					}).fail(function(err) {  //load any error data
						$("#type_id").html(err.responseText).prop('disabled', true);
					});
				
				});
			});
		</script>
	</body>
</html>
