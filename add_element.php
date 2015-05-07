<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Добавление элемента</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/jquery-ui.css">
		<script src="js/jquery-2.1.0.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<style>
			.modal {
				display:    none;
				position:   fixed;
				z-index:    1000;
				top:        0;
				left:       0;
				height:     100%;
				width:      100%;
				background: rgba( 255, 255, 255, .8 )
				url('img/loading.gif')
				50% 50%
				no-repeat;
			}
			body.loading {
				overflow: hidden;
			}
			body.loading .modal {
				display: block;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="container">
				<h1>Добавление элемента</h1>
				<div id="result"></div>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-md-4 control-label" for="category">Выберите категорию</label>
						<div class="col-md-2">
							<select id="category" class="form-control">
								<option value="0" selected disabled>Выберите категорию</option>
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
						<label class="col-md-4 control-label" for="type">Выберите тип</label>
						<div class="col-md-2">
							<select id="type" class="form-control" disabled>
								<option value="0" selected disabled>Выберите категорию</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="element">Выберите элемент</label>
						<div class="col-md-2">
							<select id="element" class="form-control" disabled>
								<option value="0" selected disabled>Выберите категорию</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="position" class="col-md-4 control-label">Введите позицию</label>
						<div class="col-md-2">
							<input type="text" class="form-control" name="position" id="position">
						</div>
					</div>
					<div class="form-group">
						<label for="amount" class="col-md-4 control-label">Введите количество</label>
						<div class="col-md-2">
							<input type="text" class="form-control" name="amount" id="amount">
						</div>
					</div>
					<input type="hidden" name="level" value="<?php echo $_GET['level'] ?>"/>
					<input type="hidden" name="circuit" value="<?php echo $_GET['circuit'] ?>"/>
					<div class="form-group">
						<div class="col-md-offset-4 col-md-2">
							<button class="btn btn-default" id="submit">Добавить элемент</button>
						</div>
					</div>
				</form>
				<a href="index.php" class="btn btn-default">На главную</a>
			</div>
		</div>
		<div class="modal"><!-- Place at bottom of page --></div>
		<script>
			$( document ).ready( function() {
				var $category = $( "#category" );
				var $element = $( "#element" );
				var $type = $( "#type" );
				$( "#submit" ).click( function( event ) {
					event.preventDefault();
					//collect input field values
					var level = $( "input[name=level]" ).val();
					var circuit = $( "input[name=circuit]" ).val();
					var element_id = $element.val();
					var category_id = $category.val();
					var name = $element.find( "option:selected" ).text();
					var position = $( "input[name=position]" ).val();
					var amount = $( "input[name=amount]" ).val();
					//data to be sent to server
					var post_data = {'level':level, 'circuit':circuit, 'element_id':element_id, 'category_id':category_id, 'name':name, 'position':position, 'amount':amount};
					//Ajax post data to server
					$.post('add_element2.php', post_data, function(data){ 
						
						//load success massage in #result div element, with slide effect.       
						$("#result").hide().html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>').slideDown();
						
						//reset values in all input fields
						$('#name').val('');
						$element.prop('selectedIndex',0);
						$('#position').val('');
						$('#amount').val('');
						//setTimeout(function() {location.reload()}, 500)
						
					}).fail(function(err) {  //load any error data
						$("#result").hide().html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+err.responseText+'</div>').slideDown();
					});
				});
				$category.change( function () {
					var category_id = $category.val();
					$.ajax( {
						type: "POST",
						url: "list_of_levels.php",
						data: { 'id' : category_id },
						success: function( data ) {
							$( "#type" ).html( data ).prop( 'disabled', false );
							$element.html( '<option value="0" selected disabled>Выберите тип</option>' ).prop( "disabled", true );
						},
						error: function( err ) {  //load any error data
							$type.html(err.responseText).prop('disabled', true);
							var type_id = $category.val();
							var group_id = $type.val();
							var post_data = {'type':type_id, 'group_id':group_id};
							$.post('list_of_elements.php', post_data, function(data){
								$element.html(data).prop('disabled', false);
							})
							.fail(function(err) {  //load any error data
								$element.html(err.responseText).prop('disabled', true);
							})
						}
					} );
				});
				$type.change(function()
				{
					var type_id = $category.val(); // TODO: why type_id = $category.val(); ?
					var group_id = $type.val(); // TODO: why group_id = $type.val(); ?
					var post_data = {'type':type_id, 'group_id':group_id};
					$.post('list_of_elements.php', post_data, function(data){
						$element.html(data).prop('disabled', false);
					}).fail(function(err) {  //load any error data
						$element.html(err.responseText).prop('disabled', true);
					});
				
				});
			});
			$body = $( "body" );
			$( document ).on( {
				ajaxStart: function() { $body.addClass("loading"); },
				ajaxStop: function() { $body.removeClass("loading"); }
			} );
		</script>
	</body>
</html>