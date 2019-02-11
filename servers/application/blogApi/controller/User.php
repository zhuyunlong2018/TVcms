<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/16
 * Time: 20:24
 */

namespace app\blogApi\controller;


use app\common\controller\BaseController;
use app\blogApi\service\User as ServiceUser;

class User extends BaseController
{
    public function login() {
        $email = input('email');
        $password = input('password');
        $userData = ServiceUser::login($email,$password);
        return json($userData);
    }

    public function register($name,$email,$password) {
        $result = ServiceUser::register($name,$email,$password);
        return $result;
    }

}