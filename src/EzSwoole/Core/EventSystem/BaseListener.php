<?php

namespace EzSwoole\Core\EventSystem;

use EzSwoole\Common\Singleton;
use EzSwoole\Core\EventSystem\BaseEvent;
use EzSwoole\Core\EventSystem\Driver;

abstract class BaseListener
{
    use Singleton;
    /**
     * @var Driver
     */
    protected $driver;


    protected static $event = null;

    protected function init()
    {
        $this->driver = Driver::getInstance();
    }

    public function getEventName()
    {
        return static::$event;
    }

    public function handle() {

    }
}

