<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/29
 * Time: 上午11:20
 */

namespace app\admin\controller;


class Configure extends Auth
{
    /**
     * @purpose 获取权限白名单
     * @return array|mixed
     */
    public function getRuleWhiteList () {
        return \app\admin\logic\Configure::getConfigure('rule_white_list');
    }

    /**
     * @purpose 设置路由白名单
     * @param Request $request
     * @return array|mixed
     */
    public function setRuleWhiteList (Request $request) {
        $config = $request->post();
        return \app\admin\logic\Configure::setConfigure('rule_white_list', $config, '总后台路由白名单');
    }

}