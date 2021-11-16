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
// | Version: 2.0 2019/7/8 13:49
// +----------------------------------------------------------------------

namespace V2dmIM\Http\controller;

use OpenApi\Generator;
use V2dmIM\Http\utils\abs\Controller;

/**
 * Swagger-v3 文档动态编译实现
 */
class ApiDocs extends Controller
{

    /**
     * Action白名单
     * @var array
     */
    protected array $allow = ['index'];

    /**
     * app文档
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/2/10 13:57
     */
    public function index(): string
    {
        $open_api = Generator::scan([APP_PATH . DS . 'src']);
        $this->response->header('Content-Type', 'application/json');
        $this->origin = true;
        return $open_api->toJson();
    }

}
