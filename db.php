<?php
/**
 * @file
 * db class, for class
 */

class DB { // extends what? {

  private static $pdo = NULL;

  // Connect method.  Expects global variable $conf to be set and the keys
  // 'db', 'db_user', and 'db_pwd' to be populated.  They will be used
  // to connect to the database.
  public function connect() {
    global $conf;
    if (empty($conf['db']) || empty($conf['db_user']) || empty($conf['db_pwd'])) {
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
  }

  public function query() {
    if (!$pdo) {
      $this->connect();
    }
    return $pdo->a();
  }
}
