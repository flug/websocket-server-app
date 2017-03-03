<?php
namespace Clooder\Event;

use Ratchet\ConnectionInterface;
use Symfony\Component\EventDispatcher\Event;

class OpenEvent extends Event
{
    const NAME = "on.open";
    private $conn;
    
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
     * @return OpenEvent
     */
    public function setConnection(ConnectionInterface $conn)
    {
        $this->conn = $conn;
        
        return $this;
    }
}
