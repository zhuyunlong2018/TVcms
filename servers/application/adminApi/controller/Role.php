<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/21
 * Time: 21:54
 */

namespace app\adminApi\controller;
use app\adminApi\model\Role as RoleModel;
use app\common\validate\PagingParameter;
use app\lib\Response;

class Role extends BaseController
{
    public function getList($name='',$page=1,$limit=10,$order='desc',$sort='create_time') {
        (new PagingParameter())->goCheck();
        $list = RoleModel::getList($name,$page,$limit,$order,$sort);
        return new Response(['data'=>$list]);
    }

}