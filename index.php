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
		<div class="container">
			<div class="row">
				<h1>Расчет надежности</h1>
				<div class="col-md-8">
					<div id="result"></div>
					<ul id="tree">
						<?php include "tree.php"; ?>
					</ul>
				</div>
			</div>
			<div class="row">
				<a href="add_level.html" class="btn btn-default">Добавить элемент первого уровня</a>
			</div>
		</div>
		<script>
			function set_tooltips() {
				$( '[data-toggle="tooltip"]' ).tooltip()
			}
			$( document ).ready( function() {
				var $body = $( "body" );
				$body.on( "click", ".close", function( event ) {
					var value = $( event.target ).closest( "li" ).attr( "data-value" );
					if ( value !== undefined ) {
						var arr = value.split( "-" );
						var post_data = { 'level_id':arr[1], 'circuit_id':arr[2], 'element_id':arr[3] };
						$.post( "del.php", post_data, function( data ) {
							//load success massage in #result div element, with slide effect.
							$( "#result" ).hide().html( "<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" + data + "</div>" ).slideDown().delay( 3000 )/*.slideUp()*/;
							$( "#tree" ).load( "tree.php" );
						} )
						.fail( function( err ) {  //load any error data
							$( "#result" ).hide().html( "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" + err.responseText + "</div>" ).slideDown().delay( 3000 )/*.slideUp()*/;
							$( "#tree" ).load( "tree.php" );
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
				set_tooltips()
			});
		</script>
	</body>
</html>