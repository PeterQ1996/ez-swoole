<?php

namespace EzSwoole\SwooleBridge\ActionAdaptor;

use EzSwoole\Server;
use swoole_server;
use EzSwoole\SwooleBridge\Task\BaseTask;

abstract class Adaptor
{

    protected $server;
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * master process callback
     * @param Server|\swoole_server $server
     * @return mixed
     */
    abstract function onStart(\swoole_server $server); // master 进程回调

    /**
     * 文档没写,猜测是主进程回调
     * @param \swoole_server|swoole_server $server
     * @return mixed
     */
    abstract function onShutdown(\swoole_server $server);

    /**
     * worker process callback
     * @param swoole_server $server
     * @param int $worker_id
     * @return mixed
     */
    abstract function onWorkerStart(\swoole_server $server, int $worker_id);

    /**
     * worker callback
     * @param swoole_server $server
     * @param int $worker_id
     * @return mixed
     */
    abstract function onWorkerStop(\swoole_server $server, int $worker_id);

    /**
     * 定时器触发,根据inerval判断是那个定时器,配合addTimer
     * @param swoole_server $server
     * @param int $interval
     * @return mixed
     */
    // abstract function onTimer(\swoole_server $server, int $interval); // 定时器触发,根据inerval判断是那个定时器

    /**
     * worker callback
     * @param swoole_server $server
     * @param int $fd
     * @param int $from_id
     * @return mixed
     */
    abstract function onConnect(\swoole_server $server, int $fd, int $from_id); // worker进程回调

    /**
     * worker callback
     * @param swoole_server $server
     * @param int $fd
     * @param int $reactor_id
     * @param string $data
     * @return mixed
     */
    abstract function onReceive(\swoole_server $server, int $fd, int $reactor_id, string $data); //worker进程回调

    /**
     * worker callback, udp package
     * @param swoole_server $server
     * @param string $data
     * @param array $client_info
     * @return mixed
     */
    abstract function onPacket(\swoole_server $server, string $data, array $client_info);// worker进程回调

    /**
     * worker callback
     * @param swoole_server $server
     * @param int $fd
     * @param int $reactorId
     * @return mixed
     */
    abstract function onClose(\swoole_server $server, int $fd, int $reactorId); // worker进程回调

    /**
     * task callback task进程回调
     * @param swoole_server $serv
     * @param int $task_id
     * @param int $src_worker_id
     * @param mixed $data
     * @return mixed
     */
    public function onTask(\swoole_server $serv, int $task_id, int $src_worker_id, $data)
    {
        $task = BaseTask::unpack($data);
        $task->deal();
        $serv->finish($task);
    }

    /**
     * worker callback
     * @param swoole_server $serv
     * @param int $task_id
     * @param string $data
     * @return mixed
     */
    abstract function onFinish(\swoole_server $serv, int $task_id, string $data); // worker进程回调

    /**
     * task and worker callback
     * @param swoole_server $server
     * @param int $from_worker_id
     * @param string $message
     * @return mixed
     */
    abstract function onPipeMessage(\swoole_server $server, int $from_worker_id, string $message); // task及worker进程回调

    /**
     * task and worker callback
     * @param swoole_server $serv
     * @param int $worker_id
     * @param int $worker_pid
     * @param int $exit_code
     * @param int $signal
     * @return mixed
     */
    abstract function onWorkerError(\swoole_server $serv, int $worker_id, int $worker_pid, int $exit_code, int $signal);// task,worker进程出错,在manager进程中回调

    /**
     * manager callback
     * @param swoole_server $serv
     * @return mixed
     */
    abstract function onManagerStart(\swoole_server $serv); // manager 进程回调

    /**
     * manager callback
     * @param swoole_server $serv
     * @return mixed
     */
    abstract function onManagerStop(\swoole_server $serv); // 很明

}