<?php
/**
 * @file
 * Generate a list of rooms in the database and a link to add a new room.
 */

// @TODO success message?

// Keep functions in an external file
include('functions.php');
// Logged in?
check_logged_in();
// Generate the room list result set from the database.
$rooms = roomlist();
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Room List</title>

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
  <body>
    <h1>Room List</h1>
		<?php msg_render(); ?>
		<div class="main-wrap">
      <ul>
        <?php while ($room = $rooms->fetch()): ?>
          <li><a href="room.php?r=<?php print $room['rid']; ?>">Fix Me</a></li>
        <?php endwhile; ?>
      </ul>
	    <a href="room.php">Add a Room</a>
		</div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
  </body>
</html>


<!doctype HTML>
<html lang="en-US">

	<body>
	</body>
</html>
