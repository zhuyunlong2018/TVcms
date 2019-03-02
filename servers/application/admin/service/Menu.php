<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/3/2
 * Time: 15:40
 */

namespace app\admin\service;


use app\admin\model\MenuApi;

class Menu
{
    public static function update($menu_id,$apis) {
        $menuApis = MenuApi::all(['menu_id'=>$menu_id]);
        $hasApi = [];
        $insert = [];
        $delete = [];
        foreach ($menuApis as $menuApi) {
            if(!in_array($menuApi['api_id'],$apis)) {
                $delete[] = $menuApi['menu_api_id'];
            }
            $hasApi[] = $menuApi['api_id'];
        }
        foreach ($apis as $api) {
            if(!in_array($api,$hasApi)) {
                $insert[] =  [
                    'menu_id' => $menu_id,
                    'api_id' => $api
                ];
            }
        }
        if(!empty($delete)) {
            MenuApi::destroy($delete,true);
        }
        if(!empty($insert)) {
            (new MenuApi())->saveAll($insert);
        }
        return true;
    }

    public static function create($menu_id,$apis) {
        $insert = [];
        foreach ($apis as $api) {
            $insert[] = [
                'menu_id' => $menu_id,
                'api_id' => $api
            ];
        }
        if(!empty($insert)) {
            (new MenuApi())->saveAll($insert);
        }
        return $insert;
    }

}