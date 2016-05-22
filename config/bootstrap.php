<?php

use Cake\Core\Configure;
use Cake\Event\EventManager;
use GuzzleHttp\Client;
use React\Dns\Resolver\Factory as ResolverFactory;
use React\EventLoop\Factory as EventLoopFactory;
use WyriHaximus\Cakefest2016\Event;
use WyriHaximus\React\GuzzlePsr7\HttpClientAdapter;

$loop = EventLoopFactory::create();
$resolver = (new ResolverFactory())->createCached('8.8.8.8', $loop);
$httpClient = new Client([
    'handler' => new HttpClientAdapter($loop, null, $dns),
]);

Configure::write('App.CakeFest2016', [
    'loop' => $loop,
]);

EventManager::instance()->on(new Event\SSEListener());
EventManager::instance()->on(new Event\LookupListener());
EventManager::instance()->on(new Event\DNSListener($resolver));
EventManager::instance()->on(new Event\GeoIPListener($httpClient));
EventManager::instance()->on(new Event\TitleListener($httpClient));
