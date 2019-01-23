<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/20
 * Time: 21:14
 */

namespace app\adminApi\behavior {

    use app\lib\ApiInjection;
    use think\Request;


    /**
     * Class API 注册后台api到数据表当中
     * @package app\adminApi\behavior
     */
    class API
    {
        public function appEnd(&$params) {
            $request = Request::instance();
            $module = $request->module();
            $controller = $request->controller();
            $action = $request->action();
            if(empty($module)) $module = 'index';
            if(empty($controller)) $controller = 'Index';
            if(empty($action)) $action = 'index';
            $class = 'app'.DS.$module.DS.'controller'.DS.$controller;
            $api = new ApiInjection($class,$action);
            $apiPath = $api->getApiDoc();
            $apiDesc = $api->getDescDoc();
            dump($apiDesc);
            dump($apiPath);
        }

    }
}