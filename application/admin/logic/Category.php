<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/6/2
 * Time: 上午10:50
 */

namespace app\admin\logic;


use extend\Functions;
use extend\STATUS_CODE;

class Category extends Base
{
    /**
     * @purpose 创建分类
     * @param array $data
     * @return array
     */
    public static function create (array $data) :array
    {
        $model = new \app\admin\model\Category();
        if ($model->addOne($data)) {
            return Functions::result();
        }
        return Functions::result(
            STATUS_CODE::CREATE_FAIL,
            '创建失败!'
        );

    }

    /**
     * @purpose 分类列表
     * @param int $pid
     * @return array
     */
    public static function items (int $pid): array
    {
        $model = new \app\admin\model\Category();

        $result = $model->itemsByPid(
            $pid,
            'id,name,thumb');
        return Functions::result(STATUS_CODE::SUCCESS, $result);
    }
    /**
     * @purpose 获取无限极数据结构
     * @return array
     */
    public static function infinite(): array
    {
        // TODO: Implement infinite() method.
        $model  = new \app\admin\model\Category();
        $data   = $model->getAll('id,pid,name');
        $_data = [];
        foreach ($data as $item) {
            $_data[$item['id']]['id']   = $item['id'];
            $_data[$item['id']]['pid']  = $item['pid'];
            $_data[$item['id']]['name'] = $item['name'];
        }
        $data = Functions::generate_tree($_data, 'children');
        return Functions::result(STATUS_CODE::SUCCESS,$data);
    }

    /**
     * @purpose 删除分类
     * @param int $id
     * @return array
     */
    public static function delete (int $id, int $uid):array
    {
        $model = new \app\admin\model\Category();

        if (self::trash($model, ['id' => $id], $uid)) {
            return $model->del($id);
        }
    }

    /**
     * @purpose 通过ID修改数据
     * @param array $data
     * @return array
     */
    public static function updateById (array $data): array
    {
        $model = new \app\admin\model\Category();
        if ($model->updateById($data)) {
            return Functions::result(STATUS_CODE::SUCCESS, '修改成功');
        }
        return Functions::result(STATUS_CODE::UPDATE_FAIL, '修改失败');
    }

    /**
     * @purpose 通过ID获取单条信息
     * @param int $id
     * @return array
     */
    public static function infoById (int $id): array
    {
        $model = new \app\admin\model\Category();
        $result =  $model->infoById($id, 'id,name,thumb,pid');
        return Functions::result(STATUS_CODE::SUCCESS, $result);
    }
}