<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
  	<script>
  		$(document).ready(function() {

  			function updatePage() {
  				$.post(
  					$('#form').attr('action'), 
					$('#form').serialize(), 
					function(data) {	
					$('#table').html(data);
				}, "json");
				return false;
  			}

  			$(function() {
				$("#slider_width").slider({
					range:'min',
					min:1,
					max:50,
					value:1,
					slide: function (event, ui) {
						$('#width').val(ui.value);
						updatePage();
					}
				});
				$('#width').val($('slider_width').slider('value'));
			});

			$(function() {
				$("#slider_height").slider({
					range:'min',
					min:1,
					max:50,
					value:1,
					slide: function (event, ui) {
						$('#height').val(ui.value);
						updatePage();
					}
				});
					$('#height').val($('slider_height').slider('value'));
			});
  		});
		
	</script>
</head>
<body>
<div id="wrapper">
	<h3>Enter a height and width.</h3>
	<form method='post' action="process.php" id="form">
		<h4>Select a width</h4>
		<div id='slider_width' class='slider'></div>
		<input type="number" name="width" id="width" />
		<h4>Select a heigth</h4>
		<div id='slider_height' class='slider'></div>
		<input type="number" name="height" id="height" />
	</form>
	<div id="table"></div>
</div>
</body>
</html>

