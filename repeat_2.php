<?php

require 'vendor/autoload.php';

$loop = \React\EventLoop\Factory::create(); //create a loop via the factory

// counter to measure number of times
$counter = 0;

/** OPTION ONE
 * // add an interval in seconds, and a callback which will be repeatedly called in a specified interval
$timer = $loop->addPeriodicTimer(1, function () use (&$counter, &$timer, $loop){
    $counter++;

    // because event loops has many timer, the event loop timer itself returns an instance of the PeriodicTimer
    if($counter === 5)
    {
        $loop->cancelTimer($timer);
    }

    echo "Hello from the inside\n";
});

$loop->run();
 */

/** OPTION TWO */

/**
 * when you need to access the timer inside the callback, every callback accepts an argument which in an instance
 * of the callbacks timer
 */
$timer = $loop->addPeriodicTimer(1, function (\React\EventLoop\TimerInterface $timer) use (&$counter, $loop){
    $counter++;

    if($counter === 5)
    {
        $loop->cancelTimer($timer);
    }

    echo "Hello from the inside\n";
});

$loop->run();

/**
 * Every asynchronous application in ReactPHP consists of three parts. 
 * Create an event loop, Configure the behavior,Run the loop
 */