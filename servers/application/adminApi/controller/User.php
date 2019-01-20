<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/12
 * Time: 20:07
 */

namespace app\adminApi\controller;


use app\adminApi\model\User as UserModel;
use app\common\validate\PagingParameter;

class User extends BaseController
{

    public function login() {
        dump(3);
    }

    public function userList() {
        (new PagingParameter())->goCheck();
        $condition = [];
        $userName = input('username');
        $userMobile = input('mobile');
        if(!empty($userName)) $condition['user_name'] = ['like',"%$userName%"];
        if(!empty($userMobile)) $condition['user_mobile'] = ['like',"%$userMobile%"];
        $order = ['user_id'=>'desc'];
        $page = input('page');
        $limit = input('limit');
        $list = UserModel::getListByPage($condition,$order,$page, $limit);
        $data = ['items' => $list,
                'total' =>$list->total()];
        return json($data);
    }


}