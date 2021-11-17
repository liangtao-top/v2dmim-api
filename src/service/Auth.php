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

use RuntimeException;
use V2dmIM\Core\pool\PDOPool;
use V2dmIM\Http\utils\abs\Service;

class Auth extends Service
{

    public function userRegister(array $params)
    {
        $pool = PDOPool::instance();
        var_dump($pool);
        $pdo       = $pool->get();
        $statement = $pdo->prepare('SELECT ? + ?');
        if (!$statement) {
            throw new RuntimeException('Prepare failed');
        }
        $a      = mt_rand(1, 100);
        $b      = mt_rand(1, 100);
        $result = $statement->execute([$a, $b]);
        if (!$result) {
            throw new RuntimeException('Execute failed');
        }
        $result = $statement->fetchAll();
        print_r($result);
        if ($a + $b !== (int)$result[0][0]) {
            throw new RuntimeException('Bad result');
        }
        $pool->put($pdo);
        return $params;
    }

}
