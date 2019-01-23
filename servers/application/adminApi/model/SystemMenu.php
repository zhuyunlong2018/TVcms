<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/20
 * Time: 19:19
 */

namespace app\adminApi\model;


use app\common\model\BaseModel;

class SystemMenu extends BaseModel
{
    public function api() {
        return $this->belongsToMany('Api','menu_api','api_id','menu_id');
    }

    public function children() {
        return $this->hasMany('SystemMenu','father_id','menu_id');
    }

    public static function getList() {
        return self::with(['children','api'])->where('father_id',0)->select();
    }
}