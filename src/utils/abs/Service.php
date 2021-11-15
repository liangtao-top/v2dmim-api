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

use V2dmIM\Core\struct\Error;

class Service
{

    /**
     * 错误
     * @var Error
     */
    private Error $error;

    /**
     * 返回结果
     * @var mixed
     */
    private mixed $result = '';

    /**
     * @return \V2dmIM\Core\struct\Error
     */
    public function getError(): Error
    {
        return $this->error;
    }

    /**
     * @param \V2dmIM\Core\struct\Error $error
     */
    public function setError(Error $error): void
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getResult(): mixed
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult(mixed $result): void
    {
        $this->result = $result;
    }

}
