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
			$( document ).ready( function() {
				$( "#add_level" ).on( "click", function() {
					bootbox.dialog( {
						title: "Добавление уровня",
						message: '<div id="level" title="Добавление уровня">' +
							'<form class="form-horizontal" role="form">' +
							'<div class="form-group" id="level_name">' +
							'<label for="name" class="col-md-6 control-label">Введите название уровня</label>' +
							'<div class="col-md-5">' +
							'<input type="text" class="form-control" name="level" id="level">' +
							'</div>' +
							'</div>' +
							'<div id="level_result"></div>' +
							'</form>' +
							'</div>',
						onEscape: true,
						buttons: {
							"Добавить!": {
								className: "btn-success",
								callback: function() {
									$( "#level_name" ).removeClass( "has-error" );
									var level = $( "input[name=level]" ).val();
									$( ".alert" ).slideUp();
									//data to be sent to server
									post_data = { 'level':level };
									//Ajax post data to server
									$.post( 'add_level.php', post_data, function( data ){
										//load success massage in #result div element, with slide effect.
										$( "#level_result" ).hide().html( '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data + '</div>' ).slideDown();
										//reset values in all input fields
										$( 'form input' ).val( '' );
									}).fail( function( err ) {  //load any error data
										$( "#level_name" ).toggleClass( "has-error" );
										$( "#level_result" ).hide().html( '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + err.responseText + '</div>' ).slideDown();
									} ).always( function() {
										$( "#tree" ).load( "tree.php" );
									} );
									return false;
								}
							},
							"Готово": {
								className: "btn-primary",
								callback: function() {}
							}
						}
					});
				});
				var $body = $( "body" );
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
							$( "#result" ).hide().html( "<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" + data + "</div>" ).slideDown().delay( 3000 ).slideUp();
						} )
						.fail( function( err ) {  //load any error data
							$( "#result" ).hide().html( "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" + err.responseText + "</div>" ).slideDown().delay( 3000 ).slideUp();
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
				set_tooltips()
			} ).ajaxComplete(function() {
				set_tooltips();
			} );
		</script>
	</body>
</html>