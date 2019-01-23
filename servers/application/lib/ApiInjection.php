<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/23
 * Time: 22:15
 */

namespace app\lib;


use ReflectionMethod;

class ApiInjection
{

    protected $ref = null;
    protected $path = '';
    protected $desc = '';

    public function __construct($class,$action)
    {
        $this->ref = new ReflectionMethod($class, $action);
        $this->path = $this->getDocComment($this->ref->getDocComment(), '@API');
        $this->desc = $this->getDocComment($this->ref->getDocComment(), '@DESC');
    }

    public function injection() {
        //核对缓存、数据库的api表，是否注入
    }


    public function getDocComment($str, $tag = '')
    {
        if (empty($tag)) {
            return $str;
        }
        $matches = array();
        preg_match("/".$tag.":(.*)(\\r\\n|\\r|\\n)/U", $str, $matches);
        if (isset($matches[1])) {
            return trim($matches[1]);
        }
        return '';
    }

}