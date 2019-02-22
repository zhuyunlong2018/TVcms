<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/21
 * Time: 22:15
 */

namespace app\adminApi\controller;

use app\adminApi\service\Role;
use app\adminApi\service\Admin as AdminService;
use app\adminApi\model\MenuApi;
use app\adminApi\service\Token;
use app\common\validate\PagingParameter;
use app\lib\exception\RepeatException;
use app\lib\exception\ResourcesException;
use app\lib\Response;
use app\adminApi\model\SystemMenu;
use think\Cache;

class Menu extends BaseController
{
    /**
     * @API(adminApi/Menu/getList)
     * @DESC(获取系统菜单列表)
     */
    public function getList($name='',$page=1,$limit=10,$order='desc',$sort='create_time') {
        (new PagingParameter())->goCheck();
        $list = SystemMenu::getList($name,$page,$limit,$order,$sort);
        return new Response(['data'=>$list]);
    }

    /**
     * @API(adminApi/Menu/getRouter)
     * @DESC(获取后台用户对应权限菜单路由)
     */
    public function getRouter() {
        //获取路由，1、根据用户角色生成menu_id的集合
        $user = Token::getUser();
        $admin = AdminService::getAdmin($user['user_id']);
        $menus = [];
        foreach ($admin['roles'] as $role) {
            $roleMenus = Role::getRoleMenu($role['role_id']);
            $menus = array_merge($roleMenus,$menus);
        }
        //2、根据menu_id集合获取对应路由
        $router = SystemMenu::getRouter($menus);
        return new Response(['data'=>$router]);
    }

    /**
     * @API(adminApi/Menu/linkApi)
     * @DESC(将指定api权限关联到对应菜单)
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
        Cache::clear('role-api');
        return new Response(['data'=>$result]);
    }

    /**
     * @API(adminApi/Menu/unLinkApi)
     * @DESC(对指定api和菜单权限关联进行解绑)
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
        Cache::clear('role-api');
        return new Response(['data'=>$result]);
    }

    /**
     * @API(adminApi/Menu/getMenu)
     * @DESC(获取系统存在的所有菜单)
     */
    public function getMenu() {
        $router = SystemMenu::getRouter('all');
        return new Response(['data'=>$router]);
    }

}