<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/6/3
 * Time: 下午1:39
 */

namespace app\admin\controller;


use think\Request;

class Category extends Auth
{
    /**
     * @purpose 创建分类
     * @param Request $request
     * @return array
     */
    public function create (Request $request)
    {
        $data = $request->post();
        return \app\admin\logic\Category::create($data);
    }

    /**
     * @purpose 获取分类列表
     * @return array
     */
    public function items (Request $request) {
        $pid = $request->get('pid', 0);
        return \app\admin\logic\Category::items($pid);
    }

    /**
     * @purpose 获取无限极分类
     * @return array
     */
    public function infinite ()
    {
        return \app\admin\logic\Category::infinite();
    }

    /**
     * @purpose 删除分类
     * @param Request $request
     * @return array
     */
    public function delete (Request $request)
    {
        $id = $request->post('id', 0);
        return \app\admin\logic\Category::delete($id, self::$user_info['uid']);
    }

    /**
     * @purpose 根据ID修改数据
     * @param Request $request
     * @return array
     */
    public function updateById (Request $request)
    {
        $data = $request->post();
        return \app\admin\logic\Category::updateById($data);
    }

    /**
     * @purpose 通过ID获取单条数据
     * @param Request $request
     * @return array
     */
    public function infoById (Request $request)
    {
        $id = $request->get('id');
        return \app\admin\logic\Category::infoById($id);
    }
}