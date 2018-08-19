<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/29
 * Time: 上午10:31
 */

namespace app\admin\controller;


use think\Request;

class Rule extends Auth
{
    /**
     * @purpose 创建权限
     * @param Request $request
     */
    public function create (Request $request)
    {
        $data = $request->post();
        return \app\admin\logic\Rule::create($data);
    }

    /**
     * @purpose 更新权限
     * @param Request $request
     */
    public function update (Request $request)
    {
        $data = $request->post();
        return \app\admin\logic\Rule::update($data);
    }

    /**
     * @purpose 删除权限
     * @param Request $request
     */
    public function delete (Request $request)
    {
        $id = $request->post('id');
        return \app\admin\logic\Rule::delete($id, self::$user_info['uid']);
    }

    /**
     * @purpose 通过pid获取权限
     * @param Request $request
     */
    public function getListByPid (Request $request)
    {
        $pid = $request->get('pid');
        return \app\admin\logic\Rule::getListByPid($pid);
    }

    /**
     * @purpose 获取无限极数据结构
     * @param Request $request
     */
    public function infinite (Request $request)
    {
        return \app\admin\logic\Rule::infinite();
    }

    /**
     * @purpose 通过ID获取单条权限数据
     * @param Request $request
     */
    public function getRuleInfoById (Request $request)
    {
        $id = $request->get('id');
        $fields = 'id,pid,name,identification,icon_class,icon_family,type,address';
        return \app\admin\logic\Rule::getRuleInfoById($id,$fields);
    }

    /**
     * @purpose 获取dashboard 菜单(一级菜单)
     * @param Request $request
     */
    public function dashboard ()
    {
        return \app\admin\logic\Rule::dashboard(self::$user_info['uid']);
    }

    /**
     * @purpose 获取侧边栏菜单
     * @param Request $request
     */
    public function menu (Request $request) {
        $identification = $request->get('identification');
        return \app\admin\logic\Rule::menu(self::$user_info['uid'], $identification);
    }

    /**
     * @purpose 获取按钮以及展示权限
     * @param Request $request
     */
    public function identification (Request $request) {
        $identification = $request->get('identification');
        return \app\admin\logic\Rule::identification(self::$user_info['uid'], $identification);
    }
}