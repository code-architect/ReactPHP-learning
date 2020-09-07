<?php

require 'vendor/autoload.php';
require 'ConnectionsPool.php';

$loop = \React\EventLoop\Factory::create();

// it requires a IP address with a port number and a loop
$server = new \React\Socket\Server('127.0.0.1:8000', $loop);

$pool = new ConnectionsPool();      // 6

$server->on('connection', function (\React\Socket\ConnectionInterface $connection) use ($pool)  // 7
{
    $pool->add($connection);
});

$loop->run();