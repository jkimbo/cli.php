<?php
/**
 * Timing examples
 */

require dirname(__FILE__).'/../lib/Timer.php';

$clock = new Timer();

$clock->start('total');

$clock->start('block1');
sleep(2);
$clock->stop('block1');

$clock->start('block2');
sleep(3);
$clock->stop('block2');

// Averages
for($i = 0; $i < 5; $i++) {
    $rand = rand(0, 10)/10;
    $clock->startAvg('loop');
    sleep2($rand);
    $clock->stopAvg('loop');
}

$clock->stop('total');

$clock->report();

$clock->report('total');

/**
 * sleep2
 *
 * Function to allow sleeping in periods less than a second
 */
function sleep2($seconds) {
    $seconds = abs($seconds);
    if($seconds < 1) {
        usleep($seconds * 1000000);
    } else {
        sleep($seconds);
    }
}