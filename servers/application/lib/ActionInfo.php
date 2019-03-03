<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/23
 * Time: 22:15
 */

namespace app\lib;


use app\admin\model\Api;
use app\lib\exception\DevException;
use ReflectionMethod;
use think\Cache;

/**
 * 通过反射获取api对应函数信息
 * Class ActionInfo
 * @package app\lib
 */
class ActionInfo
{

    protected static $ref = null;
    public static $path = null;
    public static $params = null;
    public static $desc = null;
    public static $type = null;
    public static $method = null;

    private function __construct()
    {
    }

    public static function init($class,$action,$path) {
        if(!self::$ref) {
            self::$ref = new ReflectionMethod($class, $action);
            self::$params = json_encode(self::$ref->getParameters());
        }
        if(!self::$path) {
            self::$path = $path;
        }
        self::getApi('@Api');
    }


    protected static function getApi($tag) {
        $str = self::getDocComment(self::$ref->getDocComment(), $tag);
        if(empty($str)) {
            return;
        }
        $infos = explode(',',$str);
        try{
            self::$desc = $infos[0];
            self::$type = $infos[1];
            self::$method = $infos[2];
        } catch (\Exception $e) {
            throw new DevException(['msg'=>'控制器方法@api注释错误']);
        }
    }

    protected static function getDocComment($str, $tag = '')
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