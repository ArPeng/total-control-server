<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/8/16
 * Time: 下午11:45
 */

namespace app\admin\controller;


use think\Request;

class Mobile extends Auth
{
    /**
     * @param Request $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function itemByOne (Request $request) {
        $page       = $request->get('page', 1);
        $size       = $request->get('size', 50);
        return \app\admin\logic\Mobile::itemByOne([], $page, $size);
    }
}