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
// | Version: 2.0 2019-10-09 10:56
// +----------------------------------------------------------------------

namespace V2dmIM\Http\service;

use V2dmIM\Http\utils\abs\Service;

class Demo extends Service
{

    /**
     * index
     * @param $param
     * @return bool
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2019-10-09 10:59
     */
    public function index($param): bool
    {
        $this->setResult($param);
        return true;
    }

    public function upload(array $files): bool
    {
        $this->setResult($files);
        return true;
    }
}
