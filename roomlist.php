<?php
/**
 * @file
 * Generate a list of rooms in the database and a link to add a new room.
 */

// @TODO success message?

// Keep functions in an external file
include('functions.php');
// Logged in?
check_logged_in('roomlist.php');
// Generate the room list result set from the database.
$rooms = roomlist();
?><!doctype HTML>
<html lang="en-US">

<head>
	<title>Room List</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Room list for hotel">
	<link rel="stylesheet" type="text/css" href="">
</head>

<body>
    <div class="main-wrap">
        <ul>
            <?php foreach ($rooms->fetch() as $room): ?>
                <li><a href="room.php?r=<?php print $room['rid']; ?>">Fix Me</a></li>
            <?php endforeach; ?>
        </ul>
	    <a href="room.php">Add a Room</a>
	</div>
</body>
</html>
