<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/8/19
 * Time: 下午9:46
 */

namespace app\api\controller;


use app\admin\controller\Base;
use app\api\logic\Mobile;
use think\Request;

class Index extends Base
{
    public function saveFilter (Request $request)
    {
        $data         = $request->post();
        return Mobile::saveFilter($data);
    }
    /**
     * @purpose 获取短信验证码
     * @param Request $requests
     * @return array
     */
    public function getMessage (Request $requests)
    {
        $mobile     = $requests->get('mobile', '');
        return Mobile::getMessage($mobile);
    }
    /**
     * @purpose 获取一个在线的手机号码
     * @return array
     */
    public function getOneOnline () {
        return Mobile::getOneOnline();
    }
    /**
     * @purpose 保存过滤数据
     * @param Request $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function save (Request $request)
    {
        $mobile     = $request->getContent();
        if (!$mobile) {
            $mobile = '';
        }
        return Mobile::saveMobile($mobile);
    }

    /**
     * @param Request $request
     * @return Base|array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _filter (Request $request)
    {
        $mobile     = $request->getContent();
        if (!$mobile) {
            $mobile = '';
        }
        return Mobile::filterMobile($mobile);
    }
}