<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/8/16
 * Time: 下午11:32
 */

namespace app\admin\logic;


use app\model\PhoneNumber;
use extend\Functions;
use extend\STATUS_CODE;

class Mobile
{
    /**
     * @purpose 获取公共库手机号码
     * @param array $where
     * @param int $page
     * @param int $size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function itemByOne (array $where = [], int $page = 1, int $size = 50): array
    {
    }
}