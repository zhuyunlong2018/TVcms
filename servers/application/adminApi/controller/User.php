<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019/1/8
 * Time: 20:36
 */

namespace app\adminApi\controller;


use app\adminApi\service\Token;

class User extends BaseController
{
    public function index() {
        $jwt = Token::generateToken();
        dump($jwt);
    }
}