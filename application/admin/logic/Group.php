<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/29
 * Time: 上午10:52
 */

namespace app\admin\logic;


use extend\Functions;
use extend\STATUS_CODE;

class Group extends Base
{
    /**
     * @purpose 创建管理组
     * @param array $data
     * @return array
     */
    public static function create(array $data): array
    {
        // TODO: Implement create() method.
        $model = new \app\model\Group();
        if ((bool) $model->addOne($data)) {
            return Functions::result(STATUS_CODE::SUCCESS, '创建成功');
        }
        return Functions::result(STATUS_CODE::FAIL, '创建失败');
    }

    /**
     * @purpose 修改管理组
     * @param array $data
     * @return array
     */
    public static function update(array $data): array
    {
        // TODO: Implement update() method.
        $model  = new \app\model\Group();
        $result = $model->updateById($data);
        if ((bool) $result) {
            return Functions::result(STATUS_CODE::SUCCESS, '修改成功');
        }
        return Functions::result(STATUS_CODE::FAIL, '修改失败');
    }

    /**
     * @purpose 通过ID删除管理组
     * @param string $id 可批量删除 ID为: 1,2,3,4,5
     * @param int $uid
     * @return array
     */
    public static function delete(string $id, int $uid): array
    {
        // TODO: Implement delete() method.
        $model  = new \app\model\Group();
        $result = false;
        if (self::trash($model, ['id' => $id], $uid)){
            $result = (bool) $model->deleteById($id);
        }
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS, '删除成功');
        }
        return Functions::result(STATUS_CODE::FAIL, '删除失败');
    }

    /**
     * @purpose 通过ID获取单条管理组信息
     * @param int $id
     * @param string $fields
     * @return array
     */
    public static function getGroupInfoById(int $id, string $fields = 'id,name,rules,descriptions,create_at,update_at')
    {
        // TODO: Implement getGroupInfoById() method.
        $model  = new \app\model\Group();
        $result = $model->getOneById($id,$fields);
        return Functions::result(STATUS_CODE::SUCCESS, $result);
    }

    /**
     * @purpose 获取管理组列表
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function getList(
        int $page,
        int $pageSize,
        array $where    = [],
        string $order   = '',
        $fields         = 'id,name,rules,descriptions,create_at,update_at'
    ): array
    {
        // TODO: Implement getList() method.
        $model              = new \app\model\Group();
        $result             = [];
        $result['list']     = $model->getItem($page, $pageSize, $where, $order, $fields);
        $result['total']    = $model->total($where);
        return Functions::result(STATUS_CODE::SUCCESS, $result);
    }

    /**
     * @purpose 给用户组授权
     * @param int $id
     * @param string $rules
     * @return array
     */
    public static function updateRulesById(int $id, string $rules): array
    {
        // TODO: Implement updateRulesById() method.
        $model  = new \app\model\Group();
        $result = (bool) $model->updateRulesById($id, $rules);
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS, '授权成功');
        }
        return Functions::result(STATUS_CODE::FAIL, '授权失败');
    }

    /**
     * @purpose 获取所有用户组
     * @param string $fields
     * @return array
     */
    public static function allGroup(string $fields = 'id,name'): array
    {
        // TODO: Implement allGroup() method.
        $model  = new \app\model\Group();
        $result = $model->allGroup($fields);
        return Functions::result(STATUS_CODE::SUCCESS, $result);
    }

}