<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/6
 * Time: 17:19
 */

namespace app\admin\service;


use app\admin\model\RoleMenu;
use app\admin\model\Role as RoleModel;
use app\lib\Redis;
use think\Cache;

class Role
{
    protected static $roleMenusKey=null;
    protected static $roleApisKey=null;

    public static function init($roleID=0) {
        if(!self::$roleMenusKey) {
            self::$roleMenusKey = myConfig('redisKey.roleMenus',$roleID);
        }
        if(!self::$roleApisKey) {
            self::$roleApisKey = myConfig('redisKey.roleApis',$roleID);
        }
    }
    public static function updateRoleMenus($role_id,$menus) {
        $roleMenus = RoleMenu::all(['role_id'=>$role_id]);
        $getMenus = [];
        $hasMenus = [];
        $insertMenus = [];
        $deleteMenus = [];
        foreach ($menus as $menu) {
            $getMenus = array_merge($getMenus, $menu['children']);
        }
        foreach ($roleMenus as $roleMenu) {
            if(!in_array($roleMenu['menu_id'],$getMenus)) {
                $deleteMenus[] = $roleMenu['role_menu_id'];
            }
            $hasMenus[] = $roleMenu['menu_id'];
        }
        foreach ($getMenus as $getMenu) {
            if(!in_array($getMenu,$hasMenus)) {
                $insertMenus[] =  [
                    'role_id' => $role_id,
                    'menu_id' => $getMenu
                ];
            }
        }
        if(!empty($deleteMenus)) {
            RoleMenu::destroy($deleteMenus,true);
        }
        if(!empty($insertMenus)) {
            (new RoleMenu())->saveAll($insertMenus);
        }
        return true;
    }

    public static function createRoleMenus($role_id,$menus) {
        $getMenus = [];
        $insertMenus = [];
        foreach ($menus as $menu) {
            $getMenus = array_merge($getMenus, $menu['children']);
        }
        foreach ($getMenus as $getMenu) {
            $insertMenus[] =  [
                'role_id' => $role_id,
                'menu_id' => $getMenu
            ];
        }
        if(!empty($insertMenus)) {
            (new RoleMenu())->saveAll($insertMenus);
        }
        return true;
    }

    public static function deleteRoleMenus($role_id) {
        $roleMenus = RoleMenu::all(['role_id'=>$role_id]);
        $deleteMenus = [];
        foreach ($roleMenus as $roleMenu) {
            $deleteMenus[] = $roleMenu['role_menu_id'];
        }
        if(!empty($deleteMenus)) {
            RoleMenu::destroy($deleteMenus,true);
        }
        return true;
    }

    public static function getRole($roleID) {
        self::init($roleID);
        $roleMenus = RoleModel::getRoleApi($roleID);
        $roleApis = [];
        $menus = [];
        foreach ($roleMenus['menus'] as $roleMenu) {
            if(!in_array($roleMenu['menu_id'],$menus)) {
                $menus[] = $roleMenu['menu_id'];
            }
            $apis = $roleMenu['api'];
            foreach ($apis as $api) {
                $apiPath = $api['api_path'];
                if(!in_array($apiPath,$roleApis)) {
                    $roleApis[] = $apiPath;
                }
            }
        }
        Redis::init()->sadd(self::$roleApisKey,...$roleApis);
        Redis::init()->sadd(self::$roleMenusKey,...$menus);
    }

    public static function getRoleApi($roleID) {
        self::init($roleID);
        $roleApi = Redis::init()->smembers(self::$roleApisKey);
        if(!$roleApi) {
            self::getRole($roleID);
            $roleApi = Redis::init()->smembers(self::$roleApisKey);
        }
        return $roleApi;
    }

    public static function getRoleMenu($roleID) {
        self::init($roleID);
        $roleMenu = Redis::init()->smembers(self::$roleMenusKey);
        if(!$roleMenu) {
            self::getRole($roleID);
            $roleMenu = Redis::init()->smembers(self::$roleMenusKey);
        }
        return $roleMenu;
    }

}