<?php
/**
 * @file
 * Functions to implement pages for class.
 */

require_once('conf.php');

/**
 * Connect to the database.
 *
 * Expects global variable $conf to be set and the keys 'db', 'db_user', and
 * 'db_pwd' to be populated.  They will be used to connect to the database.
 *
 * @return object
 *   A connected PDO object for queries.
 *   http://php.net/manual/en/class.pdo.php
 */
function connect() {
  global $conf;
  if (empty($conf['db']) || empty($conf['db_user']) || empty($conf['db_pwd'])) {
    // @TODO This is not a good thing to show to the users.
    die("database connection string not configured properly\n");
  }
  // We hard-coded localhost here, but extending to support a host and port
  // is trivial.
  try {
    $pdo = new PDO('mysql:host=localhost;dbname=' . $conf['db'] . ';charset=UTF8', $conf['db_user'], $conf['db_pwd']);
  } catch (Exception $e) {
    // Well, that's not good.
    // There's several things we can do at this point, none of them good.
    // For now, just throw the error up on the page.
    print_r($e);
    die("crash.\n");
  }
  return $pdo;
}

/**
 * Find all rooms.
 *
 * @return object
 *   A PDOStatement object, result of an executed query.
 *   http://php.net/manual/en/class.pdostatement.php
 */
function roomlist() {
  $pdo = connect();
  return $pdo->query("SELECT * FROM room")->execute();
}

/**
 * Find the row for a specific row.
 *
 * @param int $rid
 *   Room id
 * @return array
 *   Array of columns in room row.  If the room was not found, rid == -1.  If
 *   it's a new room (rid=0), an array of empty elements is returned.
 */
function room($rid=0) {
  if ($rid == 0) {
    return empty_room(0);
  }
  $pdo = connect();
  $room = $pdo->query("SELECT rid, rate, bedsize, sleeps FROM room WHERE rid = :rid",
          array(':rid' => $rid))->execute()->fetch();
  if (empty($room)) {
    // Note the difference for "room not found"
    return empty_room(-1);
  }
  return $room;
}

/**
 * Helper function to create an empty room (no data).
 *
 * @return array
 *   Room array.
 */
function empty_room($rid) {
  // Return an empty array if they're adding a new room.  Keep in mind that if
  // we add columns to the room table, we need to add those fields to this
  // array, too.
  return array(
    'rid' => $rid,
    'rate' => 0,
    'bedsize' => '',
    'sleeps' => 0,
  );
}

/**
 * Update a room row (or insert as necessary).
 *
 * @param array $room
 *   Assoc array of room fields.
 *
 * @return int
 *   Number of rows affected.
 */
function room_update($room) {
  // Walk through the array and convert the room array to a placeholder array.
  $ph = array();
  foreach ($room as $key => $value) {
    if (is_string($key)) {
      $ph[":{$key}"] = $value;
    }
  }
  $pdo = connect();
  // https://dev.mysql.com/doc/refman/5.6/en/insert-on-duplicate.html
  $sql = "INSERT INTO room (rid, rate, bedsize, sleeps)
 VALUES (:rid, :rate, :bedsize, :sleeps)
 ON DUPLICATE KEY UPDATE SET rate = :rate, bedsize = :bedsize, sleeps = :sleeps";
  $result = $pdo->query($sql, $ph)->execute();
  return $result->rowCount();
}

function room_delete($rid) {
  $pdo = connect();
  $sql = "DELETE FROM room WHERE rid = :rid";
  $result = $pdo->query($sql, array(':rid' => $rid))->execute();
  return $result->rowCount();
}
