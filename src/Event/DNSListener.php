<?php

namespace WyriHaximus\CakeFest2016\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use React\Dns\Resolver\Resolver;

class DNSListener implements EventListenerInterface
{
    protected $resolver;

    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Return implemented events.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            LookupEvent::EVENT => 'lookup',
        ];
    }

    public function lookup(LookupEvent $event)
    {
        $this->resolver->resolve($event->getHostname())->then(function ($ip) {
            EventManager::instance()->dispatch(BroadcastEvent::create([
                'type' => 'dns',
                'payload' => $ip,
            ]));
        }, function () {
            EventManager::instance()->dispatch(BroadcastEvent::create([
                'type' => 'dns',
                'payload' => 'IP TITLE FOUND',
            ]));
        });
    }
}
