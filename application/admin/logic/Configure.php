<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/5/29
 * Time: 上午11:21
 */

namespace app\admin\logic;


use app\admin\model\Setting;
use extend\Functions;
use extend\STATUS_CODE;

class Configure extends Base
{

    /**
     * @purpose 根据key获取配置
     * @param string $key
     * @return array
     */
    public static function getConfigure(string $key): array
    {
        // TODO: Implement getConfigure() method.
        $model = new Setting();
        $result = $model->getConfigure($key);
        return Functions::result(STATUS_CODE::SUCCESS, $result);
    }

    /**
     * @purpose 设置配置,若存在则修改
     * @param string $key
     * @param array $value
     * @param string $description
     * @return array
     */
    public static function setConfigure(string $key, array $value = [], string $description = ''): array
    {
        // TODO: Implement setConfigure() method.
        $model = new Setting();
        $result = $model
            ->setConfigure($key, $value, $description);
        if ($result) {
            return Functions::result(STATUS_CODE::SUCCESS, 'success');
        }
        return Functions::result(STATUS_CODE::SUCCESS, '设置失败!');
    }
}