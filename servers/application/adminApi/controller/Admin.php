<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/12
 * Time: 21:04
 */

namespace app\adminApi\controller;


use app\adminApi\service\Admin as AdminService;
use think\Request;


class Admin extends BaseController
{
    //管理员登录，判断用户是否为管理员。
    public function login() {
        $username = input('username');
        $password = input('password');
        $adminData = AdminService::adminLogin($username,$password);
        return json($adminData);
    }

    public function  logout() {

        Request::instance()->method();
        return json(['heheh']);
    }

}