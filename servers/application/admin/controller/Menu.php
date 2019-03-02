<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/21
 * Time: 22:15
 */

namespace app\admin\controller;

use app\admin\service\Role;
use app\admin\service\Admin as AdminService;
use app\admin\service\User;
use app\common\validate\PagingParameter;
use app\lib\exception\ParameterException;
use app\lib\exception\RepeatException;
use app\lib\exception\ResourcesException;
use app\lib\Response;
use app\admin\model\SystemMenu;
use app\admin\service\Menu as MenuService;

class Menu extends BaseController
{
    /**
     * @Api(获取系统菜单列表,3,GET)
     */
    public function getList($name='',$page=1,$limit=10,$order='asc',$sort='sort') {
        (new PagingParameter())->goCheck();
        $list = SystemMenu::getList($name,$page,$limit,$order,$sort);
        return new Response(['data'=>$list]);
    }
    /**
     * @Api(创建系统菜单,3,POST)
     */
    public function create($father_id,$title,$path,$name,$component,$sort,$icon='',$api=[]) {
        $menu = SystemMenu::create([
            'father_id' => $father_id,
            'title' => $title,
            'path' => $path,
            'name' => $name,
            'component' => $component,
            'sort' => $sort,
            'icon' => $icon
        ]);
        if(!empty($api)) {
            $insert = MenuService::create($menu->menu_id,$api);
            $menu->api = $insert;
        }
        Role::delRoleApisCache();
        Role::delRoleMenusCache();
        return new Response(['data'=>$menu]);
    }
    /**
     * @Api(修改系统菜单,3,POST)
     */
    public function update($menu_id,$father_id,$title,$path,$name,$component,$sort,$icon='',$api=[]) {
        $menu = SystemMenu::get($menu_id);
        if(empty($menu)) {
            throw new ResourcesException();
        }
        if($father_id == $menu_id) {
            throw new RepeatException();
        }
        if($father_id != 0 ) {
            $father = SystemMenu::get($father_id);
            if(empty($father)) {
                throw new ResourcesException();
            }
            if($father->father_id != 0) {
                throw new ParameterException(['msg'=>'暂时不支持超过二级菜单']);
            }
        }
        $menu->title = $title;
        $menu->path = $path;
        $menu->father_id = $father_id;
        $menu->name = $name;
        $menu->component = $component;
        $menu->sort = $sort;
        $menu->icon = $icon;
        $menu->save();
        MenuService::update($menu_id,$api);
        Role::delRoleApisCache();
        Role::delRoleMenusCache();
        return new Response();
    }

    /**
     * @Api(获取后台用户对应权限菜单路由,2,GET)
     */
    public function getRouter() {
        //获取路由，1、根据用户角色生成menu_id的集合
        $user = User::init();
        $admin = AdminService::getAdmin($user['user_id']);
        $menus = [];
        foreach ($admin['roles'] as $role) {
            if($role['role_name'] == 'admin') {
                $menus = 'all';
                break;
            }
            $roleMenus = Role::getRoleMenu($role['role_id']);
            $menus = array_merge($roleMenus,$menus);
        }
        //2、根据menu_id集合获取对应路由
        $router = SystemMenu::getRouter($menus);
        return new Response(['data'=>$router]);
    }

    /**
     * @Api(获取系统存在的所有菜单,2,GET)
     */
    public function getMenu() {
        $router = SystemMenu::getRouter('all');
        return new Response(['data'=>$router]);
    }

}