<?php
/**
 * @file
 * Test harness for functions.
 *
 */

require_once('functions.php');
//require_once('PHPUnit.php');

// https://pear.php.net/package/PHPUnit/docs/latest/PHPUnit/PHPUnit_TestCase.html
class FunctionsTest extends PHPUnit_Framework_TestCase {

  // contains the internal data, for the test @TODO
  var $data;

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
    $this->assertNotNull($pdo);
  }

  function testRoomAdd() {
    $room = empty_room(1313);
    $room['rate'] = 1234;
    $room['bedsize'] = 'king';
    $room['sleeps'] = 2;
    $this->assertEquals(room_update($room), 1);
  }

  function testRoomDelete() {
    //$this->assertEquals(room_delete(1313), 1);
    $cnt = room_delete(1313);
    $this->assertEquals($cnt, 1);
  }
}
