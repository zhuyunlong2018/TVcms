<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/13
 * Time: 18:01
 */

namespace app\adminApi\controller;


class Mock extends BaseController
{
    public function home() {
        $data = [
            'goodsTotal'=>5,
            'orderTotal'=>7,
            'productTotal' => 11,
            'userTotal' => 38,
            'introduction' => '一只管理员'
        ];
        return json($data);
    }

    public function info() {
        $data = [
            'name'=>"管理员1",
            'roles' => ['admin'],
            'avatar' => "https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif",
            'introduction' => '一只管理员'
        ];
        return json($data);
    }

}
