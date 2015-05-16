<?php
/**
 * @file
 * Functions to implement pages for class.
 */

$messages = array();

if (!file_exists('conf.php')) {
  // @TODO create this page
  header('Location: conf-required.html');
  exit();
}
require_once('conf.php');

if (empty($conf['smarty_libs'])) {
  print "Please update conf.php to add the key 'smarty_libs' and point to the location of the Smarty class libraries (no trailing slash).\n";
  exit();
}
require($conf['smarty_libs'] . '/Smarty.class.php');

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
    print_r($e->errorInfo);
    die($e->getMessage() . "\n");
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
  $stmt = $pdo->query("SELECT * FROM room");
  return $stmt;
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
  if (empty($rid)) {
    return empty_room(0);
  }
  $pdo = connect();
  $stmt = $pdo->prepare("SELECT rid, rate, roomsize, sleeps, image FROM room WHERE rid = :rid");
  $room = empty_room(-1);
  if ($stmt->execute(array(':rid' => $rid))) {
    $room = $stmt->fetch();
    if (empty($room)) {
      // Note the difference for "room not found"
      return empty_room(-1);;
    }
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
    'roomsize' => 'd',
    'sleeps' => 2,
  );
}

/**
 * Helper function to execute a sql statement, with arguments
 *
 * @param string $sql
 *   SQL statement to run, with placeholders
 * @param array $args
 *   Arguments for $sql
 *
 * @return array
 *   Two element array, pdo object, rowCount or FALSE if error
 */
function sql_execute($sql, $args, $desc) {
  $pdo = connect();
  $stmt = $pdo->prepare($sql);
  $stmt->execute($args);
  $err = $pdo->errorInfo();
  if ($err[0] != '00000') {
    msg_add($desc . ' failed: ' . $err[2], 'bg-danger');
    return array($pdo, FALSE, FALSE);
  }
  return array($pdo, $stmt->rowCount(), $stmt);
}

function room_delete($rid) {
  $pdo = connect();
  $sql = "DELETE FROM room WHERE rid = :rid";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':rid' => $rid));
  return $stmt->rowCount();
}

/**
 * Make sure the user has been logged in.
 */
function check_logged_in($from = '') {
  session_start();
  if (empty($_SESSION['username'])) {
    if (empty($from)) {
      $from = $_SERVER['REQUEST_URI'];
    }
    $_SESSION['login_redirect'] = $from;
    header('Location: login.php');
    exit();
  }
}

/**
 * Add a user to the database.
 */
function user_add($username, $password) {
  // @TODO duplicate usernames??!
  $pdo = connect();
  $sql = "INSERT INTO user (username, password)
 VALUES (:username, :password)";
  $stmt = $pdo->prepare($sql);
  $enc_pwd = password_hash($password, PASSWORD_DEFAULT);
  $args = array(
    ':username' => $username,
    ':password' => $enc_pwd,
  );
  $stmt->execute($args);
  return $stmt->rowCount();
}

/**
 * Load the user row for a specific username.
 */
function user_load($username) {
  $pdo = connect();
  $sql = "SELECT * FROM user WHERE username = :username";
  $stmt = $pdo->prepare($sql);
  $args = array(':username' => $username);
  $stmt->execute($args);
  return $stmt->fetch();
}

/**
 * Add a message to be rendered on the next page load.
 */
function msg_add($msg, $sev = 'bg-success') {
  global $messages;
  if (empty($_SESSION['msg'])) {
    $_SESSION['msg'] = array();
  }
  $_SESSION['msg'][] = array('msg' => $msg, 'sev' => $sev);
  $messages[] = array('msg' => $msg, 'sev' => $sev);
  dbg($msg);
}

/**
 * Helper function to render any messages on the page.
 *
 * $msg (should come from $_SESSION
 */
function msg_render() {
  global $messages;
  if (!empty($_SESSION['msg'])) {
    $messages = $_SESSION['msg'];
  }
  foreach ($messages as $msg) {
    print '<h5 class="' . $msg['sev'] . '">' . $msg['msg'] . "</h5>\n";
  }
  $_SESSION['msg'] = array();
}

/**
 * Return any tags we need in the <head> of most/all pages.
 */
function head_elements() {
  return <<<EOT
	<link href="css/bates.css" rel="stylesheet"></link>
    <!-- jQuery (necessary for Bootstrap JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bates.js"></script>
EOT;
}

/**
 * Returns an options list of states in the union.
 */
function us_states_opts($sel = NULL) {
  $states = array(
    'AL' => 'Alabama',
    'AK' => 'Alaska',
    'AZ' => 'Arizona',
    'AR' => 'Arkansas',
    'CA' => 'California',
    'CO' => 'Colorado',
    'CT' => 'Connecticut',
    'DE' => 'Delaware',
    'DC' => 'District of Columbia',
    'FL' => 'Florida',
    'GA' => 'Georgia',
    'HI' => 'Hawaii',
    'ID' => 'Idaho',
    'IL' => 'Illinois',
    'IN' => 'Indiana',
    'IA' => 'Iowa',
    'KS' => 'Kansas',
    'KY' => 'Kentucky',
    'LA' => 'Louisiana',
    'ME' => 'Maine',
    'MD' => 'Maryland',
    'MA' => 'Massachusetts',
    'MI' => 'Michigan',
    'MN' => 'Minnesota',
    'MS' => 'Mississippi',
    'MO' => 'Missouri',
    'MT' => 'Montana',
    'NE' => 'Nebraska',
    'NV' => 'Nevada',
    'NH' => 'New Hampshire',
    'NJ' => 'New Jersey',
    'NM' => 'New Mexico',
    'NY' => 'New York',
    'NC' => 'North Carolina',
    'ND' => 'North Dakota',
    'OH' => 'Ohio',
    'OK' => 'Oklahoma',
    'OR' => 'Oregon',
    'PA' => 'Pennsylvania',
    'RI' => 'Rhode Island',
    'SC' => 'South Carolina',
    'SD' => 'South Dakota',
    'TN' => 'Tennessee',
    'TX' => 'Texas',
    'UT' => 'Utah',
    'VT' => 'Vermont',
    'VA' => 'Virginia',
    'WA' => 'Washington',
    'WV' => 'West Virginia',
    'WI' => 'Wisconsin',
    'WY' => 'Wyoming',
  );
  return options($states, $sel);
}

/**
 * Converts an array to an html list of options.
 */
function options($options, $selected = NULL) {
  $output = '';
  foreach ($options as $key => $value) {
    $selected = $key == $selected ? ' selected' : '';
    $output .= "<option value=\"{$key}\"{$selected}>{$value}</option>\n";
  }
  return $output;
}

function dbg($val) {
  echo "<pre>\n";
  print to_string($val);
  echo "</pre>\n";
}

// utility functions
function to_string($val) {
  if (is_null($val)) {
    return 'null';
  }
  elseif (is_bool($val)) {
    return $val ? 'true' : 'false';
  }
  elseif (is_array($val) || is_object($val)) {
    return print_r($val, true);
  }
  else {
    return (string) $val;
  }
}

class PSmarty extends Smarty {

  public function __construct() {
    //$this->assign('head', '');
  }

  /** might use later
   // override display function to add functionality for all pages.
   public function display($template = null, $cache_id = null, $compile_id = null, $parent = null) {
   parent::display($template, $cache_id, $compile_id, $parent);
   }
  **/
}
