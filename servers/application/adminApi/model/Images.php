<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/14
 * Time: 22:23
 */

namespace app\adminApi\model;


use app\common\model\BaseModel;
use app\lib\File;

class Images extends BaseModel
{
    public function imageSource() {
        return $this->hasMany('ImagesSource','image_id','id');
    }

    public function getImageAttr($value,$data) {
        return File::getHttpPath($data['path'].DS.$value);
    }

}