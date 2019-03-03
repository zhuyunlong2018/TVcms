<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/2/15
 * Time: 13:55
 */

namespace app\common\service;



use app\lib\Redis;
use app\lib\WriteLog;
use ReflectionClass;

class RedisSubscribe
{

    public function sub()
    {
        $redis = Redis::init(2);
        $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
        $redis->psubscribe(array('__keyevent@2__:expired'), function ($redis, $pattern, $chan, $msg) {
            echo "Notifyload: $msg\n";
            try{
                $arr = explode('|#|',$msg);
                $class = new ReflectionClass($arr[0]);
                $instance  = $class->newInstanceArgs();
                $instance->{$arr[1]}($arr[2]);
            } catch (\Exception $e) {
                $data = [
                    'error' => $e->getMessage(),
                    'data' => $msg
                ];
                new WriteLog($data);
            }


        });
    }

}