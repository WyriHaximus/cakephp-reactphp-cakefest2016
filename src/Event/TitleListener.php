<?php

namespace WyriHaximus\CakeFest2016\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class TitleListener implements EventListenerInterface
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
        $this->httpClient->getAsync('https://' . $event->getHostname())->then(function (ResponseInterface $response) {
            if (preg_match('/<title>(.+)<\/title>/', $response->getBody()->getContents(), $matches) && isset($matches[1])) {
                EventManager::instance()->dispatch(BroadcastEvent::create([
                    'type' => 'title',
                    'data' => $matches[1],
                ]));
                return;
            }

            EventManager::instance()->dispatch(BroadcastEvent::create([
                'type' => 'title',
                'data' => 'NO TITLE FOUND',
            ]));
        });
    }
}
