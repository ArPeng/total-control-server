<?php
/**
 * @purpose 模型基础类
 */
namespace app\admin\model;

use think\Model;

abstract class Base extends Model
{
    protected $pk           = 'id';
    protected $createTime   = 'create_at';
    protected $updateTime   = 'update_at';
}