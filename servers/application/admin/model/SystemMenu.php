<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/20
 * Time: 19:19
 */

namespace app\admin\model;


use app\common\model\BaseModel;

class SystemMenu extends BaseModel
{
    public function api() {
        return $this->belongsToMany('Api','menu_api','api_id','menu_id');
    }

    public function role() {
        return $this->belongsToMany('Role','role_menu','role_id','menu_id');
    }

    public function children() {
        return $this->hasMany('SystemMenu','father_id','menu_id');
    }

    public static function getList($name,$page,$limit,$order,$sort) {
        return self::with(['children.api'])
            ->where('father_id',0)
            ->order( "$sort $order")
            ->select();
    }

    public static function getRouter($menus) {
        $condition = [];
        if($menus !== 'all') {
            $condition = ['menu_id'=>['in',$menus]];
        }
        return self::with(['children'=>function($query) use($condition) {
            $query->where($condition)->order('sort asc');
        }])->where('father_id',0)
            ->order('sort asc')
//            ->fetchSql()
            ->select();
    }

    public static function getRoleMenu($menusID) {
        return self::with(['children' => function($query) use ($menusID) {
            $query->where('menu_id','in',$menusID);
        }])->where('father_id',0)->select();
    }

}