<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/3/1
 * Time: 14:36
 */

namespace app\admin\service;

use app\admin\model\Api as ApiModel;
use app\lib\Redis;

class Api
{

    /**
     *删除缓存中的api
     */
    public static function delCache($type='*') {
        $keys = myConfig('redisKey.apisType',$type);
        Redis::del($keys);
    }



    /**
     * 根据api权限类型获取对应api的列表
     * @param $type
     * @return array|mixed
     */
    public static function getApiByType($type,$key) {
        $api = Redis::sMembers($key);
        if(!$api) {
            $api = [];
            $items = ApiModel::getByType($type);
            foreach ($items as $item) {
                $api[] = $item['api_path'];
            }
            Redis::sAdd($key,$api);
        }
    }
}