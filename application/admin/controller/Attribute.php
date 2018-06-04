<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/6/4
 * Time: 上午10:30
 */

namespace app\admin\controller;


use think\Request;

class Attribute extends Auth
{
    /**
     * @purpose 获取属性列表
     * @return array
     */
    public function items ()
    {
        return \app\admin\logic\Attribute::items();
    }

    /**
     * @purpose 创建属性
     * @param Request $request
     * @return array
     */
    public function create (Request $request)
    {
        $name = $request->post('name');
        return \app\admin\logic\Attribute::create($name);
    }

    /**
     * @purpose 删除属性
     * @param Request $request
     * @return array
     */
    public function delete (Request $request)
    {
        $id = $request->post('id');
        return \app\admin\logic\Attribute::delete($id, self::$user_info['uid']);
    }

    /**
     * @purpose 添加属性值
     * @param Request $request
     * @return array
     */
    public function createAttach (Request $request)
    {
        $attribute_id   = $request->post('attribute_id');
        $name           = $request->post('name');
        return \app\admin\logic\Attribute::createAttach($name, $attribute_id);
    }

    /**
     * @purpose 删除属性值
     * @param Request $request
     * @return array
     */
    public function deleteAttach (Request $request)
    {
        $id = $request->post('id');
        return \app\admin\logic\Attribute::deleteAttach($id, self::$user_info['uid']);
    }
}