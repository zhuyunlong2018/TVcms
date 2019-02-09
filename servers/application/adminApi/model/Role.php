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
    public function menus() {
        return $this->belongsToMany('SystemMenu','role_menu','menu_id','role_id');
    }

    public function menusId() {
        return $this->hasMany('RoleMenu','role_id','role_id');
    }

    public static function getList($name,$page,$limit,$order,$sort) {
        return self::with(['menusId' => function($query) {
                $query->field('role_id,menu_id');
            }])
            ->where(['role_name'=>['like',"%$name%"]])
            ->order("$sort $order")
            ->paginate($limit,false,['page'=>$page])
            ->each(function($item, $key){
                $menusID = [];
                foreach ($item->menus_id as $id) {
                    $menusID[] = $id->menu_id;
                }
                $item->menus = SystemMenu::getRoleMenu($menusID);
                unset($item->menus_id);
            });
    }

    public static function getRoleApi($roleID) {
        return self::with(['menus.api'])->where('role_id',$roleID)->find();
    }

}