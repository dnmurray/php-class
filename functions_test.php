<?php
/**
 * @file
 * Test harness for functions.
 *
 */

require_once('functions.php');
require_once('PHPUnit.php');

// https://pear.php.net/package/PHPUnit/docs/latest/PHPUnit/PHPUnit_TestCase.html
class FunctionsTest extends PHPUnit_TestCase {

  // contains the internal data, for the test @TODO
  var $data;

  // constructor of the test suite
  function FunctionsTest($name) {
    $this->PHPUnit_TestCase($name);
  }

  // called before the test functions will be executed this function is
  // defined in PHPUnit_TestCase and overwritten here
  function setUp() {
  }

  // called after the test functions are executed this function is defined in
  // PHPUnit_TestCase and overwritten here
  function tearDown() {
  }

  function testConnect() {
    $pdo = connect();
    $this->assertNotNull();
  }

  function testRoomAdd() {
    $room = empty_room(1313);
    $room['rate'] = 1234;
    $room['bedsize'] = 'king';
    $room['sleeps'] = 2;
    $this->assertroom_update($room);
  }
}
