<?php

namespace EzSwoole\SwooleBridge\Server;

use Swoole\Server as SwooleServer;
use EzSwoole\SwooleBridge\ActionAdaptor\WebSocketAction;
use EzSwoole\SwooleBridge\Task\BaseTask;

class Server {

    protected $_server;

    protected static $this;

    protected static $fromPort = false;

    protected $_settings = [
        'worker_num' => 2,
        'reactor_num' => 4,
        'max_request' => 1000,
        'daemonize' => 0
    ];

    protected $actionAdaptor = null;

    public function __construct($host, $port, $mode = SWOOLE_PROCESS,
                                $sock_type = SWOOLE_SOCK_TCP, $settings = [])
    {
        if (static::$fromPort) {
            $this->_server = $host;
        } else {
            if(static::$this)
                throw new \Error("you can create only one server in an application");
            $this->_server = new SwooleServer($host, $port);
            $this->_settings = array_merge($this->_settings, $settings);
            $this->_server->set($this->_settings);
            static::$this = $this;
        }
    }

    public function run(){
        if($this->actionAdaptor){
            $methods = get_class_methods(get_class($this->actionAdaptor));
            foreach ($methods as $m){
                $rfMethod = new \ReflectionMethod(get_class($this->actionAdaptor, $m));
                if(strpos($m,'on') === 0)
                    if(!isset($rfMethod->getStaticVariables()['_stub']))
                        $this->_server->on(substr($m,2,strlen($m)),[$this->actionAdaptor,$m]);

            }
        }
        $this->_server->start();
    }

    public function setCallbacks(array $calls){
        foreach ($calls as $evt => $fun){
            $this->_server->on($evt,$fun);
        }
    }

    public function setActionAdaptor (WebSocketAction $adaptor)
    {
        $this->actionAdaptor = $adaptor;
    }

    public function task(BaseTask $task)
    {
        $this->_server->task($task);
    }

    public function getRealServer()
    {
        return $this->_server;
    }

    public static function getInstance()
    {
        return static::$this;
    }

    public static function fromPort ($port) {
        static::$fromPort = true;
        $server = new static($port, 0);
        static::$fromPort = false;
        return $server;
    }

}