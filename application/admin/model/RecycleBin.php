<?php
/**
 * @Purpose: 回收站数据模型
 * @Author Peter
 * @Email yangchenpeng@qq.com
 * @Date   2017/9/17 17:24
 */

namespace app\admin\model;
use extend\STATUS_CODE;

class RecycleBin extends Base
{
    protected $pk = 'id';
    // 此处表名请务必设置为public
    // server/service/administrator/controller/Trash.php
    // 这个文件回收站方法会使用到
    public $table = 'recycle_bin';

}