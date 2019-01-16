<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/16
 * Time: 20:24
 */

namespace app\blogApi\controller;


use think\Controller;
use app\blogApi\service\User as ServiceUser;

class User extends Controller
{
    public function login() {
        $useremail = input('useremail');
        $password = input('password');
        $userData = ServiceUser::login($useremail,$password);
        return json($userData);
    }

}