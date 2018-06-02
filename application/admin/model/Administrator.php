<?php
/**
 * @Purpose: 管理员表数据模型
 * @Author Peter
 * @Email yangchenpeng@qq.com
 * @Date   2018/05/28 16:35
 */

namespace app\admin\model;
use extend\STATUS_CODE;

class Administrator extends Base
{
    protected $pk = 'uid';
    // 此处表名请务必设置为public
    // server/service/administrator/controller/Trash.php
    // 这个文件回收站方法会使用到
    public $table = 'administrator';

    /**
     * @purpose 关联授权表查询
     * @return \think\model\relation\HasOne
     */
    public function authorization () {
        return $this
            ->hasOne('Authorization', 'uid','uid')
            ->bind('groups,rules');
    }
    /**
     * @purpose 通过token获取用户信息
     * @param        $token
     * @param string $fields
     */
    public function getUserInfoByToken($token, $field = '*')
    {
        if (!$token) {
            exception(
                '令牌(token)不能为空',
                STATUS_CODE::PARAMETER_ERROR);
        }
        return $this
            ->where('token', $token)
            ->field($field)
            ->find();
    }

    /**
     * @purpose 通过uuid获取用户信息
     * @param        $uuid
     * @param string $fields
     */
    public function getUserInfoByUUID($uuid, $field = '*')
    {
//        if (!$token) {
//            exception(
//                '令牌(token)不能为空',
//                STATUS_CODE::PARAMETER_ERROR);
//        }
        return $this
            ->where('uuid', $uuid)
            ->field($field)
            ->find();
    }

    /**
     * @purpose 设置token过期时间
     * @param string $token
     * @param int $time
     */
    public function setTokenExpired(string $token, int $time)
    {
        return $this
            ->save(
                ['expiration_date_token' => $time],
                ['token' => $token]);
    }

    /**
     * @purpose 根据条件获取数据数量
     * @param array $where
     * @return int|string
     */
    public function total(array $where = [])
    {
        return (int) $this
            ->where($where)
            ->count();
    }

    /**
     * @purpose 获取管理员列表
     * @param int $page
     * @param int $nums
     * @param array $where
     * @param string $order
     * @param string $fields
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getItem(
        int $page       = 1,
        int $num        = 20,
        array $where    = [],
        $order          = 'create_at desc',
        $fields         = 'uid,uuid,mobile,email,password,encrypt,name,avatar,status,token,expiration_data_token,create_at,update_at'
    )
    {
        // 关联查询的查询字段里面必须有关联字段
        $fields = explode(',',$fields);
        if (!in_array('uid',$fields)) {
            array_push($fields, 'uid');
        }
        return $this
            ->with('authorization')
            ->field($fields)
            ->where($where)
            ->page($page, $num)
            ->order($order)
            ->select();
    }

    /**
     * @purpose 通过uuid修改管理员数据
     * @param string $uuid
     * @param array $data
     */
    public function updateByUUID(string $uuid, array $data)
    {
        return $this->save($data, ['uuid' => $uuid]);
    }

    /**
     * @purpose 禁用管理员
     * @param string $uuid
     * @return false|int
     */
    public function disable(string $uuid)
    {
        return $this
            ->save(['status' => 2], ['uuid' => $uuid]);
    }

    /**
     * @purpose 解禁管理员
     * @param string $uuid
     * @return false|int
     */
    public function enable(string $uuid)
    {
        return $this
            ->save(['status' => 1], ['uuid' => $uuid]);
    }

    /**
     * @purpose 通过UID获取group信息
     * @param int $uid
     */
    public function getGroup (int $uid) {
        return $this
            ->with('authorization')
            ->where('uid', $uid)
            ->field('uid')
            ->find();
    }
}