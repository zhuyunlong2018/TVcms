<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/23
 * Time: 19:55
 */

namespace app\adminApi\controller;


use app\common\validate\PagingParameter;
use app\lib\Response;
use app\adminApi\model\Api as ApiModel;

class Api extends BaseController
{
    public function getList($type=0,$order='desc',$sort='create_time') {
        $list = ApiModel::getList($type,$order,$sort);
        return new Response(['data'=>$list]);
    }

}