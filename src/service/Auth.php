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
// | Version: 2.0 2021/11/15 16:53
// +----------------------------------------------------------------------
namespace V2dmIM\Http\service;

use V2dmIM\Http\utils\abs\Service;

class Auth extends Service
{

    public function userRegister(array $params): array
    {
        return $this->rpc->send(__FUNCTION__, $params);
    }

}
