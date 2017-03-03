<?php
namespace Clooder\Event;

use Ratchet\ConnectionInterface;
use Symfony\Component\EventDispatcher\Event;

class ErrorEvent extends Event
{
    private $conn;
    private $exception;
    const NAME = "on.error";
    
    public function __construct(ConnectionInterface $connection, \Exception $e)
    {
        $this->conn = $connection;
        $this->exception = $e;
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
     * @return ErrorEvent
     */
    public function setConnection(ConnectionInterface $conn)
    {
        $this->conn = $conn;
        
        return $this;
    }
    
    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
    
    /**
     * @param \Exception $exception
     * @return ErrorEvent
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
        
        return $this;
    }
}
