<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/28
 * Time: 下午5:31
 */

namespace app\admin\controller;


use think\App;
use think\Controller;
use think\facade\Request;

class Base extends Controller
{

    static public $token = '';
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        self::$token = Request::header('token');
    }
}