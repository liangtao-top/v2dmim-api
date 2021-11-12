<?php
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 2019-11-26 14:21
// +----------------------------------------------------------------------
namespace V2dmIM\Http\command;

use DateTime;
use V2dmIM\Core\utils\ip\LocalIP;
use V2dmIM\Core\utils\log\Log;
use Swoole\Server\Task;
use Swoole\Http\Server;
use Swoole\Http\{Request, Response};

/**
 * Class Server
 * @package app\controller
 */
class Service
{
    // HTTP 配置
    private array $config;

    // HTTP 服务实例
    private Server $server;

    /**
     * Server constructor.
     */
    public function __construct()
    {
        $this->config  = config();
        $swoole_config = $this->config ['swoole'] ?? [];
        Log::info('HTTP service start time ' . (new DateTime)->format('Y-m-d H:i:s'));
        Log::info('CPU number: ' . swoole_cpu_num());
        foreach (swoole_get_local_ip() as $key => $ip) {
            Log::info("$key  $ip");
            LocalIP::instance()->setIp($ip);
        }
        Log::info('PHP version: ' . PHP_VERSION);
        Log::info('SWOOLE version: ' . SWOOLE_VERSION);
        /** @noinspection PhpComposerExtensionStubsInspection */
        Log::info('Current process PID:' . posix_getpid());
        Log::info('Reactor number of Threads:' . $swoole_config['reactor_num']);
        Log::info('Worker number of processes:' . $swoole_config['worker_num']);
        Log::info('TaskWorker number of processes:' . $swoole_config['task_worker_num']);
        Log::info('Maximum number of connections:' . $swoole_config['max_connection']);
        Log::info('Process daemon:' . ($swoole_config['daemonize'] ? 'true' : 'false'));
        $this->server = new Server($this->config['host'], $this->config['port']);
        Log::info("Listen client urls http://{$this->config['host']}:{$this->config['port']}");
        $this->server->set($swoole_config);
    }

    /**
     * start
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/5/28 11:08
     */
    public function start()
    {
        // 事件绑定
        $this->bindEvent();
        $this->server->start();
    }

    /**
     * 绑定事件
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/10/30 10:56
     */
    public function bindEvent()
    {
        // 启动后在主进程（master）的主线程回调此函数
        $this->server->on('start', [$this, 'onStart']);
        // 当管理进程启动时触发此事件
        $this->server->on('managerStart', [$this, 'onManagerStart']);
        // 此事件在 Worker 进程 / Task 进程 启动时发生，这里创建的对象可以在进程生命周期内使用
        $this->server->on('managerStop', [$this, 'onManagerStop']);
        // 此事件在 Worker 进程 / Task 进程 启动时发生，这里创建的对象可以在进程生命周期内使用
        $this->server->on('workerStart', [$this, 'onWorkerStart']);
        // 此事件在 Worker 进程终止时发生。在此函数中可以回收 Worker 进程申请的各类资源。
        $this->server->on('workerStop', [$this, 'onWorkerStop']);
        // 有新的连接进入时，在 worker 进程中回调。
        $this->server->on('connect', [$this, 'onConnect']);
        // 监听Request消息事件
        $this->server->on('request', [$this, 'onRequest']);
        // 处理异步任务(此回调函数在task进程中执行)
        $this->server->on('task', [$this, 'onTask']);
        // 处理异步任务的结果(此回调函数在worker进程中执行)
        $this->server->on('finish', [$this, 'onFinish']);
        // 监听WebSocket连接关闭事件
        $this->server->on('close', [$this, 'onClose']);
        // 事件在 Server 正常结束时发生
        $this->server->on('shutdown', [$this, 'onShutdown']);
    }

    /**
     * 启动后在主进程（master）的主线程回调此函数
     * onStart 回调中，仅允许 echo、打印 Log、修改进程名称。不得执行其他操作 (不能调用 server 相关函数等操作，因为服务尚未就绪)。
     * onWorkerStart 和 onStart 回调是在不同进程中并行执行的，不存在先后顺序
     * @param Server $server
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/10/30 9:54
     * @noinspection PhpUnusedParameterInspection
     */
    public function onStart(Server $server)
    {
        $process_name = "php-swoole: master process";
        swoole_set_process_name($process_name);
        Log::info($process_name . ' started.');
    }

    /**
     * 当管理进程启动时触发此事件
     * @param Server $server
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/10/30 10:19
     * @noinspection PhpUnusedParameterInspection
     */
    public function onManagerStart(Server $server)
    {
        $process_name = "php-swoole: manager";
        swoole_set_process_name($process_name);
        Log::info($process_name . ' started.');
    }

    /**
     * 当管理进程停止时触发此事件
     * @param Server $server
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/4/8 14:04
     * @noinspection PhpUnusedParameterInspection
     */
    public function onManagerStop(Server $server)
    {
        Log::info("php-swoole: manager stop.");
    }

    /**
     * 此事件在 Worker 进程 / Task 进程 启动时发生，这里创建的对象可以在进程生命周期内使用
     * @param Server $server
     * @param int    $worker_id
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/10/30 9:56
     */
    public function onWorkerStart(Server $server, int $worker_id)
    {
        if ($worker_id >= $server->setting['worker_num']) {
            $process_name = "php-swoole: task-worker-$worker_id";
        } else {
            $process_name = "php-swoole: worker-$worker_id";
        }
        swoole_set_process_name($process_name);
        Log::info($process_name . ' started.');
    }

    /**
     * 此事件在 Worker 进程终止时发生。在此函数中可以回收 Worker 进程申请的各类资源。
     * @param Server $server
     * @param int    $worker_id
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/10/31 12:07
     */
    public function onWorkerStop(Server $server, int $worker_id)
    {
        if ($worker_id >= $server->setting['worker_num']) {
            $process_name = "php-swoole: task_worker $worker_id";
        } else {
            $process_name = "php-swoole: worker $worker_id process";
        }
        Log::info($process_name . ' process stop.');
    }

    /**
     * 有新的连接进入时，在 worker 进程中回调。
     * @param Server $server
     * @param int    $fd
     * @param int    $reactorId
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/10/31 12:28
     */
    public function onConnect(Server $server, int $fd, int $reactorId)
    {
        Log::info("New connection fd: $fd reactorId: $reactorId total connections " . count($server->connections));
    }

    /**
     * HTTP服务
     * @param Request  $request
     * @param Response $response
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/10/30 10:34
     */
    public function onRequest(Request $request, Response $response)
    {
        // 支持跨域
        $response->header('Access-Control-Allow-Origin', '*');
        // OPTIONS返回
        if ($request->server['request_method'] == 'OPTIONS') {
            $response->status(http_response_code());
            $response->end();
            return;
        }
        // Chrome浏览器访问服务器，会产生额外的一次请求
        if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
            $response->header('Content-Type', 'image/x-icon');
            $response->end(file_get_contents(APP_PATH . DS . 'favicon.ico'));
            return;
        }
        Log::info("{$request->server['server_protocol']} {$request->server['request_method']} from uri:{$request->server['request_uri']} ip:{$request->server['remote_addr']} fd:$request->fd ");
        Handle::request($request, $response);
        $this->server->close($response->fd);
    }

    /**
     * 在 task 进程内被调用。
     * @param Server $server
     * @param Task   $task
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/11/25 17:44
     */
    public function onTask(Server $server, Task $task)
    {
        $use = microtime(true);
        Log::task("New AsyncTask[id=$task->id]");
        $task_id = $task->id;
        $from_id = $task->worker_id;
        $data    = $task->data;
        $result  = Handle::task($server, $task_id, $from_id, $data);
        if ($result) {
            if (isset($data['arg']) && is_array($data['arg'])) {
                array_push($data['arg'], $result);
            } else {
                $data['arg'] = $result;
            }
        }
        $data['use_task_time'] = $use;
        //返回任务执行的结果
        $task->finish($data);
    }

    /**
     * 此回调函数在 worker 进程被调用，当 worker 进程投递的任务在 task 进程中完成时， task 进程会通过 Swoole\Server->finish() 方法将任务处理的结果发送给 worker 进程
     * @param Server $server
     * @param int    $task_id
     * @param mixed  $data
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/10/30 10:14
     */
    public function onFinish(Server $server, int $task_id, mixed $data)
    {
        Handle::finish($server, $task_id, $data);
        Log::task('AsyncTask[$task_id] finish use ' . ((microtime(true) - $data['use_task_time']) * 1000) . ' ms');
    }

    /**
     * TCP 客户端连接关闭后，在 worker 进程中回调此函数。
     * @param Server $server
     * @param int    $fd
     * @param int    $reactorId
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/10/30 10:06
     */
    public function onClose(Server $server, int $fd, int $reactorId)
    {
        Log::info("Close fd: $fd ReactorID: $reactorId");
    }

    /**
     * 此事件在 Server 正常结束时发生
     * 强制 kill 进程不会回调 onShutdown，如 kill -9
     * 需要使用 kill -15 来发送 SIGTREM 信号到主进程才能按照正常的流程终止
     * 在命令行中使用 Ctrl+C 中断程序会立即停止，底层不会回调 onShutdown
     * @param Server $server
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/10/30 9:51
     * @noinspection PhpUnusedParameterInspection
     */
    public function onShutdown(Server $server)
    {
        Log::info("php-swoole: master process stop.");
    }
}
