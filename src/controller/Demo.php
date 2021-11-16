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

use V2dmIM\Http\utils\abs\Controller;
use V2dmIM\Http\service\Demo as Service;

/**
 * 我是Demo,仅供学习使用
 */
class Demo extends Controller
{

    private Service $service;

    /**
     * Action黑名单
     * @var array
     */
    protected array $deny = ['*'];

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->service = new Service;
    }

    /**
     * @OA\Head(
     *     path="/Demo/head/{GroupId}",
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
        $this->service->head($this->request->get);
    }

    /**
     * @OA\Get(
     *     path="/Demo/index",
     *     tags={"Demo"},
     *     summary="我是Demo",
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * )
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-09-29 17:30
     */
    public function index()
    {
        $this->service->index($this->request->get);
    }

    /**
     * @OA\Get(
     *     path="/Demo/get/{TypeId}",
     *     tags={"Demo"},
     *     summary="我是Demo",
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
        return $this->service->get($this->request->get);
    }

    /**
     * @OA\Post(
     *     path="/Demo/post",
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
        return $this->service->get($this->request->post);
    }

    /**
     * @OA\Put(
     *     path="/Demo/put",
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
        return $this->service->get($this->request->post);
    }

    /**
     * @OA\Patch(
     *     path="/Demo/patch",
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
        return $this->service->get(json_decode($this->request->getContent()));
    }

    /**
     * @OA\Delete(
     *     path="/Demo/delete",
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
        return $this->service->get(json_decode($this->request->getContent()));
    }

    /**
     * @OA\Post(
     *     path="/Demo/fileUpload",
     *     tags={"Demo"},
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
        return $this->service->upload(array_merge($this->request->post, $this->request->files));
    }

    /**
     * @OA\Post(
     *     path="/Demo/multiFileUpload",
     *     tags={"Demo"},
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
        return $this->service->upload(array_merge($this->request->post, $this->request->files));
    }

    /**
     * @OA\Get(
     *     path="/Demo/deprecated",
     *     tags={"Demo"},
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
        return $this->service->get($this->request->get);
    }

}
