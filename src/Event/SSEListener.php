<?php

namespace WyriHaximus\CakeFest2016\Event;

use Cake\Event\EventListenerInterface;
use Clue\React\Sse\BufferedChannel;

class SSEListener implements EventListenerInterface
{
    protected $channel;

    public function __construct()
    {
        $this->channel = new BufferedChannel();
    }

    /**
     * Return implemented events.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            RequestEvent::EVENT => 'request',
            BroadcastEvent::EVENT => 'broadcast',
        ];
    }

    public function request(RequestEvent $event)
    {
        if ($event->getRequest()->getPath() !== '/sse') {
            return;
        }

        $headers = $event->getRequest()->getHeaders();
        $headers = array_change_key_case($headers, CASE_LOWER);
        $id = isset($headers['last-event-id']) ? $headers['last-event-id'] : null;
        $event->getResponse()->writeHead(200, array('Content-Type' => 'text/event-stream'));
        $this->channel->connect($event->getResponse(), $id);
        $event->getResponse()->on('close', function () use ($event) {
            $this->channel->disconnect($event->getResponse());
        });
        $event->stopPropagation();
    }

    public function broadcast(BroadcastEvent $event)
    {
        $this->channel->writeMessage(json_encode($event->data()));
    }
}
