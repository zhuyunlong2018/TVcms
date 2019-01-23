<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/21
 * Time: 22:15
 */

namespace app\adminApi\controller;


use app\common\validate\PagingParameter;
use app\lib\Response;
use app\adminApi\model\SystemMenu;

class Menu extends BaseController
{
    public function getList($name='',$page=1,$limit=10,$order='desc',$sort='create_time') {
        (new PagingParameter())->goCheck();
        $list = SystemMenu::getList($name,$page,$limit,$order,$sort);
        return new Response(['data'=>$list]);
    }

}