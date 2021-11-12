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
// | Version: 2.0 2021/11/12 16:30
// +----------------------------------------------------------------------
namespace V2dmIM\Http\controller;

use V2dmIM\Http\common\Controller;

/**
 * 欢迎页
 */
class Index extends Controller
{
    public function index(): string
    {
        exec('cat /etc/issue', $result, $status);
        $os = str_replace(' \n \l', '', $result[0]) ?: PHP_OS;
        return '<meta charset="UTF-8"><style>*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei",serif; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>V2DMIM-HTTP<span style="font-size:30px"> v' . V2DMIM_VERSION . '</span><br/><span style="font-size:30px">' . $os . ' + ' . 'PHP v' . PHP_VERSION . ' + Swoole v' . SWOOLE_VERSION . '</span></p><span style="font-size:22px;">[ 由涛哥倾情奉献 - 异步 协程 高性能 网络通信引擎 ]</span></div><think parse="1" style="display: block; overflow: hidden;"><div class="think_default_text"><a>开发文档</a></div></think><script>document.title=\'V2DMIM HTTP\';</script>';
    }
}
