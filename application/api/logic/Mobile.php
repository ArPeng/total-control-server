<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/8/19
 * Time: 下午9:48
 */

namespace app\api\logic;


use app\model\PhoneNumber;
use extend\Functions;
use extend\STATUS_CODE;
use think\facade\Cache;

class Mobile
{
    /**
     * @purpose 客户端检测完之后手机号码更新
     * @param $data
     * @return array
     */
    public static function saveFilter ($data)
    {
        if (!$data['mobile']) {
            return Functions::result(
                STATUS_CODE::PARAMETER_ERROR,
                '缺少手机号码'
            );
        }
        if (!$data['description']) {
            return Functions::result(
                STATUS_CODE::PARAMETER_ERROR,
                '缺少描述'
            );
        }
        $model      = new PhoneNumber();
        $result     = $model
            ->save([
                'description' => $data['description'],
                'status'      => 3,
                'online'      => 1,
                'client_filter_at' => time()
            ],['mobile' => $data['mobile']]);
        if ($result) {
            return Functions::result();
        }
        return Functions::result(
            STATUS_CODE::UPDATE_FAIL,
            '数据更新失败!'
        );
    }
    /**
     * @purpose 获取平台token
     * @return mixed
     */
    public static function getToken ()
    {
        $token = Cache::store('redis')->get('check_online_token');
        if ($token) {
            return $token;
        }
        $url = 'http://api.ema666.com/Api/userLogin?uName=twz1993&pWord=19930110&Developer=CnQszuzarQbje6DOcckBsQ%3d%3d&Code=UTF8';
        $result = \Requests::post($url);
        if ($result->body == 'False:用户名密码错误!') {
            exit($result->body);
        }
        $result = explode('&',$result->body);
        Cache::store('redis')->set('check_online_token',$result[0], 300);
        return $result[0];
    }

    /**
     * @purpose 获取短信验证码
     * @param string $mobile
     * @return array
     */
    public static function getMessage (string $mobile)
    {
        $token  = self::getToken();
        $url = 'http://api.ema666.com/Api/userSingleGetMessage?token='.$token.'&Code=UTF8&itemId=14&phone='.$mobile;
        $result = \Requests::get($url);
        if (strpos($result->body, '验证码') === false) {
            return Functions::result(
                STATUS_CODE::FAIL,
                $result->body
            );
        }
        preg_match('/\d{6}/', $result->body,$result);
        $model     = new PhoneNumber();
        // 保存验证码到数据库
        $model->save(['auth_code' => $result[0]], ['mobile' => $mobile]);
        return Functions::result(
            STATUS_CODE::SUCCESS,
            [
                'code' => $result[0]
            ]
        );
    }
    /**
     * @purpose 获取
     * @return array
     */
    public static function getOneOnline ()
    {
        $model         = new PhoneNumber();
        $mobile        = $model
            ->where(['status' => 1])
            ->value('mobile');
        RE_MOBILE:
            $mobile        = $model
                ->where(['status' => 1])
                ->value('mobile');
//         检测手机号码是否在线
//         获取token
        $token      = self::getToken();
//         检测手机号码是否在线
//         释放手机号码
        \Requests::get('http://api.ema666.com/Api/userReleasePhone?token='.$token.'&phoneList='.$mobile.'-14;');
        $online     = \Requests::get('http://api.ema666.com/Api/userGetPhone?ItemId=14&token='.$token.'&PhoneType=0&Code=UTF8&Phone='.$mobile);
        $online     = $online->body;
        if (strpos($online, $mobile) === false) {
            // 如果不在线则重新获取手机号码，并标记
            $model->save(['online' => 2], ['mobile' => $mobile]);
            goto RE_MOBILE;
        }
        $model->save(['status' => 2], ['mobile' => $mobile]);
        return Functions::result(
            STATUS_CODE::SUCCESS,
            [
                'mobile' => $mobile
            ]
        );
    }
    /**
     * @purpose 过滤之后的数据入库
     * @param string $mobile
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public static function saveMobile (string $mobile = '') :array
    {
        if (!$mobile) {
            return Functions::result(
                STATUS_CODE::PARAMETER_ERROR,
                '缺少手机号码!'
            );
        }
        $mobile     = trim($mobile, "\n");
        $mobile     = explode("\n", $mobile);
        $model      = new PhoneNumber();
        $_mobile    = $model
            ->where(['mobile' => $mobile])
            ->field('mobile')
            ->select();

        $temp = [];
        if (!$_mobile->isEmpty()) {
            foreach ($_mobile as $value) {
                array_push($temp, $value->mobile);
            }
        }
        $mobile      = array_unique(array_filter(array_values(array_diff($mobile,$temp))));
        if (empty($mobile)) {
            return Functions::result(
                STATUS_CODE::FAIL,
                '过滤之后的手机号码为空!'
            );
        }
        $data = [];
        foreach ($mobile as $_mobile) {
            array_push($data, [
                'mobile' => $_mobile
            ]);
        }
        $result     = $model->saveAll($data);
        if ($result) {
            return Functions::result(
                STATUS_CODE::SUCCESS,
                'success'
            );
        }
        return Functions::result(
            STATUS_CODE::CREATE_FAIL,
            '数据添加失败'
        );

    }
    /**
     * @purpose 过滤数据
     * @param string $mobile
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public static function filterMobile (string $mobile = '') :array
    {
        if (!$mobile) {
            return Functions::result(
                STATUS_CODE::PARAMETER_ERROR,
                '缺少手机号码!'
            );
        }
        $mobile     = trim($mobile, "\n");
        $mobile     = explode("\n", $mobile);
        $model      = new PhoneNumber();
        $_mobile    = $model
            ->where(['mobile' => $mobile])
            ->field('mobile')
            ->select();
        $temp = [];
        if (!$_mobile->isEmpty()) {
            foreach ($_mobile as $value) {
                array_push($temp, $value->mobile);
            }
        }
        $mobile      = array_unique(array_filter(array_values(array_diff($mobile,$temp))));
        return Functions::result(
            STATUS_CODE::SUCCESS,
            $mobile
        );
    }
}