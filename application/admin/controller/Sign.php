<?php
namespace app\admin\controller;

use app\admin\model\Administrator;
use extend\STATUS_CODE;
use think\Request;

class Sign
{

    /**
     * @purpose 通过邮箱或手机号码+密码登录
     * @param string $sign 邮箱或手机号码
     * @param string $password 密码
     * @return array
     */
    public function signByPassword(Request $request): array
    {
        $sign = $request->post('sign');
        $password = $request->post('password');
        return \app\admin\logic\Sign::signByPassword($sign, $password);
    }

    /**
     * @purpose 通过uid获取当前用户所有的权限ID
     * @param int $uid
     * @return array
     */
    public function verification(Request $request): array {
        $token = $request->post('token');
        $identification = $request->post('identification');
        return \app\admin\logic\Sign::verification($token, $identification);
    }

    /**
     * @purpose 清除Token
     * @param Request $request
     * @return array
     */
    public function clearToken (Request $request): array {
        $token = $request->post('token');
        return \app\admin\logic\Sign::clearToken($token);
    }
}
