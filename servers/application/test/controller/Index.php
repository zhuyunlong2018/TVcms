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
use app\adminApi\model\Api;
use app\adminApi\service\Role;
use app\common\controller\BaseController;
use ReflectionClass;
use ReflectionMethod;
use think\Cache;
use think\Controller;
use app\adminApi\service\Role as RoleService;

class Index extends BaseController
{
    /**
     * @API(test/index/index)
     * @DESC(测试用接口描述)
     */
    public function index() {

        $role = Role::getRoleApi(1);
        $role = Cache::get('role-menu1');
        $admin = Admin::getByUserID(1);
//        Cache::rm('admin-user1');
        $admin = Cache::get('admin-user1');
//        Cache::clear('role-api');
//        Role::getRoleApi(1);
//        $admin = Cache::get('role1');
//        RoleService::getRoleApi(1);
//
//        return ($role);
        return ($admin);
//        Api::injection('index/index/hello','测试用接口数据');
//        $api = [
//            'api_name' => '会员管1理1',
//            'api_path' =>'/api/user1'
//        ];
//        $data = Cache::get('api');
//        dump($data);
//        if(!$data) {
//            dump(1);
//            Api::getApi();
//            $data = Cache::get('api');
//            dump($data);
//        }
//
//        dump(in_array($api,$data));

//        return Admin::getAuth();
//        return Admin::getList();
//        $method = new ReflectionMethod('app\adminApi\controller\Admin', 'login');
//        echo $this->getDocComment($method->getDocComment(), '@API');
//        echo $this->getDocComment($method->getDocComment(), '@desc');


//        $ref = new ReflectionClass('app\adminApi\controller\Admin');
//        echo $ref->getName();
//        echo $ref->getFileName();
    }


}