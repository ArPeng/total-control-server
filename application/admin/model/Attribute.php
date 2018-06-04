<?php
/**
 * @purpose 商品属性表
 * User: peter
 * Date: 2018/6/4
 * Time: 上午9:11
 */

namespace app\admin\model;


use extend\Functions;
use extend\STATUS_CODE;

class Attribute extends Base
{
    protected $pk = 'id';
    // 此处表名请务必设置为public
    // 这个文件回收站方法会使用到
    public $table = 'attribute';
    /**
     * @purpose 一对多关联属性值表
     * @return \think\model\relation\HasMany
     */
    public function attach () {
        return $this->hasMany('AttributeAttach','attribute_id','id')
            ->field('id,attribute_id,name');
//            ->bind('id,attribute_id,name');
    }

    /**
     * @purpose 获取属性列表
     * @param array $where
     * @param string $fields
     * @return array
     */
    public function items (
        array $where,
        string $fields = 'id,name,pinyin,create_at,update_at'): array
    {
        if (strpos($fields,'id') === false) {
            $fields .= ',id';
        }
        return $this
            ->with('attach')
            ->order('create_at desc')
            ->where($where)
            ->field($fields)
            ->select()
            ->toArray();
    }
    /**
     * @purpose 添加一个属性
     * @param string $name
     * @return bool
     */
    public function addOne (string $name) :bool
    {
        if (!$name) {
            exception(
                '参数错误!',
                STATUS_CODE::PARAMETER_ERROR);
        }
        $_data              = [];
        $_data['name']      = $name;
        $_data['pinyin']    = Functions::pinyin($name);
        return (bool) $this
            ->data($_data)
            ->save();
    }

    /**
     * @purpose 删除属性
     * @param int $id
     * @param int $uid
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
}