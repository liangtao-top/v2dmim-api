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
// | Version: 2.0 2021/11/15 15:19
// +----------------------------------------------------------------------
namespace V2dmIM\Http\controller;

use RuntimeException;
use V2dmIM\Http\utils\abs\Controller;
use V2dmIM\Http\service\Auth as Service;
use V2dmIM\Http\validate\Auth as Validate;

class Auth extends Controller
{
    /**
     * 白名单
     * @var array|string[]
     */
    protected array $allow = ["userRegister"];

    /**
     * 服务类
     * @var \V2dmIM\Http\service\Auth
     */
    private Service $service;

    /**
     * 验证类
     * @var \V2dmIM\Http\validate\Auth
     */
    private Validate $validate;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->service  = new Service;
        $this->validate = new Validate;
    }

    /**
     * @OA\Post(
     *     path="/Auth/userRegister",
     *     tags={"Auth"},
     *     summary="注册新用户",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/Auth.userRegister")
     *         ),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function userRegister()
    {
        $result = $this->validate->scene(__FUNCTION__)->check($this->request->post);
        if (false === $result) {
            // 验证失败 输出错误信息
            throw new RuntimeException($this->validate->getError());
        }
        return $this->service->userRegister($this->request->post);
    }

}
