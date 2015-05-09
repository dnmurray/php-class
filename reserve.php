<?php
/**
 * @file
 * reserve a room
 */

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Reserve A Room - Bates Motel</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
		<?php print head_elements(); ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="reserve">
		<div class="text-center">
			<h3>Bates Motel</h3>
			<h2>Reserve a Room</h2>
		</div>
		<form method="post" action="reserve.php">
			<table>
				<tr>
					<td>Arrival Date:</td>
					<td><input type="date" name="arrival"</td>
				</tr>
			</table>
		</form>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
  </body>
</html>
