<?php
/**
 * @Purpose: 回收站数据模型
 * @Author Peter
 * @Email yangchenpeng@qq.com
 * @Date   2017/9/17 17:24
 */

namespace app\model;

class RecycleBin extends Base
{
    protected $pk = 'id';
    // 此处表名请务必设置为public
    public $table = 'recycle_bin';

}