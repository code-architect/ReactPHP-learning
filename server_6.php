<?php

require 'vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

// it requires a IP address with a port number and a loop
$server = new \React\Socket\Server('127.0.0.1:8000', $loop);

$server->on('connection', function (\React\Socket\ConnectionInterface $connection){
    echo $connection->getRemoteAddress(). PHP_EOL;
    $connection->on('data', function ($data) use ($connection){
        $connection->write($data);
    });
});

// now when the loop runs the socket automatically start listening to incoming connections
$loop->run();