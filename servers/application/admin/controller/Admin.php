<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/12
 * Time: 21:04
 */

namespace app\admin\controller;


use app\admin\service\Admin as AdminService;
use app\admin\service\Token;
use app\common\validate\PagingParameter;
use app\lib\exception\AuthException;
use app\lib\exception\ParameterException;
use app\lib\exception\RepeatException;
use app\lib\exception\ResourcesException;
use app\lib\Response;
use app\admin\model\Admin as AdminModel;

class Admin extends BaseController
{
    /**
     * @Api(后台登录接口,1,POST)
     */
    public function login($username,$password) {
        $adminData = AdminService::adminLogin($username,$password);
        return new Response(['data'=>$adminData]);
    }

    /**
     * @Api(获取管理员列表,3,GET)
     */
    public function getList($name='',$page=1,$limit=10,$order='desc',$sort='create_time') {
        (new PagingParameter())->goCheck();
        $list = AdminModel::getList($name,$page,$limit,$order,$sort);
        return new Response(['data'=>$list]);
    }

    /**
     * @Api(更新管理员信息,3,POST)
     */
    public function update($admin_id,$admin_name,$user,$roles) {
        if(empty($roles) || empty($user)) {
            throw new ParameterException(['msg'=>'管理员关联用户或关联角色不能为空']);
        }
        $admin = AdminModel::get($admin_id);
        if(empty($admin)) {
            throw new ResourcesException();
        }
        $admin->admin_name = $admin_name;
        $admin->user_id = $user['user_id'];
        $admin->save();
        AdminService::removeAdmin($user['user_id']);

        $result = AdminService::updateAdminRoles($admin_id,$roles);
        return new Response(['data'=>$result]);
    }

    /**
     * @Api(创建管理员,3,POST)
     */
    public function create($admin_name,$user,$roles) {
        if(empty($roles) || empty($user)) {
            throw new ParameterException(['msg'=>'管理员关联用户或关联角色不能为空']);
        }
        $admin = AdminModel::get(['admin_name'=>$admin_name]);
        if(!empty($admin)) {
            throw new RepeatException();
        }
        $admin = AdminModel::create([
            'admin_name' => $admin_name,
            'user_id' => $user['user_id']
        ]);
        $adminID = $admin->admin_id;
        AdminService::createAdminRoles($adminID,$roles);
        return new Response(['data'=>$admin]);
    }
    /**
     * @Api(删除管理员,3,POST)
     */
    public function delete($admin_id) {
        if($admin_id==1) {
            throw new AuthException(['msg'=>'超级管理员不能删除']);
        }
        $admin = AdminModel::get($admin_id);
        if(empty($admin)) {
            throw new ResourcesException();
        }
        AdminService::removeAdmin($admin->user_id);
        $admin->delete();
        AdminService::deleteAdminRoles($admin_id);
        return new Response();
    }

    /**
     * @Api(退出登录接口,2,POST)
     */
    public function  logout() {
        Token::removeToken();
    }

}