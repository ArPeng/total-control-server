<?php
/**
 * 后台接口路由
 */
// 通过密码登录
Route::post('sign.by_password', 'admin/Sign/signByPassword');
// 检测token以及权限
Route::post('sign.verification', 'admin/Sign/verification');
// 清除Token
Route::post('sign.clear_token', 'admin/Sign/clearToken');
/*********************管理员相关**********************/
// 创建管理员
Route::post('user.create', 'admin/User/create');
// 获取管理员列表
Route::get('user.list', 'admin/User/items');
// 获取管理员信息
Route::get('user.info', 'admin/User/info');
// 更新管理员
Route::post('user.update', 'admin/User/update');
// 删除管理员
Route::post('user.delete', 'admin/User/delete');
// 禁用/解禁管理员
Route::post('user.is_disable', 'admin/User/isDisable');
// 管理员授权
Route::post('user.authorization', 'admin/User/authorization');
/*************************权限相关***************************/
// 创建权限
Route::post('rule.create', 'admin/Rule/create');
// 更新权限
Route::post('rule.update', 'admin/Rule/update');
// 删除权限
Route::post('rule.delete', 'admin/Rule/delete');
// 根据Pid获取权限
Route::get('rule.get_list_by_pid', 'admin/Rule/getListByPid');
// 获取无限极格式的数据
Route::get('rule.infinite', 'admin/Rule/infinite');
// 通过ID获取单条权限信息
Route::get('rule.get_rule_info_by_id', 'admin/Rule/getRuleInfoById');
// 获取控制面板菜单
Route::get('rule.dashboard', 'admin/Rule/dashboard');
// 获取侧边栏菜单
Route::get('rule.menu', 'admin/Rule/menu');
// 获取指定权限下的所有子权限
Route::get('rule.identification', 'admin/Rule/identification');
/****************************管理组相关********************/
// 新增管理组
Route::post('group.create', 'admin/Group/create');
// 更新管理组
Route::post('group.update', 'admin/Group/update');
// 删除管理组
Route::post('group.delete', 'admin/Group/delete');
// 通过ID获取单条管理组
Route::get('group.get_group_info_by_id', 'admin/Group/getGroupInfoById');
// 获取管理组列表
Route::get('group.get_list', 'admin/Group/getList');
// 给用户组授权
Route::post('group.authorization', 'admin/Group/authorization');
// 获取所有用户组
Route::get('group.all', 'admin/Group/all');
/**************************配置相关********************/
// 获取权限白名单
Route::get('configure.rule_white_list', 'admin/Configure/getRuleWhiteList');
// 设置权限白名单
Route::get('configure.set_rule_white_list', 'admin/Configure/setRuleWhiteList');