<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/13
 * Time: 10:09
 */

namespace app\admin\model;


use app\common\model\BaseModel;
use app\lib\Redis;
use think\Cache;

class Admin extends BaseModel
{

    public function roles() {
        return $this->belongsToMany('Role', 'admin_role', 'role_id', 'admin_id');
    }
    public function user() {
        return $this->belongsTo('User')->field('gender,user_level,birthday,user_status',true);
    }


    public static function getByUserID($id){
        $admin = self::with('roles')->where('user_id', '=', $id)->find();
        return $admin->toArray();
    }

    public static function getList($name,$page,$limit,$order,$sort) {
        return self::with(['user','roles'])
            ->where(['admin_name'=>['like',"%$name%"]])
            ->order("$sort $order")
            ->paginate($limit,false,['page'=>$page]);
    }

    /**
     * 获取管理员权限列表
     */
    public static function getAuth() {
        return self::with('role.menu.api')->find();
    }
}