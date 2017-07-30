<?php
/**
 * Created by PhpStorm.
 * User: peterq
 * Date: 17-6-24
 * Time: 下午4:11
 */

namespace EzSwoole\SwooleBridge\ActionAdaptor;


use Swoole\Server;
use swoole_server;

class WebSocketActionStub extends WebSocketAction
{

    /**
     * master process callback
     * @param Server|\swoole_server $server
     * @return mixed
     */
    function onStart(\swoole_server $server)
    {
        // TODO: Implement onStart() method.
    }

    /**
     * 文档没写,猜测是主进程回调
     * @param \swoole_server|swoole_server $server
     * @return mixed
     */
    function onShutdown(\swoole_server $server)
    {
        // TODO: Implement onShutdown() method.
    }

    /**
     * worker process callback
     * @param swoole_server $server
     * @param int $worker_id
     * @return mixed
     */
    function onWorkerStart(\swoole_server $server, int $worker_id)
    {
        // TODO: Implement onWorkerStart() method.
    }

    /**
     * worker callback
     * @param swoole_server $server
     * @param int $worker_id
     * @return mixed
     */
    function onWorkerStop(\swoole_server $server, int $worker_id)
    {
        // TODO: Implement onWorkerStop() method.
    }

    /**
     * 定时器触发,根据inerval判断是那个定时器,配合addTimer
     * @param swoole_server $server
     * @param int $interval
     * @return mixed
     */
//    function onTimer(\swoole_server $server, int $interval)
//    {
//        // TODO: Implement onTimer() method.
//    }

    /**
     * worker callback
     * @param swoole_server $server
     * @param int $fd
     * @param int $from_id
     * @return mixed
     */
    function onConnect(\swoole_server $server, int $fd, int $from_id)
    {
        // TODO: Implement onConnect() method.
    }

    /**
     * worker callback
     * @param swoole_server $server
     * @param int $fd
     * @param int $reactor_id
     * @param string $data
     * @return mixed
     */
    function onReceive(\swoole_server $server, int $fd, int $reactor_id, string $data)
    {
        // TODO: Implement onReceive() method.
    }

    /**
     * worker callback, udp package
     * @param swoole_server $server
     * @param string $data
     * @param array $client_info
     * @return mixed
     */
    function onPacket(\swoole_server $server, string $data, array $client_info)
    {
        // TODO: Implement onPacket() method.
    }

    /**
     * worker callback
     * @param swoole_server $server
     * @param int $fd
     * @param int $reactorId
     * @return mixed
     */
    function onClose(\swoole_server $server, int $fd, int $reactorId)
    {
        // TODO: Implement onClose() method.
    }

    /**
     * task callback
     * @param swoole_server $serv
     * @param int $task_id
     * @param int $src_worker_id
     * @param mixed $data
     * @return mixed
     */
    function onTask(\swoole_server $serv, int $task_id, int $src_worker_id, $data)
    {
        // TODO: Implement onTask() method.
    }

    /**
     * worker callback
     * @param swoole_server $serv
     * @param int $task_id
     * @param string $data
     * @return mixed
     */
    function onFinish(\swoole_server $serv, int $task_id, string $data)
    {
        // TODO: Implement onFinish() method.
    }

    /**
     * task and worker callback
     * @param swoole_server $server
     * @param int $from_worker_id
     * @param string $message
     * @return mixed
     */
    function onPipeMessage(\swoole_server $server, int $from_worker_id, string $message)
    {
        // TODO: Implement onPipeMessage() method.
    }

    /**
     * task and worker callback
     * @param swoole_server $serv
     * @param int $worker_id
     * @param int $worker_pid
     * @param int $exit_code
     * @param int $signal
     * @return mixed
     */
    function onWorkerError(\swoole_server $serv, int $worker_id, int $worker_pid, int $exit_code, int $signal)
    {
        // TODO: Implement onWorkerError() method.
    }

    /**
     * manager callback
     * @param swoole_server $serv
     * @return mixed
     */
    function onManagerStart(\swoole_server $serv)
    {
        // TODO: Implement onManagerStart() method.
    }

    /**
     * manager callback
     * @param swoole_server $serv
     * @return mixed
     */
    function onManagerStop(\swoole_server $serv)
    {
        // TODO: Implement onManagerStop() method.
    }

    function onOpen(\swoole_websocket_server $svr, \swoole_http_request $req)
    {
        // TODO: Implement onOpen() method.
    }

    function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        // TODO: Implement onMessage() method.
    }

}