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
// | Version: 2.0 2019-10-09 10:48
// +----------------------------------------------------------------------

namespace V2dmIM\Http\validate;

use V2dmIM\Http\utils\abs\Validate;

class Demo extends Validate
{

    /**
     * @OA\Schema(
     *      schema="post",
     *      type="object",
     *      @OA\Property(
     *          property="name",
     *          description="姓名",
     *          type="string",
     *          example="大黄"
     *      ),
     *      @OA\Property(
     *          property="age",
     *          description="年龄",
     *          type="integer",
     *          format="int32",
     *          example="2"
     *      ),
     *      @OA\Property(
     *          property="tags",
     *          description="特点",
     *          type="array",
     *          example={"活泼","好动"},
     *          @OA\Items(
     *              type="string",
     *          ),
     *      ),
     *      required={"name"},
     * )
     */

    /**
     * @OA\Schema(
     *      schema="FileUpload",
     *      type="object",
     *      @OA\Property(
     *          property="name",
     *          description="姓名",
     *          type="string",
     *          example="大黄"
     *      ),
     *      @OA\Property(
     *          property="file",
     *          description="文件",
     *          type="string",
     *          format="binary",
     *      ),
     *      required={"file"},
     * )
     */

    /**
     * @OA\Schema(
     *      schema="multiFileUpload",
     *      type="object",
     *      @OA\Property(
     *          property="name",
     *          description="姓名",
     *          type="string",
     *          example="大黄"
     *      ),
     *      @OA\Property(
     *          property="head",
     *          description="头像",
     *          type="string",
     *          format="binary",
     *      ),
     *      @OA\Property(
     *          property="card_photo_front",
     *          description="身份证正面",
     *          type="string",
     *          format="binary",
     *      ),
     *      @OA\Property(
     *          property="card_photo_back",
     *          description="身份证背面",
     *          type="string",
     *          format="binary",
     *      ),
     *      required={"name","head","card_photo_front","card_photo_back"},
     * )
     */
}
