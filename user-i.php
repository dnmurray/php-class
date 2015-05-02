<?php
// populate the user table for testing
include('functions.php');
$rows = user_add('test', 'thequick');
if ($rows == 0) {
    print "user not added\n";
}
