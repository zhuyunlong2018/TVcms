<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/20
 * Time: 21:14
 */

namespace app\common\behavior;

use app\admin\model\Api;
use app\lib\ActionInfo;
use app\lib\Redis;


/**
 * Class ApiInjection 注册后台api到数据表当中
 * @package app\admin\behavior
 */
class ApiInjection
{
    private $path=null;
    public function appEnd(&$params) {

        $this->path = ActionInfo::$path;

        $allApiKey = myConfig('redisKey.apisType','all');
        if($this->path && !Redis::sIsMember($allApiKey,$this->path)) {
            //如果api未收录到数据库表中，注入数据库
            $this->injection();
        }
    }

    public function injection() {
        //核对缓存、数据库的api表，是否注入
        $check = Api::get(['api_path'=>$this->path]);
        if(empty($check)) {
            Api::create([
                'api_path' => $this->path,
                'api_name' => ActionInfo::$desc,
                'api_type' => ActionInfo::$type,
                'method' => ActionInfo::$method,
                'params' => ActionInfo::$params
            ]);
        }
    }

}
