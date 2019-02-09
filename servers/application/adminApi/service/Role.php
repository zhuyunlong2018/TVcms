<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/6
 * Time: 17:19
 */

namespace app\adminApi\service;


use app\adminApi\model\RoleMenu;
use app\adminApi\model\Role as RoleModel;
use think\Cache;

class Role
{
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
        $roleMenus = RoleModel::getRoleApi($roleID);
        $roleApis = [];
        $menus = [];
        foreach ($roleMenus['menus'] as $roleMenu) {
            if(!in_array($roleMenu['menu_id'],$menus)) {
                $menus[] = $roleMenu['menu_id'];
            }
            $apis = $roleMenu['api'];
            foreach ($apis as $api) {
                $apiPath = [
                    'api_path'=>$api['api_path']
                ];
                if(!in_array($apiPath,$roleApis)) {
                    $roleApis[] = $apiPath;
                }
            }
        }
        Cache::tag('role-api')->set('role-api'.$roleID,$roleApis);
        Cache::tag('role-menu')->set('role-menu'.$roleID,$menus);
    }

    public static function getRoleApi($roleID) {
        $roleApi = Cache::get('role-api'.$roleID);
        if(!$roleApi) {
            self::getRole($roleID);
            $roleApi = Cache::get('role-api'.$roleID);
        }
        return $roleApi;
    }

    public static function getRoleMenu($roleID) {
        $roleMenu = Cache::get('role-menu'.$roleID);
        if(!$roleMenu) {
            self::getRole($roleID);
            $roleMenu = Cache::get('role-menu'.$roleID);
        }
        return $roleMenu;
    }

}