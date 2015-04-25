<?php
/**
 * @file
 * room add/edit
 */
include('functions.php');
$room = process_room_form();
?><!DOCTYPE html>
<html>

<body>
<div style="border:thin solid #ccc; width:350px; height:auto; margin-left:auto; margin-right:auto; text-align:center; border-radius:5px; padding:50px; margin-top:100px;
-webkit-box-shadow: 9px 9px 22px -10px rgba(0,0,0,0.75);
-moz-box-shadow: 9px 9px 22px -10px rgba(0,0,0,0.75);
box-shadow: 9px 9px 22px -10px rgba(0,0,0,0.75); font-family:arial; text-align:left;">
	<h1 style="text-align:left; color:rgb(9, 187, 9);">Room Information</h1>
	<form method="post" action="room.php">
		<table>
			<tr><td colspan="2" style="text-align:left;"><h3>Add/Edit a Room</h3></td></tr>
			<?php // @TODO add validation error messages here ?>
			<tr>
				<td>Room Number:</td>
				<?php // @TODO no edit here when updating a row ?>
				<td><input type="text" name="room_num" value="<?php print $rid; ?>""></td>
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
				<td>Number of People</td>
<td><input type="text" name="num_people" value="<?php print $room['sleeps']; ?>"></td>
			</tr>
			<tr>
				<td colspan="2" ><br></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:right;"><input type="submit"></td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>
