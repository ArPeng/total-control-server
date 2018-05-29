<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/29
 * Time: 上午10:32
 */

namespace app\admin\logic;


use extend\Functions;
use extend\STATUS_CODE;

class Rule extends Base
{
    /**
     * @purpose 添加权限
     * @param array $data
     * @return array
     */
    public static function create(array $data): array
    {
        // TODO: Implement create() method.
        $model = new \app\admin\model\Rule();
        $result = $model->addOnce($data);
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS,'添加成功');
        }
        return Functions::result(STATUS_CODE::CREATE_FAIL,'数据创建失败');
    }

    /**
     * @purpose 更新权限
     * @param array $data 需要修改的数据, 数据中必须包含主键 `id`
     * @return array
     */
    public static function update(array $data): array
    {
        // TODO: Implement update() method.
        $model = new \app\admin\model\Rule();
        $result = $model->updateById($data);
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS,'修改成功');
        }
        return Functions::result(STATUS_CODE::UPDATE_FAIL,'修改失败');
    }

    /**
     * @purpose 删除权限
     * @param string $id 支持批量删除 1,2,3,4
     * @param int $uid
     * @return array
     */
    public static function delete(string $id, int $uid): array
    {
        // TODO: Implement delete() method.
        $model = new \app\admin\model\Rule();
        if (self::trash($model, ['id' => $id], $uid)) {
            $result = $model->deleteById($id);
            if ($result) {
                return Functions::result(STATUS_CODE::SUCCESS,'删除成功');
            }
            return Functions::result(STATUS_CODE::UPDATE_FAIL,'删除失败');
        }
        return Functions::result(STATUS_CODE::TO_TRASH_FAIL,'删除失败');
    }

    /**
     * @purpose 通过pid获取权限
     * @param int $pid
     * @return array
     */
    public static function getListByPid(int $pid = 0): array
    {
        // TODO: Implement getListByPid() method.
        $model = new \app\admin\model\Rule();
        $result = $model->getListByPid((int)$pid);
        return Functions::result(STATUS_CODE::SUCCESS,$result);
    }

    /**
     * @purpose 通过ID获取单条权限数据
     * @param int $id
     * @param string $fields
     * @return array
     */
    public static function getRuleInfoById(int $id, string $fields = '*'): array
    {
        // TODO: Implement getRuleInfoById() method.
        $model = new \app\admin\model\Rule();
        $result = $model
            ->getOneById($id, $fields);
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS,$result);
        }
        return Functions::result(STATUS_CODE::DATA_NOT_FIND,'没有找到需要的数据');
    }

    /**
     * @purpose 获取无限极数据结构
     * @return array
     */
    public static function infinite(): array
    {
        // TODO: Implement infinite() method.
        $model = new \app\admin\model\Rule();
        $data = $model->getAll('id,pid,name,type');


        $_data = [];
        foreach ($data as $item) {
            $_data[$item['id']]['id'] = $item['id'];
            $_data[$item['id']]['pid'] = $item['pid'];
            $_data[$item['id']]['name'] = $item['name'];
            $_data[$item['id']]['type'] = $item['type'];
        }


        $data = Functions::generate_tree($_data, 'children');
        return Functions::result(STATUS_CODE::SUCCESS,$data);
    }
    /**
     * @purpose 用户获取权限内的dashboard菜单(一级菜单)
     * @param int $uid
     * @return array
     */
    public static  function dashboard(int $uid): array
    {
        // TODO: Implement dashboard() method.
        $ruleIds = self::getRulesByUid($uid);
        $ruleModel = new \app\admin\model\Rule();
        $menu = $ruleModel->firstMenu($ruleIds);
        // 刚写到这里,准备通过ID查询一级菜单
        return Functions::result(STATUS_CODE::SUCCESS, $menu);
    }

    /**
     * @purpose 通过uid获取当前用户所有的权限ID
     * @param int $uid
     * @return string
     */
    private static function getRulesByUid(int $uid): string
    {
        $userModel = new \app\admin\model\Administrator();
        $groupModel = new \app\admin\model\Group();
        // 获取管理员的管理组信息
        $groupInfo = $userModel->getGroup($uid);
        // 通过groupID获取rules
        $ruleIds = $groupInfo['rules'];
        if ($groupInfo['groups']) {
            $groupRules = $groupModel
                ->getRulesByIds($groupInfo['groups']);
            $ruleIds .= $ruleIds . ',' . $groupRules;
        }
        $ruleIds = trim($ruleIds, ',');
        return $ruleIds;
    }

    /**
     * @purpose 获取用户在dashboard菜单之下权限内的侧边栏菜单
     * @param int $uid
     * @param string $identification 前端路由name属性
     * @return array
     */
//    public static  function menu(int $uid, string $identification): array
//    {
//        // TODO: Implement menu() method.
//        $ruleIds = self::getRulesByUid($uid);
//        $ruleModel = new \app\admin\model\Rule();
////        $dashboardId = $ruleModel->identificationToId($identification);
//        $menu = $ruleModel->sidebarMenu($ruleIds)->toArray();
//        $menu = self::getSubs($menu);
//        $menu = Functions::generate_tree($menu);
//        return Functions::result(STATUS_CODE::SUCCESS, $menu);
//    }
    public static  function menu(int $uid, string $identification): array
    {
        // TODO: Implement menu() method.
        $ruleIds = self::getRulesByUid($uid);
        $ruleModel = new \app\admin\model\Rule();
        $dashboardId = $ruleModel->identificationToId($identification);
        $menu = $ruleModel->sidebarMenu($ruleIds)->toArray();
        $menu = self::getSubs($menu, $dashboardId['id']);
        $menu = Functions::generate_tree($menu);
        return Functions::result(STATUS_CODE::SUCCESS, $menu);
    }

    /**
     * @purpose 获取无限极分类指定父级的所有子级
     * @param $menu
     * @param int $pid
     * @param int $level
     * @return array
     */
    public static function getSubs($menu, $pid = 0, $level = 1)
    {
        $subs = [];
        $_subs = [];
        foreach ($menu as $item) {
            if ($item['pid'] == $pid) {
                $item['level'] = $level;
                $subs[] = $item;
                $subs = array_merge(
                    $subs,
                    self::getSubs(
                        $menu,
                        $item['id'],
                        $level + 1
                    )
                );
            }
        }
        foreach ($subs as $v) {
            $_subs[$v['id']] = $v;
        }
        return $_subs;
    }

    /**
     * @purpose 获取指定权限下的所有子权限
     * @param int $uid
     * @param string $identification
     * @return array
     */
    public static function identification(int $uid, string $identification): array
    {
        // TODO: Implement identification() method.
        $ruleIds = self::getRulesByUid($uid);
        $ruleModel = new \app\admin\model\Rule();
        $parent = $ruleModel->identificationToId($identification);
        $rules = $ruleModel->rules($ruleIds, 'id,pid,identification');
//        return $rules->toArray();
        $menu = self::getSubs($rules, $parent['id']);
        $permission = [];
        foreach ($menu as $v) {
            array_push($permission, $v['identification']);
        }
        return Functions::result(STATUS_CODE::SUCCESS, $permission);
    }

}