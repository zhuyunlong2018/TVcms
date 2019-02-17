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
    public function __construct()
    {
        self::init();
    }

    /**
     * 获取redis实例
     * @return object
     */
    public static function init() {
        if (is_null(self::$redis)) {
            self::$redis = Cache::store('redis')->handler();
        }
        return self::$redis;
    }

    /*
     * 字符串，获取值
     */
    public static function get($key) {
        return self::init()->get($key);
    }

    /*
     * 字符串，设置值
     */
    public static function set($key,$value) {
        return self::init()->set($key,$value);
    }

    /*
     * 字符串，空值时设置值
     */
    public static function setnx($key,$value) {
        return self::init()->set($key,$value);
    }

    /*
     * 特定集合增加一个元素
     */
    public static function sadd($key,$value) {
        return self::init()->sadd($key,$value);
    }
    /*
     * 特定集合删除一个元素
     */
    public static function srem($key,$value) {
        return self::init()->srem($key,$value);
    }
}