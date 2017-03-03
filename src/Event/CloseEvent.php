<?php

namespace Clooder\Event;

use Ratchet\ConnectionInterface;
use Symfony\Component\EventDispatcher\Event;

class CloseEvent extends Event
{
    private $conn;
    const NAME = 'on.close';

    public function __construct(ConnectionInterface $connection)
    {
        $this->conn = $connection;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function setConnection($conn)
    {
        $this->conn = $conn;

        return $this;
    }
}
