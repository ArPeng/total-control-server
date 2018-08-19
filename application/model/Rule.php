<?php
/**
 * @Purpose: 权限表数据模型
 * @Author Peter
 * @Email yangchenpeng@qq.com
 * @Date   2017/9/17 17:25
 */

namespace app\model;


use extend\STATUS_CODE;

class Rule extends Base
{
    protected $pk = 'id';
    // 此处表名请务必设置为public
    public $table = 'rule';

    /**
     * @purpose 获取所有数据
     * @param $fields
     */
    public function getAll($fields)
    {
        return $this
            ->field($fields)
            ->select();
    }

    /**
     * @purpose 通过ID获取单条数据
     * @param int $id
     * @param string $fields
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getOneById(
        int $id,
        string $fields = 'id,pid,name,identification,icon_class,icon_family,type,address')
    {
        return $this
            ->where('id', $id)
            ->field($fields)
            ->find();
    }

    /**
     * @purpose 新增一条数据
     * @param $data
     * @return false|int
     */
    public function addOnce($data)
    {
        $_data = [];
        if (empty($data['name'])) {
            exception(
                '缺少权限名称!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (empty($data['identification'])) {
            exception(
                '缺少权限唯一标识!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (empty((int)$data['type']) ||
            !in_array((int)$data['type'], [1, 2, 3, 4])
        ) {
            exception(
                '缺少权限类型!',
                STATUS_CODE::PARAMETER_ERROR

            );
        }
        if ($this->total(['identification' => $data['identification']]) > 0) {
            exception(
                '唯一标识已存在!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        $_data['pid']               = empty($data['pid']) ? 0 : (int)$data['pid'];
        $_data['name']              = (string)$data['name'];
        $_data['identification']    = (string)$data['identification'];
        $_data['type']              = (int)$data['type'];
        $_data['icon_class']        = !empty($data['icon_class']) ? (string)$data['icon_class']  : '';
        $_data['icon_family']       = !empty($data['icon_family']) ? (string)$data['icon_family'] : '';

        return $this
            ->data($_data)
            ->save();
    }

    /**
     * @purpose 通过pid获取权限列表
     * @param int $pid
     * @param string $fields
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getListByPid(
        int $pid = 0,
        string $fields = 'id,pid,name,identification,icon_class,icon_family,type,address')
    {
//        return self::withCount('rules')
//            ->where('pid', $pid)
//            ->field($fields)
//            ->select(false);
        // 构造的SQL语句为
        // SELECT *,(SELECT COUNT(*) AS tp_count FROM `rule` WHERE  ( `pid` =rule.id ) LIMIT 1) AS `rules_count`,`id`,`pid`,`name`,`identification`,`icon_class`,`icon_family`,`type`,`address` FROM `rule` WHERE  `pid` = 0
        // 关联统计查询效率有问题,就是一个子查询,暂不考虑使用

        // 使用下面手动的方式计算是否有子数据, 只需要查询两次
        // TODO 待数据多了进行一下测试
        $fields = explode(',', $fields);
        if (!in_array('id', $fields)) {
            array_push($fields, 'id');
        }

        $list = $this
            ->where('pid', $pid)
            ->field($fields)
            ->select();
        // 获取ID集合
        $ids = [];
        foreach ($list as $item) {
            array_push($ids, $item->id);
        }
        $childList = $this
            ->where('pid', 'in', $ids)
            ->field('id,pid')
            ->select();

        $pidS = [];
        foreach ($childList as $item) {
            array_push($pidS, $item->pid);
        }
        $pidS = array_count_values($pidS);

        foreach ($list as &$item) {
            $item['child_count'] =
                !empty($pidS[$item['id']]) ?
                    $pidS[$item['id']] : 0;
        }

        return $list;
    }

    /**
     * @purpose 通过主键ID删除权限
     * @param string $id 支持批量删除 1,2,3,4
     * @return int
     */
    public function deleteById(string $id)
    {
        return self::destroy($id);
    }

    /**
     * @purpose 修改数据
     * @param array $data 需要修改的数据, 数据中必须包含主键 `id`
     * @return $this
     */
    public function updateById(array $data)
    {
        if (empty($data['id'])) {
            exception(
                '缺少权限ID!',
                STATUS_CODE::PARAMETER_ERROR

            );
        }
        if (empty($data['name'])) {
            exception(
                '缺少权限名称!',
                STATUS_CODE::PARAMETER_ERROR

            );
        }
        if (empty($data['identification'])) {
            exception(
                '缺少权限唯一标识!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (empty((int)$data['type']) ||
            !in_array((int)$data['type'], [1, 2, 3, 4])
        ) {
            exception(
                '缺少权限类型!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        $total = $this->total([
            ['identification', '=', $data['identification']],
            ['id', '<>', $data['id']]
        ]);
        if ($total > 0) {
            exception(
                '唯一标识已存在!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        return self::update($data);
    }

    /**
     * @purpose 通过ID获取一级菜单
     * @param string $ids
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function firstMenu(string $ids)
    {
        $fields = 'id,name,identification,icon_class,icon_family,address';
        return $this
            ->whereIn('id', $ids)
            ->field($fields)
            ->where('type', 1)
            ->where('pid', 0)
            ->order('sort asc')
            ->select();
    }

    /**
     * @purpose 通过ID获取侧边栏菜单
     * @param string $ids
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function sidebarMenu(string $ids)
    {
        $fields = 'id,pid,name,identification,icon_class,icon_family,address';
        return $this
            ->whereIn('id', $ids)
            ->field($fields)
            ->where('type', 1)
//            ->where('pid', '>', 0)
            ->order('sort asc')
            ->select();
    }
    /**
     * @purpose 通过identification获取ID
     * @param string $identification
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function identificationToId(string $identification)
    {
        return $this
            ->where('identification', $identification)
            ->field('id')
            ->find();
    }

    /**
     * @purpose 通过ID获取权限
     * @param string $ids
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function rules (
        string $ids,
        $fields = 'id,pid,name,identification,icon_class,icon_family,address')
    {
        return $this
            ->whereIn('id', $ids)
            ->field($fields)
//            ->where('type', 1)
//            ->where('pid', '>', 0)
            ->order('sort asc')
            ->select();
    }
    /**
     * @purpose 根据条件获取数据条数
     * @param array $where
     * @return int
     */
    private function total(array $where = [])
    {
        return $this
            ->where($where)
            ->count();
    }
}