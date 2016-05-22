<?php

namespace WyriHaximus\CakeFest2016\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use React\Http\Request;
use React\Http\Response;
use React\Http\Server as HttpServer;
use React\Socket\Server as SocketServer;
use WyriHaximus\CakeFest2016\Event\RequestEvent;

class ServerShell extends Shell
{
    public function start()
    {
        $loop = Configure::read('App.CakeFest2016.loop');
        $socket = new SocketServer($loop);
        $http = new HttpServer($socket, $loop);
        $http->on('request', function (Request $request, Response $response) {
            EventManager::instance()->dispatch(RequestEvent::create($request, $response));
        });
        $socket->listen(1337);
        $loop->run();
    }
}
