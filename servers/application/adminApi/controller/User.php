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
use app\adminApi\service\User as UserService;
use app\adminApi\model\Admin as AdminModel;
use app\common\validate\PagingParameter;
use app\lib\exception\ParameterException;
use app\lib\exception\RepeatException;
use app\lib\exception\ResourcesException;
use app\lib\Response;

class User extends BaseController
{

    public function login($email,$password) {
        $userData = UserService::loginByEmail($email,$password);
        return new Response(['data'=>$userData]);
    }

    public function register($name,$email,$password) {
        $result = UserService::register($name,$email,$password);
        return new Response(['msg'=>'注册成功','data'=>$result]);
    }

    public function getList() {
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

    /**
     * @API(adminApi/User/getOne)
     * @DESC(根据条件获取一名用户信息)
     */
    public function getOne($type,$value) {
        switch ($type) {
            case 'user_name':
            case 'user_email':
                $user = UserModel::get([$type=>$value]);
                if(empty($user)) {
                    throw new ResourcesException(['msg'=>'用户不存在']);
                }
                if(AdminModel::get(['user_id'=>$user->user_id])) {
                    throw new RepeatException(['msg'=>'该用户已经是管理员，请不要重复添加']);
                }
                return new Response(['data'=>$user]);
                break;
            default:
                throw new ParameterException(['msg'=>'type类型错误！']);
        }
    }


}