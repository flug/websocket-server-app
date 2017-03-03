<?php

namespace Clooder\Event;

use Ratchet\ConnectionInterface;
use Symfony\Component\EventDispatcher\Event;

class MessageEvent extends Event
{
    private $conn;
    private $message;
    const NAME = 'on.message';

    public function __construct(ConnectionInterface $conn, $msg)
    {
        $this->conn = $conn;
        $this->message = $msg;
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
     *
     * @return MessageEvent
     */
    public function setConnection(ConnectionInterface $conn)
    {
        $this->conn = $conn;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        if ($this->isJson($this->message)) {
            return json_decode($this->message);
        }

        return $this->message;
    }

    /**
     * @param mixed $message
     *
     * @return MessageEvent
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    private function isJson($string)
    {
        json_decode($string);

        return json_last_error() == JSON_ERROR_NONE;
    }

    public function send()
    {
        $this->getConnection()->send($this->message);
    }
}
