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
// | Version: 2.0 2020-01-19 13:36
// +----------------------------------------------------------------------

namespace V2dmIM\Http\command;

use V2dmIM\Core\utils\log\Log;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
use Throwable;

class Handle
{

    /**
     * request
     * @param Request  $request
     * @param Response $response
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/10/31 13:36
     */
    public static function request(Request &$request, Response &$response)
    {
        // URL 路由
        $uri        = explode('/', trim($request->server['request_uri'], '/'));
        $controller = $uri[0] ?? null;
        $controller = $controller ?: 'Index';
        $controller = '\V2dmIM\Http\controller\\' . parse_name($controller, 1);
        $action     = parse_name(($uri[1] ?? 'index') ?: 'index', 1, false);
        // 根据 $controller, $action 映射到不同的控制器类和方法
        if (!class_exists($controller)) {
            $response->end(error('Non-existent: ' . $controller . '::class'));
            return;
        }
        $class = new $controller;
        if (!method_exists($class, $action)) {
            $response->end(error('Non-existent: ' . $controller . '::' . $action));
            return;
        }
        try {
            $result = $class->$action($request, $response);
            $response->end($result);
        } catch (Throwable $e) {
            Log::error($e->__toString());
            $response->status(500);
            $response->end(error('Server exception!'));
        }
    }

    /**
     * task
     * @param \Swoole\Http\Server      $server
     * @param                          $task_id
     * @param                          $from_id
     * @param                          $data
     * @return mixed
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/5/28 15:44
     * @noinspection DuplicatedCode
     */
    public static function task(Server &$server, $task_id, $from_id, $data): mixed
    {
        unset($task_id);
        unset($from_id);
        if (empty($data) || !is_array($data) || !isset($data['class']) || !isset($data['method'])) {
            Log::error('数据异常');
            return false;
        }
        $class  = $data['class'];
        $method = $data['method'] . 'Before';
        if (!class_exists($class)) {
            Log::warning('Non-existent: ' . $class . '::class');
            return false;
        }
        $controller = new $class;
        if (!method_exists($controller, $method)) {
            Log::warning('Non-existent: ' . $class . '::' . $method);
            return false;
        }
        try {
            if (isset($data['arg'])) {
                $arg = $data['arg'];
                if (!is_array($arg)) {
                    return $controller->$method($server, $arg);
                }
                array_unshift($arg, $server);
                return call_user_func_array([$controller, $method], $arg);
            }
            return $controller->$method($server);
        } catch (Throwable $e) {
            Log::error($e->__toString());
            return false;
        }
    }

    /**
     * finish
     * @param \Swoole\Http\Server      $server
     * @param                          $task_id
     * @param                          $data
     * @return mixed
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/5/28 15:45
     * @noinspection DuplicatedCode
     */
    public static function finish(Server &$server, $task_id, $data): mixed
    {
        unset($task_id);
        if (empty($data) || !is_array($data) || !isset($data['class']) || !isset($data['method'])) {
            Log::error('数据异常');
            return false;
        }
        $class  = $data['class'];
        $method = $data['method'] . 'After';
        if (!class_exists($class)) {
            Log::warning('Non-existent: ' . $class . '::class');
            return false;
        }
        $controller = new $class;
        if (!method_exists($controller, $method)) {
            Log::warning('Non-existent: ' . $class . '::' . $method);
            return false;
        }
        try {
            if (isset($data['arg'])) {
                $arg = $data['arg'];
                if (!is_array($arg)) {
                    return $controller->$method($server, $arg);
                }
                array_unshift($arg, $server);
                return call_user_func_array([$controller, $method], $arg);
            }
            return $controller->$method($server);
        } catch (Throwable $e) {
            Log::error($e->__toString());
            return false;
        }
    }

    /**
     * 连接关闭事件
     * @param Server $server
     * @param int    $fd
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2019-11-29 20:36
     */
    public static function close(Server &$server, int $fd)
    {
//        DeviceDao::del($fd);
//        $online = OnlineDao::get($fd);
//        if ($online) OnlineDao::del($online);
    }
}
