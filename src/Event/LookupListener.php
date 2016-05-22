<?php

namespace WyriHaximus\CakeFest2016\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;

class LookupListener implements EventListenerInterface
{
    /**
     * Return implemented events.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            RequestEvent::EVENT => 'request',
        ];
    }

    public function request(RequestEvent $event)
    {
        if ($event->getRequest()->getPath() == '/lookup.json') {
            EventManager::instance()->dispatch(LookupEvent::create($event->getRequest()->getQuery()['host']));
            $event->getResponse()->writeHead(200);
            $event->getResponse()->end('{}');
            $event->stopPropagation();
        }
    }
}
