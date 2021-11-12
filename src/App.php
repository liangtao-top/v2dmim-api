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
// | Version: 2.0 2021/11/12 12:29
// +----------------------------------------------------------------------
namespace V2dmIM\Http;

use V2dmIM\Http\command\Service;

class App
{

    public static function run()
    {
        (new Service)->start();
    }

}
