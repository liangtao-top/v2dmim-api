<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 2021/11/12 17:39
// +----------------------------------------------------------------------
namespace V2dmIM\Http\utils\abs;

use Swoole\Http\Request;
use Swoole\Http\Response;
use V2dmIM\Http\utils\Auth;

/**
 * 控制器基类
 */
abstract class Controller
{

    /**
     * HTTP 请求对象，保存了 HTTP 客户端请求的相关信息，包括 GET、POST、COOKIE、Header 等
     * @var \Swoole\Http\Request
     */
    protected Request $request;

    /**
     * HTTP 响应对象，通过调用此对象的方法，实现 HTTP 响应发送
     * @var \Swoole\Http\Response
     */
    protected Response $response;

    /**
     * 允许未登录授权访问的黑名单
     * 如果黑名单不为空,则黑名单之外的方法全部允许未登录状态访问;如果黑名单和白名单同时设置,则黑名单优先级大于白名单
     * @var array
     */
    protected array $deny = [];

    /**
     * 允许未登录授权访问的白名单
     * 如果白名单不为空,则白名单之外的方法全部禁止未登录状态访问
     * @var array
     */
    protected array $allow = [];

    /**
     * 控制器类名
     * @var string
     */
    protected string $controllerName;

    /**
     * 操作方法名
     * @var string
     */
    protected string $actionName;


    /**
     * 控制器是否输出原始数据
     * @var bool
     */
    protected bool $origin = false;

    /**
     * 构造函数
     * @param \Swoole\Http\Request  $request
     * @param \Swoole\Http\Response $response
     * @param string                $controllerName
     * @param string                $actionName
     */
    public function __construct(Request $request, Response $response, string $controllerName, string $actionName)
    {
        $this->request        = $request;
        $this->response       = $response;
        $this->controllerName = $controllerName;
        $this->actionName     = $actionName;
        if (Auth::autoLogin($this->request->header) === false) {
            access_control($this->controllerName, $this->actionName, $this->deny, $this->allow);
        }
    }

    /**
     * 控制器是否输出原始数据
     * @return bool
     */
    public function isOrigin(): bool
    {
        return $this->origin;
    }

}
