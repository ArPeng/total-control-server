<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/28
 * Time: 下午4:36
 */

namespace app\admin\logic;


use app\model\Administrator;
use app\model\Group;
use app\model\Rule;
use app\model\Setting;
use extend\Functions;
use extend\STATUS_CODE;

class Sign
{
    /**
     * @purpose 通过邮箱或手机号码+密码登录
     * @param string $sign 邮箱或手机号码
     * @param string $password 密码
     * @return array
     */
    public static function signByPassword (string $sign, string $password):array {
        // TODO: Implement signByPassword() method.
        if (empty($sign)) {
            exception(
                '缺少邮箱或手机号码!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        if (empty($password)) {
            exception(
                '缺少密码!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        $sign = Functions::get_sign_type($sign);

        if ($sign['type'] === 'username') {
            exception(
                '缺少邮箱或手机号码!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }

        if (empty($sign)) {
            exception(
                '手机号码格式错误',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        $model = new Administrator();
        $user_info = $model
            ->where($sign['type'], $sign[$sign['type']])
            ->field('password,encrypt,uid,status,avatar,email,mobile,name')
            ->find();
        if (empty($user_info)) {
            exception(
                '管理员不存在!',
                STATUS_CODE::FAIL
            );
        }
        if ($user_info['status'] === 2) {
            exception(
                '你账号已被禁用,请联系管理员!',
                STATUS_CODE::ACCOUNT_DISABLED
            );
        }
        if ($user_info['password'] !==
            Functions::password($password, $user_info['encrypt'])) {
            exception(
                '密码错误!',
                STATUS_CODE::PARAMETER_ERROR
            );
        }
        $token = strtolower(Functions::getUUID());
        RE_TOKEN:
        $token = strtolower(functions::getUUID());

        $count = $model
            ->where('token', $token)
            ->count();
        if ($count > 0) {
            goto RE_TOKEN;
        }

        $result = $model
            ->save(
                [
                    'token' => $token,
                    'expiration_date_token' => time() + (3600 * 24 * 10),
                ],
                ['uid' => $user_info['uid']]
            );

        if ($result) {
            return Functions::result(
                STATUS_CODE::SUCCESS,
                [
                    'token' => $token,
                    'info'  => [
                        'avatar'    => $user_info['avatar'],
                        'email'     => $user_info['email'],
                        'mobile'    => $user_info['mobile'],
                        'name'      => $user_info['name'],
                        'status'    => $user_info['status'],
                    ]
                ]
            );
        }
        return Functions::result(STATUS_CODE::FAIL, '登录失败!');
    }
    /**
     * @purpose 检测token以及权限
     * @param string $token
     * @return array
     */
    public static function verification(string $token, string $identification): array
    {

        if (!$token) {
            exception('令牌(token)不能为空',
                STATUS_CODE::PARAMETER_ERROR);
        }
        $model  = new Administrator();
        $fields = 'uid,uuid,mobile,email,name,avatar,status,expiration_date_token';
        $result = $model->getUserInfoByToken(
            $token,
            $fields);
        if (!$result) {
            return Functions::result(
                STATUS_CODE::SUCCESS,
                ['status' => STATUS_CODE::TOKEN_NOT_FOUND],
                '请登录!'
            );
        }
        if ($result['expiration_date_token'] < time()) {
            return Functions::result(
                STATUS_CODE::EXPIRED_TOKEN,
                ['status' => STATUS_CODE::EXPIRED_TOKEN],
                '请登录!'
            );
        }
        $result['expiration_date_token'] = time() + (3600 * 24 * 10);
        unset($result['expiration_date_token']);
        // 重置token过期时间
        $model->setTokenExpired($token, time() + (3600 * 24 * 10));
        // 获取权限白名单,若当前权限在白名单内,则不用验证
        $setting_model = new Setting();
        $white_list_result = $setting_model
            ->getConfigure('rule_white_list');
        $white_list = [];
        foreach ($white_list_result as $v) {
            array_push($white_list, $v['identification']);
        }
        if (in_array($identification,$white_list)) {
            return Functions::result(
                STATUS_CODE::SUCCESS,
                [
                    'status' => STATUS_CODE::SUCCESS,
                    'info' => $result
                ]
            );
        }
        // 如果不在白名单则进行权限验证
        $rules_ids      = self::getRulesByUid($result['uid']);
        $rule_model     = new Rule();
        $identification = $rule_model->identificationToId($identification);
        if (!in_array($identification['id'], $rules_ids)) {
            return Functions::result(
                STATUS_CODE::SUCCESS,
                [
                    'status' => STATUS_CODE::PERMISSION_DENIED
                ],
                'Permission denied'
            );
        }
        return Functions::result(
            STATUS_CODE::SUCCESS,
            [
                'status' => STATUS_CODE::SUCCESS,
                'info' => $result
            ],
            'Permission denied'
        );
    }
    /**
     * @purpose 清除token
     * @param string $token
     * @return array
     */
    public static function clearToken(string $token): array
    {

        if (!$token) {
            exception('令牌(token)不能为空',
                STATUS_CODE::PARAMETER_ERROR);
        }
        $model = new Administrator();
        $result = $model
            ->save(
                ['token' => ''],
                ['token' => $token]);
        return Functions::result();
    }
    /**
     * @purpose 通过uid获取当前用户所有的权限ID
     * @param int $uid
     * @return array
     */
    private static function getRulesByUid(int $uid)
    {
        $user_model     = new Administrator();
        $group_model    = new Group();
        // 获取管理员的管理组信息
        $group_info     = $user_model->getGroup($uid);
        // 通过groupID获取rules
        $rule_ids       = $group_info['rules'];
        if ($group_info['groups']) {
            $group_rules = $group_model
                ->getRulesByIds($group_info['groups']);
            $rule_ids .= $rule_ids . ',' . $group_rules;
        }
        $rule_ids = trim($rule_ids, ',');
        return explode(',', $rule_ids);
    }
}