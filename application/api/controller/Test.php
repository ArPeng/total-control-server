<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/8/20
 * Time: 上午12:45
 */

namespace app\api\controller;


use app\admin\logic\Base;

class Test extends Base
{
    public function test () {
        $str = 'MSG&【腾讯科技】你正在登录微信，验证码692389。转发可能导致帐号被盗。如果这不是你本人操作，回复JZ可阻止该用户登录你的微信。';
        return strpos($str,'验证码');
        return $result;
    }
}