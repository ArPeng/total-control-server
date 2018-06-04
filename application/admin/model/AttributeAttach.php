<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/6/4
 * Time: 上午9:11
 */

namespace app\admin\model;


use extend\Functions;
use extend\STATUS_CODE;

class AttributeAttach extends Base
{
    protected $pk = 'id';
    // 此处表名请务必设置为public
    // 这个文件回收站方法会使用到
    public $table = 'attribute_attach';
    /**
     * @purpose 添加一个属性
     * @param string $name
     * @return bool
     */
    public function addOne (string $name, int $attribute_id)
    {
        if (!$name || !$attribute_id) {
            exception(
                '参数错误!',
                STATUS_CODE::PARAMETER_ERROR);
        }
        $_data                      = [];
        $_data['name']              = $name;
        $_data['attribute_id']      = $attribute_id;
        $_data['pinyin']            = Functions::pinyin($name);
        return (bool) $this
            ->data($_data)
            ->save();
    }

    /**
     * @purpose 删除属性
     * @param int $id
     * @return bool
     */
    public function del (int $id) : bool
    {
        if (!$id) {
            exception(
                '参数错误!',
                STATUS_CODE::PARAMETER_ERROR);
        }
        return (bool) self::destroy($id);
    }

    /**
     * @purpose 根据条件获取数据数量
     * @param array $where
     * @return int
     */
    public function total (array $where): int
    {
        return (int) $this
            ->where($where)
            ->count();
    }
}