<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/12
 * Time: 20:07
 */

namespace app\common\behavior;


use app\admin\service\Auth;
use app\lib\ActionInfo;
use app\lib\exception\ParameterException;
use app\lib\exception\RequestMethodException;
use think\App;
use think\Request;

class AuthCheck
{
    public function actionBegin(&$params)
    {
        $request = Request::instance();
        $method = $request->method();
        $module = $request->module();
        $controller = $request->controller();
        $action = $request->action();
        if(empty($module)) $module = 'index';
        if(empty($controller)) $controller = 'Index';
        if(empty($action)) $action = 'index';
        $api = strtolower($module.'/'.$controller.'/'.$action);
        $class = 'app'.DS.$module.DS.'controller'.DS.$controller;
        ActionInfo::init($class,$action,$api);
        if($method !== ActionInfo::$method) {
            throw new RequestMethodException();
        }
        Auth::init($api,$method);
    }

}