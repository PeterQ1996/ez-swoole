<?php
/**
 * Created by PhpStorm.
 * User: peterq
 * Date: 17-6-24
 * Time: 下午3:02
 */

namespace EzSwoole\Common;


trait Singleton
{
    protected static $instance = null;
    private function __construct()
    {
    }

    private function init()
    {

    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        if(!static::$instance){
            static::$instance = new static();
            static::$instance->init();
        }
        return static::$instance;
    }
}