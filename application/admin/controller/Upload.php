<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2018/6/2
 * Time: 下午1:56
 */
namespace app\admin\controller;


use extend\STATUS_CODE;
use think\facade\Env;
use think\facade\Request;

class Upload extends Auth
{
    /**
     * @purpose 图像上传
     * @return array
     */
    public function image(){
        $path       = '/image/';
        $limit_width      = (int) Request::header('limit-width');
        $limit_height     = (int) Request::header('limit-height');
        $limit_size     = ((int) Request::header('limit-size') * 1024);
        // 获取表单上传文件 例如上传了001.jpg
        $file       = request()->file('file');
        $_size      = getimagesize($_FILES['file']['tmp_name']);
        $size      = filesize($_FILES['file']['tmp_name']);
        $_width     = (int) $_size[0];
        $_height    = (int) $_size[1];
        // 限制上传图片的宽高
        if (($limit_width > 0 && $limit_height > 0) && ($limit_width !== $_width && $limit_height !== $_height)) {
            return [
                'code'      => STATUS_CODE::PARAMETER_ERROR,
                'message'   => '只能上传'.$limit_width.'×'.$limit_height.'的图片!',
                'data'      => []
            ];
        }
        // 限制图片大小
        if ($size > $limit_size) {            return [
            'code'      => STATUS_CODE::PARAMETER_ERROR,
            'message'   => '上传的图片不能超过'.($limit_size / 1024).'kb',
            'data'      => []
        ];
        }
        // 上传的图片不能超过500kb 且只能是jpg文件
        $info = $file
            ->validate(['size'=>512000,'ext'=>'jpg'])
            ->move(Env::get('root_path').'/uploads'.$path);
        if($info){
            return [
                'code' => STATUS_CODE::SUCCESS,
                'message' => 'success',
                'data' => [
                    'url' => $path.$info->getSaveName()
                ]
            ];
        }else{
            // 上传失败获取错误信息
            return [
                'code' => STATUS_CODE::UPLOAD_ERROR,
                'message' => $file->getError(),
                'data' => []
            ];
        }
    }
}