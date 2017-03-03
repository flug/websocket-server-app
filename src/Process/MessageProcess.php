<?php
namespace Clooder\Process;

use Clooder\Event\CloseEvent;
use Clooder\Event\ErrorEvent;
use Clooder\Event\MessageEvent;
use Clooder\Event\OpenEvent;
use Psr\Log\LoggerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MessageProcess implements MessageComponentInterface
{
    private $logger;
    private $dispatcher;
    
    public function __construct(
        LoggerInterface $logger,
        EventDispatcherInterface $dispatcher
    ) {
        $this->logger = $logger;
        $this->dispatcher = $dispatcher;
    }
    
    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
        $openEvent = new OpenEvent($conn);
        $this->dispatcher->dispatch(OpenEvent::NAME, $openEvent);
        $this->logger->info(sprintf('Connection open of : %s',
            $conn->resourceId));
    }
    
    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        $closeEvent = new CloseEvent($conn);
        $this->dispatcher->dispatch(ErrorEvent::NAME, $closeEvent);
        $this->logger->info(sprintf(
            "Connection close %s ",
            $conn->resourceId
        ));
    }
    
    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        $errorEvent = new ErrorEvent($conn, $e);
        $this->dispatcher->dispatch(ErrorEvent::NAME, $errorEvent);
        $this->logger->alert(sprintf(
            "an exception is throw by %s with message : %s ",
            $conn->resourceId,
            json_encode([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ])
        ));
        
    }
    
    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $messageEvent = new MessageEvent($from, $msg);
        $this->dispatcher->dispatch(MessageEvent::NAME, $messageEvent);
        $this->logger->info(sprintf(
            "a message send by %s with content : %s ",
            $from->resourceId,
            $msg
        ));
    }
}
