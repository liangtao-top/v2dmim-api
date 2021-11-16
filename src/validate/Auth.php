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
// | Date: 2021/11/15 15:26
// +----------------------------------------------------------------------

namespace V2dmIM\Http\validate;

use V2dmIM\Http\utils\abs\Validate;

class Auth extends Validate
{

    protected array $rule = [
        'terminal|终端类型' => 'require|in:1,2,3,4,5,6,7',// iOS 1, Android 2, Windows 3, OSX 4, WEB 5, 小程序 6，linux 7
        'uid|用户ID'      => 'require|max:64',// 最大长度 64 字符，必须保证一个 APP 内唯一
        'nickname|用户昵称' => 'require|max:64',// 最大长度 64 字符，可设置为空字符串
        'avatar|用户头像'   => 'max:64',// 最大长度 1024 字符，可设置为空字符串
        'gender|用户性别'   => 'in:0,1,2',// 0 表示未知，1 表示男，2 女表示女，其它会报参数错误
        'mobile|用户手机'   => 'max:32',// 最大长度 32 字符，非中国大陆手机号码需要填写国家代码(如美国：+1-xxxxxxxxxx)或地区代码(如香港：+852-xxxxxxxx)，可设置为空字符串
        'birth|用户生日'    => 'max:16',// 最大长度 16 字符，可设置为空字符串
        'email|用户邮箱'    => 'email|max:64',// 最大长度 64 字符，可设置为空字符串
        'extend|扩展字段'   => 'max:1024',// 用户名片扩展字段，最大长度 1024 字符，用户可自行扩展，建议封装成 JSON 字符串，也可以设置为空字符串
    ];

    /**
     * @OA\Schema(
     *     schema="Auth.userRegister",
     *     type="object",
     *     @OA\Property(
     *         property="terminal",
     *         description="终端类型 iOS 1, Android 2, Windows 3, OSX 4, WEB 5, 小程序 6，linux 7",
     *         type="integer",
     *         example=1,
     *     ),
     *     @OA\Property(
     *         property="uid",
     *         description="用户 ID，最大长度 64 字符，必须保证一个 APP 内唯一",
     *         type="string",
     *         example="d5645454517"
     *     ),
     *     @OA\Property(
     *         property="nickname",
     *         description="用户昵称，最大长度 64 字符，可设置为空字符串",
     *         type="string",
     *         example="秋雅",
     *     ),
     *     @OA\Property(
     *         property="avatar",
     *         description="用户头像，最大长度 1024 字节，可设置为空字符串",
     *         type="string",
     *         example="https://oss.com.cn/head",
     *     ),
     *     @OA\Property(
     *         property="gender",
     *         description="用户性别，0 表示未知，1 表示男，2 女表示女，其它会报参数错误",
     *         type="integer",
     *         enum={0,1,2},
     *         nullable=false,
     *         example=2,
     *     ),
     *     @OA\Property(
     *         property="mobile",
     *         description="用户 mobile，最大长度 32 字符，非中国大陆手机号码需要填写国家代码(如美国：+1-xxxxxxxxxx)或地区代码(如香港：+852-xxxxxxxx)，可设置为空字符串",
     *         type="string",
     *         example="17380052002",
     *     ),
     *     @OA\Property(
     *         property="birth",
     *         description="用户生日，最大长度 16 字符，可设置为空字符串",
     *         type="string",
     *         example="2012-09-16",
     *     ),
     *     @OA\Property(
     *         property="email",
     *         description="用户 email，最大长度 64 字符，可设置为空字符串",
     *         type="string",
     *         example="xxxx@qq.com",
     *     ),
     *     @OA\Property(
     *         property="extend",
     *         description="用户名片扩展字段，最大长度 1024 字符，用户可自行扩展，建议封装成 JSON 字符串，也可以设置为空字符串",
     *         type="string",
     *         example="",
     *     ),
     *     required={"terminal","uid","nickname"},
     * )
     */
    protected array $scene = [
        'userRegister' => ['terminal', 'uid', 'nickname', 'avatar', 'gender', 'mobile', 'birth', 'email', 'extend'],
    ];
}
