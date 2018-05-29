<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/28
 * Time: 下午5:40
 */

namespace app\admin\logic;


use app\admin\model\Authorization;
use extend\Functions;
use extend\STATUS_CODE;

class Administrator extends Base
{
    /**
     * @purpose 通过Token获取管理员信息
     * @param string $token
     * @param string $fields
     * @return array
     */
    public static function userInfoByToken (string $token, $fields = 'uid,uuid,name,mobile,email,status'): array {
        $model = new \app\admin\model\Administrator();
        $result = $model->getUserInfoByToken($token, $fields);
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS, $result);
        }
        return Functions::result(STATUS_CODE::DATA_NOT_FIND);
    }
    /**
     * @purpose 创建一个用户
     * @param $data
     * @return int
     */
    public static function createUser(array $data): array
    {

        if (empty($data)) {
            exception(
                '参数不能为空！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (isset($data['mobile']) && !Functions::check_phone_number($data['mobile'])) {
            exception(
                '手机号码格式错误',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (isset($data['email']) && !Functions::check_email($data['email'])) {
            exception(
                '邮箱格式错误！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (empty($data['mobile']) && empty($data['email'])) {
            exception(
                '手机号码与密码请至少填写一个！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (empty($data['password'])) {
            exception(
                '密码参数不能为空！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (!preg_match('/^[a-zA-Z\d_]{8,}$/', $data['password'])) {
            exception(
                '密码格式错误！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }

        /**
         * 对密码进行加密
         */
        $password = Functions::password(strtolower(trim($data['password'])));
        $_data['mobile'] = isset($data['mobile']) ? $data['mobile'] : '';
        $_data['email'] = isset($data['email']) ? $data['email'] : '';
        $_data['name'] = $data['name'];
        $_data = array_merge($_data, $password);

        // 生成uuid
        $uuid = Functions::getUUID();
        RE_UUID:
        $uuid = Functions::getUUID();

        $model = new \app\admin\model\Administrator();
        // 检测uuid是否存在
        $count = $model
            ->where(
                'uuid',
                $uuid
            )->count();
        if ($count > 0) {
            goto RE_UUID;
        }
        $_data['uuid'] = $uuid;
        // 检测邮箱是否存在
        if ($_data['email']) {
            $count = $model
                ->where(
                    'email',
                    $_data['email']
                )->count();
            if ($count > 0) {
                exception(
                    '邮箱已存在！',
                    STATUS_CODE::PARAMETER_ERROR
                );
            }

        }
        // TODO 需要检测手机号码或者邮箱是否存在
        if ($_data['mobile']) {
            $count = $model
                ->where(
                    'mobile',
                    $_data['mobile']
                )->count();
            if ($count > 0) {
                exception(
                    '手机号码已存在!',
                    STATUS_CODE::PARAMETER_ERROR
                );
            }

        }
        $result = $model
            ->data($_data)
            ->save();

        if (!$result) {
            return Functions::result(STATUS_CODE::PARAMETER_ERROR,[], '创建失败');
        }
        return Functions::result(STATUS_CODE::SUCCESS,['uuid' => $model->uuid], '创建成功');
    }

    /**
     * @purpose 获取管理员列表
     * @param int $page
     * @param int $num
     * @return array
     */
    public static function item(int $page, int $num): array
    {
        // TODO: Implement item() method.
        $fields = 'uuid,mobile,email,name,avatar,status';
        $where = [];
        $model = new \app\admin\model\Administrator();
        $total = $model
            ->total($where);
        $result = $model
            ->getItem(
                (int)$page,
                (int)$num,
                $where,
                'create_at desc',
                $fields);
        return Functions::result(
            STATUS_CODE::SUCCESS,
            [
                'list' => $result,
                'total' => $total
            ]
        );
    }

    /**
     * @purpose 通过uuid或请用户信息
     * @param string $uuid
     * @return array
     */
    public static function userInfoByUUID(string $uuid): array
    {
        // TODO: Implement userInfo() method.
        $model = new \app\admin\model\Administrator();
        $fields = 'name,mobile,email,status';
        $result = $model
            ->getUserInfoByUUID($uuid, $fields);
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS, $result);
        }
        return Functions::result(STATUS_CODE::DATA_NOT_FIND, [], '没有找到数据!');
    }

    /**
     * @purpose 修改管理员 todo 修改逻辑验证邮箱和手机号码唯一性未做
     * @param string $uuid
     * @param array $data
     * @return array
     */
    public static function update(string $uuid, array $data): array
    {
        // TODO: Implement update() method.
        if (empty($uuid)) {
            exception(
                '缺少参数[UUID]！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (empty($data)) {
            exception(
                '参数不能为空！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (isset($data['mobile']) && !Functions::check_phone_number($data['mobile'])) {
            exception(
                '手机号码格式错误',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (isset($data['email']) && !Functions::check_email($data['email'])) {
            exception(
                '邮箱格式错误！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (empty($data['mobile']) && empty($data['email'])) {
            exception(
                '手机号码与密码请至少填写一个！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (!empty($data['password']) && !preg_match('/^[a-zA-Z\d_]{8,}$/', $data['password'])) {
            exception(
                '密码格式错误！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }

        $model = new \app\admin\model\Administrator();
        if ($data['mobile']) {
            $count = $model
                ->where(
                    'mobile',
                    $data['mobile']
                )->where('uuid', '<>', $uuid)
                ->count();
            if ($count > 0) {
                exception(
                    '手机号码已存在!',
                    STATUS_CODE::PARAMETER_ERROR
                );
            }

        }
        // 检测邮箱是否存在
        if ($data['email']) {
            $count = $model
                ->where(
                    'email',
                    $data['email']
                )->where('uuid', '<>', $uuid)
                ->count();
            if ($count > 0) {
                exception(
                    '邮箱已存在！',
                    STATUS_CODE::PARAMETER_ERROR
                );
            }

        }
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $password = Functions::password(strtolower(trim($data['password'])));
            unset($data['password']);
            $data = array_merge($data, $password);
        }

        $result = $model
            ->updateByUUID($uuid, $data);
        return Functions::result(STATUS_CODE::SUCCESS, $result);
    }

    /**
     * @purpose 删除管理员
     * @param string $uuid 管理员UUID
     * @param int $uid 当前管理员uid
     * @return array
     */
    public static function delete(string $uuid, int $uid): array
    {
        // TODO: Implement delete() method.
        if (empty($uuid)) {
            exception(
                '缺少参数[UUID]！',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        $model = new \app\admin\model\Administrator();
        if (self::trash($model, ['uuid' => $uuid], $uid)) {
            $result = $model
                ->where(['uuid' => $uuid])
                ->delete();
            if ($result) {
                return Functions::result();
            }
        }
        return Functions::result(STATUS_CODE::TO_TRASH_FAIL, '删除失败');
    }

    /**
     * @purpose 是否禁用管理员
     * @param string $uuid
     * @param int $type 1: 禁用, 2: 解禁用
     * @return array
     */
    public static function isDisable(string $uuid, int $type): array
    {
        // TODO: Implement isDisable() method.
        $model = new \app\admin\model\Administrator();
        $result = null;
        switch ($type) {
            case 1:
                $result = $model->enable($uuid);
                break;
            case 2:
                $result = $model->disable($uuid);
                break;
        }
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS, '操作成功');
        }
        return Functions::result(STATUS_CODE::FAIL,'操作失败!');
    }

    /**
     * @purpose 用户授权接口
     * @param array $data 必须包含uid
     * @return array
     */
    public static function authorization(array $data): array
    {
        // TODO: Implement authorization() method.
        $model = new Authorization();
        $result = $model->authorization($data);
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS, $result, '授权成功');
        }
        return Functions::result(STATUS_CODE::FAIL, '授权失败');
    }

}