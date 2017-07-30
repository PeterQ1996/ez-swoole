<?php
/**
 * Created by PhpStorm.
 * User: peterq
 * Date: 17-6-24
 * Time: 下午3:02
 */

namespace EzSwoole\Common;


interface SingletonContract
{
    /**
     * @return static
     */
    public static function getInstance();
}
