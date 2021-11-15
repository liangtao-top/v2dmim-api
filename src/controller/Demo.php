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
// | Version: 2.0 2019-09-29 10:13
// +----------------------------------------------------------------------

namespace V2dmIM\Http\controller;

use Swoole\Http\Request;
use Swoole\Http\Response;
use V2dmIM\Http\utils\abs\Controller;
use V2dmIM\Http\service\Demo as Service;

/**
 * 我是Demo,仅供学习使用
 */
class Demo extends Controller
{
    private Service $service;

    /**
     * Action白名单
     * @var array
     */
    protected array $allow = ['head'];

    /**
     * @param \Swoole\Http\Request  $request
     * @param \Swoole\Http\Response $response
     * @param string                $controllerName
     * @param string                $actionName
     */
    public function __construct(Request $request, Response $response, string $controllerName, string $actionName)
    {
        parent::__construct($request, $response, $controllerName, $actionName);
        $this->service = new Service;
    }

    /**
     * @OA\Head(
     *     path="/app.v1.demo/head/{GroupId}",
     *     tags={"Demo"},
     *     summary="我是Demo",
     *     @OA\Parameter(
     *         name="GroupId",
     *         in="path",
     *         description="分组ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *         example=1,
     *     ),
     *     @OA\Parameter(
     *         name="TypeId",
     *         in="query",
     *         description="类型ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *         example=1,
     *     ),
     *     @OA\Response(response=200,description="successful operation"),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function head()
    {
        $result = $this->service->index($this->request->getData());
        if (!$result) {
            return $this->service->getError();
        }
        return $this->service->getResult();
    }

    /**
     * @OA\Get(
     *     path="/app.v1.demo/get/{TypeId}",
     *     tags={"Demo"},
     *     summary="我是Demo",
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="GroupId",
     *         in="query",
     *         description="分组ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *         example=1,
     *     ),
     *     @OA\Parameter(
     *         name="TypeId",
     *         in="path",
     *         description="类型ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *         example=1,
     *     ),
     *     @OA\Parameter(
     *         name="tags[]",
     *         in="query",
     *         description="要筛选的标记",
     *         required=false,
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *             ),
     *         ),
     *         example={"vip","7天内登陆"},
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function get()
    {
        $result = $this->service->index($this->request->get);
        if (!$result) {
            return $this->service->getError();
        }
        return $this->service->getResult();
    }

    /**
     * @OA\Post(
     *     path="/app.v1.demo/post",
     *     tags={"Demo"},
     *     summary="我是Demo",
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/post")
     *         ),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function post()
    {
        $result = $this->service->index($this->request->post);
        if (!$result) {
            return $this->service->getError();
        }
        return $this->service->getResult();
    }

    /**
     * @OA\Put(
     *     path="/app.v1.demo/put",
     *     tags={"Demo"},
     *     summary="我是Demo",
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/post"),
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/post")
     *         ),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function put()
    {
        $result = $this->service->index($this->request->post);
        if (!$result) {
            return $this->service->getError();
        }
        return $this->service->getResult();
    }

    /**
     * @OA\Patch(
     *     path="/app.v1.demo/patch",
     *     tags={"Demo"},
     *     summary="我是Demo",
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/post"),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function patch()
    {
        $result = $this->service->index($this->request->post);
        if (!$result) {
            return $this->service->getError();
        }
        return $this->service->getResult();
    }

    /**
     * @OA\Delete(
     *     path="/app.v1.demo/delete",
     *     tags={"Demo"},
     *     summary="我是Demo",
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/post"),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function delete()
    {
        $result = $this->service->index($this->request->post);
        if (!$result) {
            return $this->service->getError();
        }
        return $this->service->getResult();
    }

    /**
     * @OA\Post(
     *     path="/app.v1.demo/fileUpload",
     *     tags={"File"},
     *     summary="单文件上传",
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/FileUpload")
     *         ),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function fileUpload()
    {
        $result = $this->service->upload($_FILES['data'] ?? []);
        if (!$result) {
            return $this->service->getError();
        }
        return $this->service->getResult();
    }

    /**
     * @OA\Post(
     *     path="/app.v1.demo/multiFileUpload",
     *     tags={"File"},
     *     summary="多文件上传",
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/multiFileUpload")
     *         ),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function multiFileUpload()
    {
        $result = $this->service->upload($_FILES['data']);
        if (!$result) {
            return $this->service->getError();
        }
        return $this->service->getResult();
    }

    /**
     * @OA\Get(
     *     path="/app.v1.demo/deprecated",
     *     tags={"Deprecated"},
     *     summary="我是Demo",
     *     deprecated=true,
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="随便输入测试",
     *         required=true,
     *         @OA\Schema(
     *              type="string",
     *              example="成都",
     *         ),
     *     ),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function deprecated()
    {
        $result = $this->service->index($this->request->post);
        if (!$result) {
            return $this->service->getError();
        }
        return $this->service->getResult();
    }

}
