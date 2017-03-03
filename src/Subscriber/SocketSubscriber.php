<?php
namespace Clooder\Subscriber;

use Clooder\Event\CloseEvent;
use Clooder\Event\ErrorEvent;
use Clooder\Event\MessageEvent;
use Clooder\Event\OpenEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SocketSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            MessageEvent::NAME => "onMessageReceived",
            ErrorEvent::NAME => "onErrorReceived",
            CloseEvent::NAME => "onClose",
            OpenEvent::NAME => "onOpen",
        ];
    }
    
    public function onMessageReceived(MessageEvent $event)
    {
        
    }
    
    public function onErrorReceived(ErrorEvent $event)
    {
        
    }
    
    public function onClose(CloseEvent $event)
    {
        
    }
    
    public function onOpen(OpenEvent $event)
    {
        
    }
}
