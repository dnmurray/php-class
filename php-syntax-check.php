<?php
/**
 * @file
 * PHP syntax checker
 *
 * Run through a directory and make sure all the PHP code is valid.
 */

// Default current directory
$dir = '.';
if (!empty($argv[1])) {
    $dir = $argv[1];
}
$h = opendir($dir);
$failed = 254;
if ($h) {
    $failed = 0;
    while ($file = readdir($h)) {
        if (preg_match('/\.php$/', $file)) {
            $out = `php -l $file 2>&1`;
            if (!preg_match('/^No syntax/', $out)) {
                print $out;
                $failed = 255;
            }
        }
    }
    closedir($h);
}
exit($failed);
