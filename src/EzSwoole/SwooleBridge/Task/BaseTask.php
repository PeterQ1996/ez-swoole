<?php

namespace EzSwoole\SwooleBridge\Task;

use Swoole\Serialize;

abstract class BaseTask
{
    protected $id;

    protected $result;

    protected $status;

    protected $data;

    public function __construct($data)
    {
        $this->id = uniqid('task_');
        $this->data = $data;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $data
     * @return BaseTask
     */
    public static function unpack($data)
    {
        return Serialize::unpack($data);
    }

    abstract public function deal();

    public function __toString()
    {
        return Serialize::pack($this);
    }
}
