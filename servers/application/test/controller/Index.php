<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/20
 * Time: 19:22
 */

namespace app\test\controller;


use app\adminApi\model\Admin;
use think\Controller;

class Index extends controller
{
    public function index() {
//        return Admin::getAuth();
        return Admin::getList();
    }

}