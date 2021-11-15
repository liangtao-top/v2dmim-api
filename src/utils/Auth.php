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
// | Version: 2.0 2021/11/15 11:37
// +----------------------------------------------------------------------
namespace V2dmIM\Http\utils;

class Auth
{

    /**
     * 自动登录
     * @param array $header
     * @return array|false
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/11/15 11:42
     */
    public static function autoLogin(array $header): array|false
    {
        $auth = null;
        if (isset($header['Authorization'])) {
            $auth = $header['Authorization'];
        } elseif (isset($request->header['authorization'])) {
            $auth = $header['authorization'];
        }
        if (is_null($auth) || empty($http_auth)) {
            return false;
        }
        // TODO:执行自动登录业务逻辑代码...
        return [];
    }
}
