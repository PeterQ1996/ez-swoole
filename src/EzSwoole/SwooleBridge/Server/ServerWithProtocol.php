<?php
namespace EzSwoole\SwooleBridge\Server;

use EzSwoole\Core\Protocol\ProtocolContract;
use EzSwoole\SwooleBridge\Wrapper\BufferManager;

class ServerWithProtocol extends Server {
    /**
     * @var ProtocolContract
     */
    protected static $protocol;

    protected $buffer;
    /**
     * @var callable
     */
    protected $packetHandler;

    public function __construct($host, $port, $mode = SWOOLE_PROCESS, $sock_type = SWOOLE_SOCK_TCP, array $settings = [])
    {
        parent::__construct($host, $port, $mode, $sock_type, $settings);
        $this->buffer = BufferManager::getInstance();
        $this->_server->on('Receive', [$this, 'onReceive']);
        $this->_server->on('Close', [$this, 'onClose']);
    }

    public function onPacket (callable $cb) {
        $this->packetHandler = $cb;
    }

    protected function dispatchPacket ($fd, $packet, $server) {
        $data =(static::$protocol)::decode($packet);
        ($this->packetHandler)($fd, $data, $server);
    }

    public function onClose(\swoole_server $server, int $fd, int $reactorId) {
        if ($this->buffer->has($this->bufferKey($fd)))
            $this->buffer->destroy($this->bufferKey($fd));
    }

    protected function bufferKey ($fd) {
        return "fd_packet_$fd";
    }

    public function onReceive (\swoole_server $server, int $fd, int $reactor_id, string $data) {
        $bufferKey= $this->bufferKey($fd);
        if($this->buffer->has($bufferKey)){
            $buffer = $this->buffer->get($bufferKey);
            $buffer->append($data);
            $length = (static::$protocol)::input($buffer->read(0, $buffer->length));
            if ($length === false) {
                dump('protocol error');
                $this->_server->close($fd);
                return;
            }
            if($length > 0){
                $packet = $buffer->read(0, $length);
                $left = $buffer->read($length, $buffer->length - $length);
                $buffer->clear();
                $buffer->append($left);
                $this->dispatchPacket($fd, $packet,$server);
            }
        } else{
            $length = (static::$protocol)::input($data);
            if ($length > 0) {
                $this->dispatchPacket($fd, $data,$server);
                return;
            }
            $buffer = $this->buffer->distributeBuffer($bufferKey);
            $buffer->append($data);
        }
    }


}

