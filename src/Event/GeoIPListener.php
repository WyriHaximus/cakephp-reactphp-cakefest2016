<?php

namespace WyriHaximus\CakeFest2016\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GeoIPListener implements EventListenerInterface
{
    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
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
        $this->httpClient->getAsync('https://freegeoip.net/json/' . $event->getHostname())->then(function (ResponseInterface $response) {
            EventManager::instance()->dispatch(BroadcastEvent::create([
                'type' => 'geo',
                'payload' => json_decode($response->getBody()->getContents())->region_name,
            ]));
        }, function () use ($event) {
            EventManager::instance()->dispatch(BroadcastEvent::create([
                'type' => 'geo',
                'payload' => 'NO LOCATION FOUND',
            ]));
        });
    }
}
