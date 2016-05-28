<?php

namespace WyriHaximus\CakeFest2016\Event;

use Cake\Event\Event;
use React\Http\Request;
use React\Http\Response;

class LookupEvent extends Event
{
    const EVENT = 'WyriHaximus.CakeFest2016.lookup';

    public static function create($hostname)
    {
        return new static(static::EVENT, $hostname, $hostname);
    }

    public function getHostname()
    {
        return $this->data()[0];
    }
}
