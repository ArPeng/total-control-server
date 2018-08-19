<?php
Route::get('test.test', 'api/Test/test');
// 保存筛选之后的手机号码
Route::post('save', 'api/Index/save');
// 第一次过滤手机号码
Route::post('filter', 'api/Index/_filter');
// 获取一个在线的手机号码
Route::get('online.one', 'api/Index/getOneOnline');
// 获取短信验证码
Route::get('mobile.message', 'api/Index/getMessage');
// 保存手机客户端返回的数据
Route::post('save.filter', 'api/Index/saveFilter');