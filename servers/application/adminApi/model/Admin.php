<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/13
 * Time: 10:09
 */

namespace app\adminApi\model;


use app\common\model\CommonAdmin;

class Admin extends CommonAdmin
{

    public function role() {
        return $this->belongsToMany('Role', 'admin_role', 'role_id', 'admin_id');
    }
    public function user() {
        return $this->belongsTo('User')->field('gender,user_level,birthday,user_avatar,user_status',true);
    }


    public static function getByUserID($id){
        $user = self::where('user_id', '=', $id)->find();
        return $user;
    }

    public static function getList($name,$page,$limit,$order,$sort) {
        return self::with(['user','role'])
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