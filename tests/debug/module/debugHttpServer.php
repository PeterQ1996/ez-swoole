<?php
include __DIR__ . '/../../../vendor/autoload.php';

$server = new \EzSwoole\Core\ProtocolServer\HttpServer('127.0.0.1', 8080);

$server->onRequest(function ($request, \EzSwoole\Core\Protocol\Http\Response $response){
    dump($request);
    swoole_timer_after(5000, function () use ($response){
        $response->status(403);
        $response->end('hello world');
    });
});
$server->run();