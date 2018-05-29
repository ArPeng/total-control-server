<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/29
 * Time: 上午9:23
 */

namespace app\admin\controller;


use app\admin\logic\Administrator;
use think\Request;

class User extends Auth
{
    /**
     * @purpose 创建管理员
     * @param Request $request
     */
    public function create (Request $request) {
        $data = $request->post();
        return Administrator::createUser($data);
    }

    /**
     * @purpose 获取管理员列表
     * @param Request $request
     */
    public function items (Request $request) {
        $page = $request->get('page', 1);
        $size = $request->get('num', 20);
        return Administrator::item($page, $size);
    }

    /**
     * @purpose 获取管理员信息
     * @param Request $request
     */
    public function info (Request $request) {
        $uuid = $request->get('uuid');
        return Administrator::userInfoByUUID($uuid);
    }

    /**
     * @purpose 更新管理员信息
     * @param Request $request
     */
    public function update (Request $request) {
        $uuid = $request->post('uuid');
        $data = $request->post('data');
        return Administrator::update($uuid, $data);
    }

    /**
     * @purpose 删除管理员
     * @param Request $request
     */
    public function delete (Request $request) {
        $uuid = $request->post('uuid');
        return Administrator::delete($uuid, self::$user_info['uid']);
    }

    /**
     * @purpose 禁用/解禁管理员
     * @param Request $request
     */
    public function isDisable (Request $request) {
        $uuid = $request->post('uuid');
        $type = $request->post('type');
        return Administrator::isDisable($uuid, $type);
    }

    /**
     * @purpose 管理员授权接口
     * @param Request $request
     */
    public function authorization (Request $request) {
        $data = $request->post();
        return Administrator::authorization($data);
    }
}