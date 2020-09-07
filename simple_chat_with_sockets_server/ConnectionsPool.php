<?php

use React\Socket\ConnectionInterface;

class ConnectionsPool
{
    protected $connections;

    public function __construct()
    {
        $this->connections = new SplObjectStorage();    // 1
    }


    /**
     * @param ConnectionInterface $connection
     */
    public function add(ConnectionInterface $connection)
    {
        $connection->write("Welcome to Chat \n");             // 2

        // then attach the connection with the pool and register some event handlers
        $this->connections->attach($connection);        // 3

        $this->sendAll("A new users enters teh chat \n", $connection);   // 8

        // when new data comes we send all active connection to our pool except the current one
        $connection->on('data', function ($data) use($connection)
        {
            $this->sendAll($data, $connection) ;                                       // 4
        });

        $connection->on('close', function () use ($connection){     // 5
            $this->connections->detach($connection);
            $this->sendAll("A user left the chat \n", $connection) ;
        });
    }

    /**
     * @param string $message
     * @param ConnectionInterface $except
     */
    private function sendAll($message, ConnectionInterface $except)
    {
        foreach ($this->connections as $conn)
        {
            if($conn != $except){
                $conn->write($message);
            }
        }
    }
}
