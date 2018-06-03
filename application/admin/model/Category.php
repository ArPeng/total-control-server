<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/6/2
 * Time: 上午10:17
 */

namespace app\admin\model;


use extend\Functions;
use extend\STATUS_CODE;

class Category extends Base
{
    protected $pk = 'id';
    // 此处表名请务必设置为public
    // server/service/administrator/controller/Trash.php
    // 这个文件回收站方法会使用到
    public $table = 'category';

    /**
     * @purpose 根据ID删除一条数据
     * @param int $id
     * @return bool
     */
    public function del(int $id): array
    {
        // 检测当前分类是否有子分类,若有则不能删除
        $count = $this
            ->where('pid', $id)
            ->count();
        if ($count > 0) {
          return Functions::result(STATUS_CODE::DELETE_FAIL, '请先删除当前分类下的子分类');
        }
        // TODO 还需要检测当前分类下是否有商品,如果有也不能删除
        $result = (int) self::destroy($id);
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS, '删除成功');
        }
        return Functions::result(STATUS_CODE::DELETE_FAIL, '删除失败');
    }
    /**
     * @purpose 获取所有数据
     * @param $fields
     */
    public function getAll($fields)
    {
        return $this
            ->field($fields)
            ->select()
            ->toArray();
    }
    /**
     * @purpose 创建一个分类
     * @param array $data
     * @return bool
     */
    public function addOne (array $data): bool
    {

        if (empty($data['name'])) {
            exception(
                '缺少分类名!',
                STATUS_CODE::PARAMETER_ERROR

            );
        }
        if (empty($data['thumb'])) {
            exception(
                '缺少分类缩略图!',
                STATUS_CODE::PARAMETER_ERROR

            );
        }
        $_data           = [];
        $_data['name']   = $data['name'];
        $_data['thumb']  = $data['thumb'];
        $_data['pid']    = isset($data['pid']) ? $data['pid'] : 0 ;
        $_data['pinyin'] = Functions::pinyin($data['name']);
        return (bool) $this
            ->data($_data)
            ->save();
    }

    /**
     * @purpose 通过ID修改分类
     * @param array $data
     * @return bool
     */
    public function updateById (array $data) :bool
    {
        if (empty($data['id'])) {
            exception(
                '缺少ID!',
                STATUS_CODE::PARAMETER_ERROR

            );
        }
        if (empty($data['name'])) {
            exception(
                '缺少分类名!',
                STATUS_CODE::PARAMETER_ERROR

            );
        }
        if (empty($data['thumb'])) {
            exception(
                '缺少分类缩略图!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        $_data = [];
        $_data['id']     = $data['id'];
        $_data['name']   = $data['name'];
        $_data['thumb']  = $data['thumb'];
        $_data['pid']    = isset($data['pid']) ? $data['pid'] : 0 ;
        $_data['pinyin'] = Functions::pinyin($data['name']);
        return (bool) $this
            ->save($_data, ['id' => $_data['id']]);
    }

    /**
     * @purpose 通过ID获取单条分类信息
     * @param int $id
     * @param string $fields
     * @return array
     */
    public function infoById (
        int $id,
        string $fields = 'id,name,thumb,pinyin,pid,create_at,update_at'
    ): array
    {
        return
            $this
            ->where('id', $id)
            ->field($fields)
            ->find()
            ->toArray();
    }

    /**
     * @purpose 获取分类列表
     * @param int $page
     * @param int $size
     * @param string $order
     * @param array $where
     * @param string $fields
     * @return array
     */
    public function items (
        int $page = 1,
        int $size = 50,
        $order = 'create_at desc',
        array $where = [],
        string $fields = 'id,name,thumb,pinyin,pid,create_at,update_at'
    ): array
    {
        return
            $this
            ->where($where)
            ->order($order)
            ->field($fields)
            ->page($page,$size)
            ->select()
            ->toArray();
    }

    /**
     * @purpose 通过pid获取分类列表
     * @param int $pid
     * @param string $fields
     * @return array
     */
    public function itemsByPid (
        int $pid = 0,
        string $fields = 'id,name,thumb,pinyin,pid,create_at,update_At'
    )
    {
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
            ->select()
            ->toArray();

        $pidS = [];
        foreach ($childList as $item) {
            array_push($pidS, $item['pid']);
        }
        $pidS = array_count_values($pidS);

        foreach ($list as &$item) {
            $item['child_count'] =
                !empty($pidS[$item['id']]) ?
                    $pidS[$item['id']] : 0;
        }

        return $list;
    }
}