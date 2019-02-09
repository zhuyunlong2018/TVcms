<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/23
 * Time: 19:55
 */

namespace app\adminApi\controller;


use app\lib\Response;
use app\adminApi\model\Api as ApiModel;
use think\Cache;

class Api extends BaseController
{
    /**
     * @API(adminApi/Api/getList)
     * @DESC(根据类型获取API列表)
     */
    public function getList($type=0) {
        $list = ApiModel::getList($type,'asc','api_path');
        return new Response(['data'=>$list]);
    }

    /**
     * @API(adminApi/Api/changeType)
     * @DESC(根据id修改API的类型)
     */
    public function changeType($id,$type) {
        $api = ApiModel::get($id);
        Cache::rm('api'.($api->api_type));
        Cache::rm('api'.$type);
        $api->api_type = $type;
        $result = $api->save();
        return new Response(['data'=>$result]);
    }


}