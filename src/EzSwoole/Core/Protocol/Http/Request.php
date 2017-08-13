<?php

namespace EzSwoole\Core\Protocol\Http;

class Request {
    public $header  = [];
    public $server = [];
    public $get = [];
    public $post = [];
    public $cookie = [];
    public $files = [];
    public $rawContent = '';
    public $path = '';
    function __construct($arr)
    {
        // array('get' => $_GET, 'post' => $_POST,
        //    'cookie' => $_COOKIE, 'server' => $_SERVER, 'files' => $_FILES);
        $this->get = $arr['get'];
        $this->method = $arr['server']['REQUEST_METHOD'];
        $this->post = $arr['post'];
        $this->cookie = $arr['cookie'];
        $this->server = $arr['server'];
        $this->path = explode('?',$arr['server']['REQUEST_URI'])[0];
    }
}
