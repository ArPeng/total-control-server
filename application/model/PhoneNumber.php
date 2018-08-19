<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/8/16
 * Time: 下午11:04
 */

namespace app\model;


class PhoneNumber extends Base
{
    protected $pk = 'id';
    // 此处表名请务必设置为public
    public $table = 'phone_number';
}