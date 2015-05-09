<?php
/**
 * @file
 * Load the rooms table from a text file (runs from command line).
 */

// This has been run.  No accidents.
exit();

include("functions.php");

function loader($file) {
    $h = fopen($file, "r");
    if ($h) {
        $pdo = connect();
        $pdo->query("TRUNCATE TABLE room");
        $sth = $pdo->prepare("INSERT INTO room (rid, rate, roomsize, sleeps) VALUES (:rid, :rate, :roomsize, :sleeps)");
        while ($ln = fgets($h)) {
            $ln = trim($ln);
            if (strpos($ln, '#') !== 0) {
                $parts = preg_split('/:/', $ln);
                $sth->execute(array(
                                    ':rid' => $parts[0],
                                    ':rate' => $parts[1],
                                    ':roomsize' => $parts[2],
                                    ':sleeps' => $parts[3],
                                    ));
            }
        }
        fclose($h);
    }
}

loader("rooms.txt");
