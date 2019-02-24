<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/2/15
 * Time: 13:55
 */

namespace app\common\service;



use app\lib\Redis;
use app\lib\File;
use think\Cache;

class RedisSubscribe
{

    public function sub()
    {

        $redis = Redis::init(2);
        $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
        $redis->psubscribe(array('__keyevent@2__:expired'), function ($redis, $pattern, $chan, $msg) {
            echo "Notifyload: $msg\n";
            $arr = explode('|#|',$msg);
            switch ($arr[0]) {
                case 'uploadUnboundExpired':
                    File::unlink($arr[1],config('path.temporary'));
                    break;
                default:
            }

        });
    }

}