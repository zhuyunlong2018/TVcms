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

        //获取请求的api地址
        $api = strtolower($module.'/'.$controller.'/'.$action);

        //请求的控制器类
        $class = 'app'.DS.$module.DS.'controller'.DS.$controller;

        //通过反射获取请求api方法的信息
        ActionInfo::init($class,$action,$api);

        //对前端请求的request方法进行校验
        if(ActionInfo::$method && $method !== ActionInfo::$method) {
            throw new RequestMethodException();
        }

        //对管理员访问该api权限进行校验
        Auth::init($api,$method);
    }

}