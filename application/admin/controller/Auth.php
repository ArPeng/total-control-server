<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/28
 * Time: 下午5:31
 */

namespace app\admin\controller;


use app\admin\logic\Administrator;
use extend\STATUS_CODE;
use think\App;

class Auth extends Base
{

    static public $user_info = [];
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        self::authToken();
    }

    /**
     * 验证登录token
     */
    private function authToken() {
        if (!self::$token || self::$token === 'undefined') {
            exception(
                '非法请求!',
                STATUS_CODE::TOKEN_NOT_FOUND);
        }
        self::$user_info = Administrator::userInfoByToken(self::$token);
        self::$user_info = self::$user_info['data'];
        if (empty(self::$user_info)) {
            exception(
                '登录令牌已过期',
                STATUS_CODE::EXPIRED_TOKEN);
        }
        return true;
    }
}