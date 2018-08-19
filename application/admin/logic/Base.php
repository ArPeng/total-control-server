<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/29
 * Time: 上午9:27
 */

namespace app\admin\logic;


use app\model\RecycleBin;
use think\Model;

class Base
{

    /**
     * @purpose 删除数据时将数据添加到回收站
     * @param Model $model 数据模型
     * @param array $where 查询要删除的数据条件
     * @param int $uid 条件
     */
    public static function trash(Model $model, array $where, int $uid)
    {
        $trash = new RecycleBin();
        $data['from_table'] = $model->table;
        $content = $model
            ->where($where)
            ->find();
        $data['content'] = json_encode($content);
        $data['uid'] = $uid;
        $result = $trash
            ->data($data)
            ->save();
        return (bool) $result;
    }
}