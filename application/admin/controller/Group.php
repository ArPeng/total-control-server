<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/29
 * Time: 上午10:46
 */

namespace app\admin\controller;


use think\Request;

class Group extends Auth
{
    /**
     * @purpose 创建管理组
     * @param Request $request
     */
    public function create (Request $request)
    {
        $data = $request->post();
        return \app\admin\logic\Group::create($data);
    }

    /**
     * @purpose 更新管理组
     * @param Request $request
     */
    public function update (Request $request)
    {
        $data = $request->post();
        return \app\admin\logic\Group::update($data);
    }

    /**
     * @purpose 删除管理组
     * @param Request $request
     */
    public function delete (Request $request)
    {
        $id = $request->post('id');
        return \app\admin\logic\Group::delete($id,self::$user_info['uid']);
    }

    /**
     * @purpose 通过ID获取单条管理组
     * @param Request $request
     */
    public function getGroupInfoById (Request $request)
    {
        $id     = $request->get('id');
        $fields = 'id,name,rules,descriptions,create_at,update_at';
        return \app\admin\logic\Group::getGroupInfoById($id, $fields);
    }

    /**
     * @purpose 获取管理组列表
     * @param Request $request
     */
    public function getList (Request $request)
    {
        $page = $request->get('page');
        $size = $request->get('size');
        return \app\admin\logic\Group::getList($page, $size);
    }

    /**
     * @purpose 给当前管理组授权
     * @param Request $request
     */
    public function authorization (Request $request)
    {
        $id     = $request->post('id');
        $rules  = $request->post('rules');
        return \app\admin\logic\Group::updateRulesById($id, $rules);
    }

    /**
     * @purpose 获取所有管理组
     * @param Request $request
     */
    public function all (Request $request)
    {
        return \app\admin\logic\Group::allGroup('id,name,rules');
    }
}