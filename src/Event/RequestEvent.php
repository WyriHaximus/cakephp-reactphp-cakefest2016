<?php

namespace WyriHaximus\CakeFest2016\Event;

use Cake\Event\Event;
use React\Http\Request;
use React\Http\Response;

class RequestEvent extends Event
{
    const EVENT = 'WyriHaximus.CakeFest2016.request';

    public static function create(Request $request, Response $response)
    {
        return new static(static::EVENT, $request, [
            'request'  => $request,
            'response' => $response,
        ]);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->data()['request'];
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->data()['response'];
    }
}
