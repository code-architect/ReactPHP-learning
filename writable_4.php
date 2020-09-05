<?php

require 'vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

// resource opened in a writing mode
$readable = new \React\Stream\ReadableResourceStream(STDIN, $loop);
$writable = new \React\Stream\WritableResourceStream(STDOUT, $loop);

// create a readable stream and when this stream receive a chunk of data it
// simply write it to writable stream
//$readable->on('data', function ($chunk) use($writable){
//    $writable->write($chunk);
//});

// we can achieve the same result using the 'pipe' method
$readable->pipe($writable);

$loop->run();


/**
 * Note:
 * piping is a powerful tool, it allows to chain different streams and each stream will be responsible for it's own job
 */