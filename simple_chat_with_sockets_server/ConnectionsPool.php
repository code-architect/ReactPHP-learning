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
        $connection->write("Enter Your name: ");            // 9
        $this->setConnectionName($connection, '');         // 10

        $this->sendAll("A new users enters teh chat \n", $connection);   // 8
        $this->initEvents($connection);

    }

    private function getConnectionName(ConnectionInterface $connection)
    {
        return $this->connections->offsetGet($connection);
    }


    private function setConnectionName(ConnectionInterface $connection, $name)
    {
        $this->connections->offsetSet($connection, $name);
    }


    /**
     * Adding a new user with name
     * @param ConnectionInterface $connection
     * @param string $name
     */
    private function addNewMember(ConnectionInterface $connection, $name)
    {
        $name = str_replace(["\n", "\r"], '', $name);
        $this->setConnectionName($connection, $name);
        $this->sendAll("User $name joins the chat", $connection);
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


    /**
     * @param ConnectionInterface $connection
     */
    private function initEvents(ConnectionInterface $connection)
    {
        // when new data comes we send all active connection to our pool except the current one
        $connection->on('data', function ($data) use ($connection) {
            $name = $this->getConnectionName($connection);                      // 11
            if (empty($name)) {
                $this->addNewMember($connection, $data);
                return;
            }
            $this->sendAll("$name: $data", $connection);              // 4
        });

        $connection->on('close', function () use ($connection) {     // 5
            $name = $this->getConnectionName($connection);
            $this->connections->offsetSet($connection);
            $this->sendAll("A user $name left the chat \n", $connection);
        });
    }
}
