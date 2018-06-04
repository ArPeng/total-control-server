<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/6/4
 * Time: 上午9:59
 */

namespace app\admin\logic;


use app\admin\model\AttributeAttach;
use extend\Functions;
use extend\STATUS_CODE;

class Attribute extends Base
{
    /**
     * @purpose 获取属性列表
     * @param array $where
     * @return array
     */
    public static function items (array $where = []):array
    {
        $model = new \app\admin\model\Attribute();
        $fields = 'id,name';
        $result = $model->items($where, $fields);
        return Functions::result(STATUS_CODE::SUCCESS, $result);
    }
    /**
     * @purpose 创建属性
     * @param string $name
     * @return array
     */
    public static function create (string $name): array
    {
        $model = new \app\admin\model\Attribute();
        if ($model->addOne($name)) {
            return Functions::result(STATUS_CODE::SUCCESS);
        }
        return Functions::result(STATUS_CODE::CREATE_FAIL, '创建失败!');
    }

    /**
     * @purpose 删除属性
     * @param int $id
     * @param int $uid
     * @return array
     */
    public static function delete (int $id, int $uid): array
    {
        if (!$id || !$uid) {
            exception(
                '参数错误!',
                STATUS_CODE::PARAMETER_ERROR);
        }
        // TODO 还需检测当前属性值是否有关联的商品,如果有则不能删除
        $attach = new AttributeAttach();
        if ($attach->total(['attribute_id' => $id]) > 0) {
            return Functions::result(
                STATUS_CODE::FAIL,
                '请先删除当前属性下的所有属性值!');
        }

        $model  = new \app\admin\model\Attribute();
        if ($model->del($id) && self::trash($model, ['id' => $id], $uid)) {
            return Functions::result(STATUS_CODE::SUCCESS);
        }
        return Functions::result(
            STATUS_CODE::DELETE_FAIL,
            '删除失败!');
    }

    /**
     * @purpose 添加属性值
     * @param string $name
     * @param int $attribute_id
     * @return array
     */
    public static function createAttach (string $name, int $attribute_id): array
    {
        $model = new AttributeAttach();
        if ($model->addOne($name, $attribute_id)) {
            return Functions::result(STATUS_CODE::SUCCESS);
        }
        return Functions::result(
            STATUS_CODE::CREATE_FAIL,
            '添加失败!'
        );
    }

    /**
     * @purpose 删除属性值
     * @param int $id
     * @param int $uid
     * @return array
     */
    public static function deleteAttach (int $id, int $uid):array
    {
        if (!$uid) {
            exception(
                '参数错误!',
                STATUS_CODE::PARAMETER_ERROR);
        }
        $model = new AttributeAttach();
        if (
            self::trash($model, ['id' => $id], $uid) &&
            $model->del($id)
        ) {
            return Functions::result(STATUS_CODE::SUCCESS);
        }
        return Functions::result(STATUS_CODE::DELETE_FAIL, '删除失败');
    }
}