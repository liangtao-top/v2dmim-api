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

use Exception;
use Throwable;
use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use V2dmIM\Core\utils\log\Log;

/**
 * 事件处理
 */
class Handle
{

    /**
     * request
     * @param Request  $request
     * @param Response $response
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/10/31 13:36
     */
    public static function request(Request $request, Response $response)
    {
        $uri            = explode('/', trim($request->server['request_uri'], '/'));
        $actionName     = parse_name(($uri[1] ?? 'index') ?: 'index', 1, false);
        $controllerName = ($uri[0] ?? null) ?: 'Index';
        $controllerFull = '\V2dmIM\Http\controller\\' . parse_name($controllerName, 1);
        if (!class_exists($controllerFull)) {
            $response->end(error('Non-existent: ' . $controllerFull . '::class'));
            return;
        }
        try {
            $class = new $controllerFull($request, $response, $controllerName, $actionName);
        } catch (Exception $exception) {
            $response->end(error($exception->getMessage(), $exception->getCode()));
            return;
        }
        if (!method_exists($class, $actionName)) {
            $response->end(error('Non-existent: ' . $controllerFull . '::' . $actionName));
            return;
        }
        try {
            $result = $class->$actionName();
            $response->end($class->isOrigin() ? $result : success($result));
        } catch (Throwable $e) {
            Log::error($e->__toString());
            $response->end(error($e->getMessage(), $e->getCode()));
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
