<?php

namespace EzSwoole\Core\ProtocolServer;

use EzSwoole\Core\Protocol\Http\Http;
use EzSwoole\Core\Protocol\Http\Request;
use EzSwoole\Core\Protocol\Http\Response;
use EzSwoole\SwooleBridge\Server\ServerWithProtocol;

class HttpServer extends ServerWithProtocol {
    protected static $protocol = Http::class;

    protected $requestCb;

    public function __construct($host, $port, $mode = SWOOLE_PROCESS, $sock_type = SWOOLE_SOCK_TCP, array $settings = [])
    {
        parent::__construct($host, $port, $mode, $sock_type, $settings);

        $this->onPacket(function($fd, $packet) {
            $request = new Request($packet);
            $response = new Response($this->_server, $fd);
            ($this->requestCb)($request,  $response);
        });
    }

    public function onRequest($cb){
        $this->requestCb = $cb;
    }


}
