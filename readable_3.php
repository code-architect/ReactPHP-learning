<?php

require 'vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

// create a read only stream
// reading one character at a chunk, third parameter is optional
$readable = new \React\Stream\ReadableResourceStream(STDIN, $loop, 1);

$readable->on('data', function ($chunk) use ($readable, $loop){
    echo $chunk . PHP_EOL;

    // we can pause and resume the reading of data
    $loop->addTimer(1, function () use ($readable){
        $readable->resume();
    });
});

// data is not the only event we can listen to, when there is no data available the end-event will be fired
$readable->on('end', function(){
    echo 'finished' . PHP_EOL;
});

$loop->run();

/**
 * Note: it won't work on windows.
 * Stream the file or the dta from terminal to test, run
 * cat 'filename.extension' | php readable_3.php
 */