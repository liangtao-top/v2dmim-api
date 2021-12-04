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
// | Version: 2.0 2021/11/15 10:39
// +----------------------------------------------------------------------
namespace V2dmIM\Http\utils\abs;

use V2dmIM\Http\utils\PRC;

/**
 * 服务层基类
 */
abstract class Service
{

    /**
     * @var PRC
     */
    protected PRC $rpc;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->rpc = PRC::instance();
    }

}
