<?php
/**
 * @file
 * Test wrapper.
 *
 * To run this, just $ php tests.php
 */

require_once('functions_test.php');
require_once('PHPUnit.php');

$suite  = new PHPUnit_TestSuite("FunctionsTest");
$result = PHPUnit::run($suite);

echo $result->toString();
