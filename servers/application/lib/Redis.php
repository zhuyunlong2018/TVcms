<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/16
 * Time: 9:25
 */

namespace app\lib;


use think\Cache;


/**
 * 基于thinkPHP的Redis功能扩展类
 * Class Redis
 * @package app\lib
 */
class Redis
{
    /*
     * redis实例
     */
    protected static $redis;
    public function __construct($dbIndex=0)
    {
        self::init($dbIndex);
    }

    /**
     * 获取redis实例
     * @return object
     */
    public static function init($dbIndex=0) {
        if (is_null(self::$redis)) {
            self::$redis = Cache::store('redis')->handler();
        }
        self::$redis->select($dbIndex);
        return self::$redis;
    }


}