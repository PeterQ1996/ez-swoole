<?php

namespace EzSwoole\Core\Protocol\Http;

use EzSwoole\SwooleBridge\Wrapper\BufferManager;
use Swoole\Buffer;

class Response {

    public static $codes = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );

    protected $headers  = [
        'Content-Type' => "text/html;charset=utf-8",
        'Server' => 'swoole/PeterQHttpServer'
    ];

    protected $http_status_code = 200;

    protected $buffer;

    protected $tcpServer;

    protected $fd;

    protected $sent = false;

    function __construct(\swoole_server $tcpServer, $fd) {
        $this->fd = $fd;
        $this->tcpServer = $tcpServer;
        $this->buffer = new Buffer(512);
    }

    public function cookie(string $key, string $value = '',
                           int $expire = 0 , string $path = '/',
                           string $domain  = '', bool $secure = false,
                           bool $httponly = false)
    {
        // @todo finish cookie method
    }

    public function status(int $http_status_code){
        $this->http_status_code = $http_status_code;
    }

    public function header($k, $v){
        $this->headers[$k] = $v;
    }

    public function gzip(int $level = 1){

    }

    public function write($data){
        $this->buffer->append($data);
    }

    public function end($data = '') {
        if($this->sent)return;
        $this->sent = true;
        $this->buffer->append($data);
        $this->sendHeader();
        $this->tcpServer->send($this->fd, $this->buffer->read(0, $this->buffer->length));
        $this->tcpServer->close($this->fd);
    }

    protected function sendHeader () {
        $header = 'HTTP/1.1 '. $this->http_status_code .' ' . static::$codes[$this->http_status_code]."\r\n";
        if(!isset($this->headers['Content-Length']))
            $this->header('Content-Length', $this->buffer->length);
        foreach ($this->headers as $k => $v){
            $header .= $k .': '.$v . "\r\n";
        }
        $header .= "\r\n";
        $this->tcpServer->send($this->fd, $header);
    }

    public function sendFile($path){
        if($this->sent) return false;
        $this->sent =  true;
        $this->header('Content-Length', filesize($path));
        $this->sendHeader();
        return $this->tcpServer->sendfile($this->fd, $path);
    }
}
