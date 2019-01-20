<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/20
 * Time: 19:18
 */

namespace app\adminApi\model;


use app\common\model\BaseModel;

class Role extends BaseModel
{
    public function menu() {
        return $this->belongsToMany('SystemMenu','role_menu','menu_id','role_id');
    }

}