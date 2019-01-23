<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/12
 * Time: 21:04
 */

namespace app\adminApi\controller;


use app\adminApi\service\Admin as AdminService;
use app\common\validate\PagingParameter;
use app\lib\Response;
use think\Request;
use app\adminApi\model\Admin as AdminModel;

class Admin extends BaseController
{
    //管理员登录，判断用户是否为管理员。
    /**
     * @API: adminApi/admin/login
     * @DESC: 后台登录接口
     */
    public function login($username,$password) {
        $adminData = AdminService::adminLogin($username,$password);
        return json($adminData);
    }
    public function getList($name='',$page=1,$limit=10,$order='desc',$sort='create_time') {
        (new PagingParameter())->goCheck();
        $list = AdminModel::getList($name,$page,$limit,$order,$sort);
        return new Response(['data'=>$list]);
    }

    /**
     * @API: adminApi/admin/logout
     * @DESC: 测试用接口
     */
    public function  logout() {

        Request::instance()->method();
//        return json(['heheh']);
    }

}