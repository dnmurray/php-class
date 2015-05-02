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
		$sql = "INSERT INTO room (rid, rate, bedsize, sleeps)
							VALUES (:rid, :rate, :bedsize, :sleeps)";
		$desc = 'Insert Room';
	}
	else {
		// @TODO use a session var, see room.php
		$ph[':rid'] = $room['upd'];
		$sql = "UPDATE room SET rate = :rate, bedsize = :bedsize, sleeps = :sleeps WHERE rid = :rid";
		$desc = 'Update Room';
	}
	unset($ph[':upd']);
	list($pdo, $cnt) = sql_execute($sql, $ph, $desc);
	if ($cnt === FALSE) {
		header('Location: roomlist.php');
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

check_logged_in();
$room = process_room_form();
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
	<form method="post" action="room.php">
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
					<select style="width:100%" name="bedsize">
<?php // @TODO what other types of rooms do we need ?>
<?php // @TODO (later) automate this ?>
<option value="double" <?php print $room['bedsize'] == 'double' ? 'selected' : ''; ?>>Double</option>
<option value="queen"  <?php print $room['bedsize'] == 'queen' ? 'selected' : ''; ?>>Queen</option>
<option value="king"  <?php print $room['bedsize'] == 'king' ? 'selected' : ''; ?>>King</option>
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
