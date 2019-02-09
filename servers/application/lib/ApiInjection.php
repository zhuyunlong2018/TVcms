<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/23
 * Time: 22:15
 */

namespace app\lib;


use app\adminApi\model\Api;
use ReflectionMethod;
use think\Cache;

class ApiInjection
{

    protected $ref = null;
    protected $path = '';
    protected $desc = '';

    public function __construct($class,$action)
    {
        $this->ref = new ReflectionMethod($class, $action);
        $this->path = $this->getApi( '@API');
        $this->desc = $this->getApi( '@DESC');
    }

    public function injection() {
        //核对缓存、数据库的api表，是否注入
        Cache::rm('api');
        $check = Api::get(['api_path'=>$this->path]);
        if(!empty($this->path) && !empty($this->desc) && empty($check)) {
            Api::injection($this->path,$this->desc);
        }
    }

    protected function getApi($tag) {
        $str = $this->getDocComment($this->ref->getDocComment(), $tag);
        return strtolower($str);
    }

    protected function getDocComment($str, $tag = '')
    {
        if (empty($tag)) {
            return $str;
        }
        $matches = array();
        preg_match("/".$tag."\\((.*)(\\r\\n|\\r|\\n|\\))/U", $str, $matches);
        if (isset($matches[1])) {
            return trim($matches[1]);
        }
        return '';
    }

}