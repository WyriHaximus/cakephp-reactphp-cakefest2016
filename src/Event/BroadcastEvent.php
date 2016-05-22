<?php

namespace WyriHaximus\CakeFest2016\Event;

use Cake\Event\Event;
use React\Http\Request;
use React\Http\Response;

class BroadcastEvent extends Event
{
    const EVENT = 'WyriHaximus.CakeFest2016.broadcast';

    public static function create(array $data)
    {
        return new static(static::EVENT, $data, $data);
    }
}
