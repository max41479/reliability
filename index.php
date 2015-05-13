<?php session_start();
//session_unset();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Расчет надежности</title>
		<link rel="stylesheet" href="css/bootstrap.css">
		<style>
			li {
				padding: 1px;
			}
			span
			{
				display: inline-block;
				line-height: 21px;
			}
		</style>
	</head>
	<body>
		<script src="js/jquery-2.1.4.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bootbox.js"></script>
		<div class="container">
			<div class="row">
				<h1>Расчет надежности</h1>
				<div class="col-md-8">
					<ul id="tree">
						<?php include "tree.php";
						//var_dump($_SESSION);
						//$_SESSION['levels'][0] = "131213123"
						?>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<a href="#" id="add_level" class="btn btn-default">Добавить элемент первого уровня</a>
					<div id="result" style="margin-top: 15px;"></div>
				</div>
			</div>
		</div>
		<script>
			function set_tooltips() {
				$( '[data-toggle="tooltip"]' ).tooltip()
			}
			/**
			 * @param {string} result_div - id of div where to put result message
			 * @param {string} message - result message
			 * @param {string} result_type - "success" or "danger"
			 */
			function show_result_info( result_div, message, result_type ) {
				$( result_div ).clearQueue().hide().html( '<div class="alert alert-' + result_type + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + message + '</div>' ).slideDown().delay( 3000 ).slideUp();
			}
			/**
			 * @param {string} script_name - name of php script
			 * @param post_data - data which is sent to script through post
			 * @param {string} result_div id of div where to put result message
			 */
			function post( script_name, post_data, result_div ) {
				$.post( script_name, post_data, function( data ){
					//load success massage in #result div element, with slide effect.
					show_result_info(result_div, data, "success" );
				}).fail( function( err ) { //load any error data
					show_result_info(result_div, err.responseText, "danger" );
				} ).always( function() {
					$( "#tree" ).load( "tree.php" );
				} )
			}
			var $body = $( "body" );
			$( document ).ready( function() {
				$( "#add_level" ).on( "click", function() {
					bootbox.dialog( {
						title: "Добавление уровня",
						message: '<div title="Добавление уровня">' +
									'<form class="form-horizontal" role="form">' +
										'<div class="form-group" id="level">' +
											'<label for="name" class="col-md-6 control-label">Введите название уровня</label>' +
											'<div class="col-md-5">' +
												'<input type="text" class="form-control" id="level_name">' +
											'</div>' +
										'</div>' +
										'<div id="level_result"></div>' +
									'</form>' +
								'</div>',
						onEscape: true,
						buttons: {
							"Добавить": {
								className: "btn-success",
								callback: function() {
									var $level= $( "#level" );
									//hide all error messages
									$level.removeClass( "has-error" );
									$( ".alert" ).slideUp();
									var level_name = $( "#level_name" ).val(); // collect entered information
									if( level_name.length < 3 ) { //input validation
										$level.addClass( "has-error" );
										show_result_info( "#level_result", "Название слишком короткое либо пустое!", "danger" );
									}
									else { //send data to server
										var post_data = { 'level':level_name };
										post( 'add_level.php', post_data, "#level_result" );
										$( "input" ).val( "" ); //reset values in all input fields
									}
									return false;
								}
							},
							"Готово": {
								className: "btn-primary",
								callback: function() {
									return true;
								}
							}
						}
					});
				});
				$body.on( "click", ".add_circuit", function( event ) {
					var level_id = $( event.target ).closest( "li" ).attr( "data-value").replace('level-', '');
					bootbox.dialog( {
						title: "Добавление платы",
						message: '<div title="Добавление платы">' +
									'<form class="form-horizontal" role="form">' +
										'<div class="form-group" id="circuit">' +
											'<label for="name" class="col-md-6 control-label">Введите название платы</label>' +
											'<div class="col-md-5">' +
												'<input type="text" class="form-control" id="circuit_name">' +
											'</div>' +
										'</div>' +
										'<div id="circuit_result"></div>' +
									'</form>' +
								'</div>',
						onEscape: true,
						buttons: {
							"Добавить": {
								className: "btn-success",
								callback: function() {
									var $circuit = $( "#circuit" );
									//hide all error messages
									$circuit.removeClass( "has-error" );
									$( ".alert" ).slideUp();
									var circuit_name = $( "#circuit_name" ).val(); // collect entered information
									if( circuit_name.length < 3 ) { //input validation
										$circuit.addClass( "has-error" );
										show_result_info( "#circuit_result", "Название слишком короткое либо пустое!", "danger" );
									}
									else { //send data to server
										var post_data = { 'circuit_name':circuit_name, level_id: level_id };
										post( 'add_circuit2.php', post_data, "#circuit_result" );
										$( "input" ).val( "" ); //reset values in all input fields
									}
									return false;
								}
							},
							"Готово": {
								className: "btn-primary",
								callback: function() {
									return true;
								}
							}
						}
					});
				});
				$body.on( "click", ".add_element", function( event ) {
					//var level_id = $( event.target ).closest( "li" ).attr( "data-value").replace('level-', '');
					var arr = $( event.target ).closest( "li" ).attr( "data-value").split( "-" );
					bootbox.dialog( {
						title: "Добавление элемента",
						message: '<div title="Добавление элемента">' +
									'<form class="form-horizontal" role="form">' +
										'<div class="form-group">' +
											'<label class="col-md-6 control-label" for="category">Выберите категорию</label>' +
											'<div class="col-md-5">' +
												'<select id="category" class="form-control">' +
												'<option value="0" selected disabled>Выберите категорию</option>' +
												'<?php
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

												?>' +
												'</select>' +
											'</div>' +
										'</div>' +
										'<div class="form-group">' +
											'<label class="col-md-6 control-label" for="type">Выберите тип</label>' +
											'<div class="col-md-5">' +
												'<select id="type" class="form-control" disabled>' +
													'<option value="0" selected disabled>Выберите категорию</option>' +
												'</select>' +
											'</div>' +
										'</div>' +
										'<div class="form-group">' +
											'<label class="col-md-6 control-label" for="element">Выберите элемент</label>' +
											'<div class="col-md-5">' +
												'<select id="element" class="form-control" disabled>' +
													'<option value="0" selected disabled>Выберите категорию</option>' +
												'</select>' +
											'</div>' +
										'</div>' +
										'<div class="form-group">' +
											'<label for="position" class="col-md-6 control-label">Введите позицию</label>' +
											'<div class="col-md-5">' +
												'<input type="text" class="form-control" id="position">' +
											'</div>' +
										'</div>' +
										'<div class="form-group">' +
											'<label for="amount" class="col-md-6 control-label">Введите количество</label>' +
											'<div class="col-md-5">' +
												'<input type="text" class="form-control" id="amount">' +
											'</div>' +
										'</div>' +
										'<div id="element_result"></div>' +
									'</form>' +
								'</div>',
						onEscape: true,
						buttons: {
							"Добавить": {
								className: "btn-success",
								callback: function() {
									//var post_data = { 'level_id':arr[1], 'circuit_id':arr[2], 'element_id':arr[3] };

									var $element = $( "#element" );
									//collect input field values
									var level_id = arr[1];
									var circuit_id = arr[2];
									var element_id = $element.val();

									var category_id = $( "#category" ).val();
									var element_name = $element.find( "option:selected" ).text();
									var position = $( "#position" ).val();
									var amount = $( "#amount" ).val();

									//hide all error messages
									$element.removeClass( "has-error" );
									$( ".alert" ).slideUp();
									if( element_name.length < 3 ) { //input validation
										$element.addClass( "has-error" );
										show_result_info( "#element_result", "Название слишком короткое либо пустое!", "danger" );
									}
									else { //send data to server
										var post_data = {'level':level_id, 'circuit':circuit_id, 'element_id':element_id, 'category_id':category_id, 'name':element_name, 'position':position, 'amount':amount};
										post( 'add_element2.php', post_data, "#element_result" );
										$( "input" ).val( "" ); //reset values in all input fields
									}
									return false;
								}
							},
							"Готово": {
								className: "btn-primary",
								callback: function() {
									return true;
								}
							}
						}
					});
				});
				$body.on( "click", ".close", function( event ) {
					var li = $( event.target ).closest( "li" );
					var value = li.attr( "data-value" );
					$( ".alert" ).slideUp();
					if ( value !== undefined ) {
						var arr = value.split( "-" );
						var post_data = { 'level_id':arr[1], 'circuit_id':arr[2], 'element_id':arr[3] };
						$.post( "del.php", post_data, function( data ) {
							li.slideUp();
							//load success massage in #result div element, with slide effect.
							show_result_info( "#result", data, "success" );
						} )
						.fail( function( err ) {  //load any error data
							show_result_info( "#result", err.responseText, "danger" );
						} );
					}
				} );
				$body.on( {
					mouseenter: function() {
						$( this ).find( ".close" ).show();
					},
					mouseleave: function() {
						$( this ).find( ".close" ).hide();
					}
				}, "span" );


				$body.on( "change", "#category", function( event ) {
					var $category = $( "#category" );
					var $element = $( "#element" );
					var $type = $( "#type" );
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
				$body.on( "change", "#type", function( event ) {
					var $category = $( "#category" );
					var $element = $( "#element" );
					var $type = $( "#type" );
					var type_id = $category.val(); // TODO: why type_id = $category.val(); ?
					var group_id = $type.val(); // TODO: why group_id = $type.val(); ?
					var post_data = {'type':type_id, 'group_id':group_id};
					$.post('list_of_elements.php', post_data, function(data){
						$element.html(data).prop('disabled', false);
					}).fail(function(err) {  //load any error data
						$element.html(err.responseText).prop('disabled', true);
					});
				});
				set_tooltips()
			} ).ajaxComplete(function() {
				set_tooltips();
			} );
		</script>
	</body>
</html>