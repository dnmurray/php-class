<?php
/**
 * @file
 * room add/edit
 */
include('functions.php');

/**
 * Update a room row (or insert as necessary).
 *
 * @param array $room
 *   Assoc array of room fields.
 *
 * @return int
 *   Room number generated or updated.
 */
function room_update($room) {
  // Walk through the array and convert the room array to a placeholder array.
  $ph = array();
  foreach ($room as $key => $value) {
    if (is_string($key)) {
      $ph[":{$key}"] = $value;
    }
  }
	if ($room['upd'] == 0) {
		// New row add
		$sql1 = "INSERT INTO room (rid, rate, roomsize, sleeps";
		$sql2 = " VALUES (:rid, :rate, :roomsize, :sleeps";
		if (!empty($room['image'])) {
			$sql1 .= ', image';
			$sql2 .= ', :image';
		}
		$sql = $sql1 . ")" . $sql2 . ")";
		$desc = 'Insert Room';
	}
	else {
		// @TODO use a session var, see room.php
		$ph[':rid'] = $room['upd'];
		$sql1 = "UPDATE room SET rate = :rate, bedsize = :bedsize, sleeps = :sleeps";
		$sql2 = " WHERE rid = :rid";
		if (!empty($room['image'])) {
			$sql1 .= ', image = :image';
		}
		$sql = $sql1 . $sql2;
		$desc = 'Update Room';
	}
	unset($ph[':upd']);
	list($pdo, $cnt) = sql_execute($sql, $ph, $desc);
	if ($cnt === FALSE) {
		header('Location: roomlist.php');
		exit;
	}
	if ($room['upd'] == 0) {
		$rtn = $cnt > 0 ? $pdo->lastInsertId() : 0;
	}
	else {
		$rtn = $cnt > 0 ? $room['upd'] : 0;
	}
	return $rtn;
}

/**
 * Handle room form requests.
 */
function process_room_form() {
  if (empty($_POST)) {
		$room_num = !empty($_GET['r']) ? $_GET['r'] : 0;
    $room = room($room_num);
    $rid = $room['rid'];
    if ($rid < 0) {
      msg_add("Room $room_num not found.", 'bg-danger');
			header('Location: roomlist.php');
			exit();
    }
    return $room;
  }
	// Did we get an uploaded file?
	if (!empty($_FILES['image'])) {
		// @TODO does directory exist?
		$target = "images/uploads/" . $_FILES['image']['name'];
		if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
			$_POST['image'] = $target;
		}
	}
  // Check for changes and update the DB
  // @TODO validation
  // update the db
  if ($rid = room_update($_POST)) {
    msg_add("Saved changes to room $rid");
	}
	else {
		msg_add("Update failed", 'bg-danger');
	}
  header("Location: roomlist.php");
	exit();
}

// Generate the options html for the select tag for room sizes.
function room_sizes($room) {
	$pdo = connect();
	$sql = "SELECT * FROM room_size ORDER BY room_size";
	$output = '';
	foreach ($pdo->query($sql) as $row) {
		$output .= '<option value="' . $row['abbr'] . '" ';
		if ($row['abbr'] == $room['roomsize']) {
			$output .= ' selected';
		}
		$output .= '>' . $row['room_size'] . "</option>\n";
	}
	return $output;
}

check_logged_in();
$room = process_room_form();
// Select options
$options = room_sizes($room);
// Clean up rid for new add
$rid = $room['rid'] ? $room['rid'] : '';
?><!DOCTYPE html>
<html>
	<?php // @TODO convert to bootstrap ?>
	<head>
		<title> Room - Bates Motel</title>
		<?php print head_elements(); ?>
	</head>
<body>
<div style="border:thin solid #ccc; width:350px; height:auto; margin-left:auto; margin-right:auto; text-align:center; border-radius:5px; padding:50px; margin-top:100px;
-webkit-box-shadow: 9px 9px 22px -10px rgba(0,0,0,0.75);
-moz-box-shadow: 9px 9px 22px -10px rgba(0,0,0,0.75);
box-shadow: 9px 9px 22px -10px rgba(0,0,0,0.75); font-family:arial; text-align:left;">
	<h1 style="text-align:left; color:rgb(9, 187, 9);">Room Information</h1>
	<form method="post" action="room.php" enctype="multipart/form-data">
		<table>
			<tr><td colspan="2" style="text-align:left;">
				<h3><?php if ($rid): ?>
					Edit Room <?php print $rid; ?>
				<?php else: ?>
					Add a New Room
				<?php endif; ?>
				</h3>
			</td></tr>
			<?php msg_render(); ?>
			<tr>
				<td>Room Number:</td>
				<?php // @TODO no edit here when updating a row ?>
				<td><input type="text" name="rid" value="<?php print $rid; ?>"></td>
			</tr>
			<tr>
				<td>Bed Type</td>
				<td>
					<select style="width:100%" name="roomsize">
						<?php print $options; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Rate</td>
				<td><input type="text" name="rate" value="<?php printf("%.2f", $room['rate']); ?>"></td>
			</tr>
			<tr>
				<td>Number of People</td>
<td><input type="text" name="sleeps" value="<?php print $room['sleeps']; ?>"></td>
			</tr>
			<tr>
				<td>Picture</td>
				<td>
					<?php if (!empty($room['image'])): ?>
						<img src="<?php print $room['image']; ?>" alt="Room Picture" />
					<?php endif; ?>
					<input type="file" name="image" />
				</td>
			</tr>
			<tr>
				<td colspan="2" ><br></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:right;"><input type="submit"></td>
			</tr>
		</table>
		<?php // @TODO implement this as a session var, security problem ?>
		<input type="hidden" name="upd" value="<?php print $rid; ?>" />
		<?php // @TODO add cancel or go back link to not make any changes ?>
	</form>
</div>
</body>
</html>
