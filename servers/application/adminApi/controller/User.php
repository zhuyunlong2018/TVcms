<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019/1/8
 * Time: 20:36
 */

namespace app\adminApi\controller;


use app\adminApi\service\Token;
use app\adminApi\model\User as UserModel;

class User extends BaseController
{
    /**
     *
     */
    public function index() {
//        $jwt = Token::generateToken('1','123@.qq.com','www');
//        dump($jwt);
//        $result = UserModel::getUserList();
//        $result = UserModel::getSummaryByPage();
//        dump($result);
    }

    public function login() {
        dump(111);
    }


}