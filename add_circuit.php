<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Добавление платы</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/jquery-ui.css">
		<script src="js/jquery-2.1.0.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<h1>Добавление платы</h1>
			
			<form class="form-horizontal" role="form">
				<div id="result"></div>
				<div class="form-group">
					<label for="name" class="col-md-4 control-label">Введите название платы</label>
					<div class="col-md-2">
						<input type="text" class="form-control" name="name" id="name">
					</div>
				</div>
				<input type="hidden" name="level" value="<?php echo $_GET['level'] ?>"/>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-2">
						<button class="btn btn-default" id="submit">Добавить плату</button>
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
				var name = $('input[name=name]').val();
				var level = $('input[name=level]').val();
				//data to be sent to server
				post_data = {'name':name, 'level':level};

				//Ajax post data to server
				$.post('add_circuit2.php', post_data, function(data){  
					
					//load success massage in #result div element, with slide effect.       
					$("#result").hide().html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>').slideDown();
					
					//reset values in all input fields
					$('#name').val(''); 
					
				}).fail(function(err) {  //load any error data
					$("#result").hide().html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+err.responseText+'</div>').slideDown();
				});
				});
				
			});
		</script>
	</body>
</html>