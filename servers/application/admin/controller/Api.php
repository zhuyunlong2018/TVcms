<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/23
 * Time: 19:55
 */

namespace app\admin\controller;


use app\lib\Response;
use app\admin\model\Api as ApiModel;
use app\admin\service\Api as ApiService;


class Api extends BaseController
{
    /**
     * @Api(根据类型获取API列表,2,GET)
     */
    public function getList($type=0) {
        $list = ApiModel::getList($type,'asc','api_path');
        return new Response(['data'=>$list]);
    }

    /**
     * @Api(根据id修改API的类型,3,POST)
     */
    public function changeType($id,$type) {
        $api = ApiModel::get($id);
        $api->api_type = $type;
        $result = $api->save();
        ApiService::delCache();
        return new Response(['data'=>$result]);
    }


}