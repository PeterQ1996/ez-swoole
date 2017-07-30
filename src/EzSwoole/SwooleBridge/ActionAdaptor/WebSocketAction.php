<?php

namespace EzSwoole\SwooleBridge\ActionAdaptor;
use EzSwoole\Server;

abstract class WebSocketAction extends Adaptor {
    /**
     * @var \Swoole\WebSocket\Server
     */
    protected $server;
    public function __construct(\Swoole\WebSocket\Server $server)
    {
        parent::__construct($server);
    }

    abstract function onOpen(\swoole_websocket_server $svr, \swoole_http_request $req);
    abstract function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame);
}