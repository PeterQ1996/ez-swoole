<?php

namespace EzSwoole\SwooleBridge\Wrapper;

use Swoole\Buffer;
use EzSwoole\Common\Singleton;

/**
 * Class BufferManager
 * @package EzSwoole\SwooleBridge\Wrapper
 * @method string read($bufKey, int $offset, int $length)
 */
class BufferManager
{
    use Singleton;

    protected $pool = [];

    protected $map = [];

    public function length($key)
    {
        if(!isset($this->map[$key]))
            throw new \Exception("key: $key does not exist in buffer pool");
        return $this->map[$key]['buffer']->length;
    }
    public function capacity($key)
    {
        if(!isset($this->map[$key]))
            throw new \Exception("key: $key does not exist in buffer pool");
        return $this->map[$key]['buffer']->capacity;
    }

    public function distributeBuffer($key)
    {
        if(isset($this->map[$key]))
            throw new \Exception('Buffer key is already in use');
        $i = null;
        $index = -1;
        foreach ($this->pool as $index=>$item)// find a spare one
            if(!$item['used']){
                $i = $index;
                break;
            }

        if($i === null){
            $this->pool[++$index] = [
                'used' => false,
                'buffer' => new Buffer(128)
            ];
            $i = $index;
        }
        $this->pool[$i]['used'] = true;
        $this->map[$key] = &$this->pool[$i];
        return $this->get($key);
    }

    public function has ($key)
    {
        return isset($this->map[$key]);
    }

    /**
     * @param $key
     * @return Buffer|null
     */
    public function get ($key) {
        return isset($this->map[$key])? $this->map[$key]['buffer'] : null;
    }

    public function __call($name, $arguments)
    {
        $key = array_shift($arguments);
        if(!isset($this->map[$key]))
            throw new \Exception("key: $key does not exist in buffer pool");
        $buffer = $this->map[$key]['buffer'];
        if(!method_exists($buffer, $name))
            throw new \Exception("method: $name dose not exist in buffer object");
        return $buffer->{$name}(...$arguments);
    }

    public function destroy($key)
    {
        if(!isset($this->map[$key]))
            return false;
        $this->map[$key]['used'] = false;
        $buffer = $this->map[$key]['buffer'];
        $buffer->clear();
        unset($this->map[$key]);
        return true;
    }
}