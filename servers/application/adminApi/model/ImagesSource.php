<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/23
 * Time: 16:24
 */

namespace app\adminApi\model;


use app\common\model\BaseModel;

class ImagesSource extends BaseModel
{
    public function image() {
        return $this->belongsTo('Images','image_id','id')
            ->field('id,image,path');
    }

}