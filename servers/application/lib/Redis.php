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

    private function __construct($dbIndex = 0)
    {
        self::init($dbIndex);
    }

    /**
     * 获取redis实例
     * @return object
     */
    public static function init($dbIndex = 0)
    {
        if (is_null(self::$redis)) {
            self::$redis = Cache::store('redis')->handler();
        }
        self::$redis->select($dbIndex);
        return self::$redis;
    }

    /*
     * STRING => 获取键值对
     */
    public static function get($key){
        self::init();
        // 是否一次取多个值
        $func = is_array($key) ? 'mGet' : 'get';
        return self::$redis->{$func}($key);
    }


    /*
     * STRING => 设置键值对
     */
    public static function set($key, $value, $expire=0){
        self::init();
        // 永不超时
        if($expire == 0){
            $ret = self::$redis->set($key, $value);
        }else{
            $ret = self::$redis->setex($key, $expire, $value);
        }
        return $ret;
    }

    /*
     *HASH => 获取一个多hash的一个或多个字段
     */
    public static function hGet($key,$field) {
        self::init();
        $func = is_array($field) ? 'hmGet' : 'hGet';
        return self::$redis->{$func}($key,$field);
    }

    /*
     *HASH => 获取一个哈希的所有字段值
     */
    public static function hGetAll($key) {
        self::init();
        return self::$redis->hGetAll($key);
    }

    /*
     * SET => 判断元素是否在集合中
     */
    public static function sIsMember($key,$field) {
        self::init();
        return self::$redis->sIsMember($key,$field);
    }

    /*
     * SET => 集合中添加元素
     */
    public static function sAdd($key,$value)
    {
        self::init();
        return self::$redis->sadd($key,...$value);
    }


}