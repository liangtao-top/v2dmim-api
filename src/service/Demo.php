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
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/11/15 14:29
     */
    public function index($param)
    {
        throw new \RuntimeException('RuntimeException', 1000);

    }

    /**
     * head
     * @param $param
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/11/15 14:32
     */
    public function head($param)
    {
      var_dump($param);
    }

    /**
     * get
     * @param $param
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/11/15 14:29
     */
    public function get($param)
    {
        return $param;
    }

    /**
     * upload
     * @param array $files
     * @return array
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/11/15 14:30
     */
    public function upload(array $files): array
    {
        return $files;
    }

}
