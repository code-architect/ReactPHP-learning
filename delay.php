<?php

require 'vendor/autoload.php';

$loop = \React\EventLoop\Factory::create(); //create a loop via the factory

$loop->addTimer(1, function (){     // use a timer to delay, just like javascript
    echo "Hello from loop\n";
});

echo "Hello before timer\n";

$loop->run();                               // because we have to explicitly create an instance of the event loop
                                            // we also need to explicitly run it
