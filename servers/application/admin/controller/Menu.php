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
use app\admin\model\MenuApi;
use app\admin\service\User;
use app\common\validate\PagingParameter;
use app\lib\exception\RepeatException;
use app\lib\exception\ResourcesException;
use app\lib\Redis;
use app\lib\Response;
use app\admin\model\SystemMenu;
use think\Cache;

class Menu extends BaseController
{
    /**
     * @Api(获取系统菜单列表,3,GET)
     */
    public function getList($name='',$page=1,$limit=10,$order='desc',$sort='create_time') {
        (new PagingParameter())->goCheck();
        $list = SystemMenu::getList($name,$page,$limit,$order,$sort);
        return new Response(['data'=>$list]);
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
     * @Api(将指定api权限关联到对应菜单,3,POST)
     */
    public function linkApi($menu,$api) {
        $condition = [
            'menu_id' => $menu,
            'api_id' => $api
        ];
        $check = MenuApi::where($condition)->find();
        if (!empty($check)) {
            throw new RepeatException();
        }
        $result = MenuApi::insert($condition);
        Role::delRoleApisCache();
        Role::delRoleMenusCache();
        return new Response(['data'=>$result]);
    }

    /**
     * @Api(对指定api和菜单权限关联进行解绑,3,POST)
     */
    public function unLinkApi($menu,$api) {
        $condition = [
            'menu_id' => $menu,
            'api_id' => $api
        ];
        $check = MenuApi::withTrashed()->where($condition)->find();
        if (empty($check)) {
            throw new ResourcesException(['msg'=>'找不到相应的关联数据']);
        }
        $result = MenuApi::destroy($condition,true);
        Role::delRoleApisCache();
        Role::delRoleMenusCache();
        return new Response(['data'=>$result]);
    }

    /**
     * @Api(获取系统存在的所有菜单,2,GET)
     */
    public function getMenu() {
        $router = SystemMenu::getRouter('all');
        return new Response(['data'=>$router]);
    }

}