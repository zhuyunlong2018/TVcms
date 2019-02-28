<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/2/28
 * Time: 15:43
 */

return [
    //用户token储存对应用户的数组信息-哈希
    'userToken' => 'token:placeholder',

    //通过admin关联的user_id存储admin的数组信息-哈希
    'adminInfo' => 'admin_user_id:placeholder',

    //通过role_id存储角色关联的菜单menu_id数组-set集合
    'roleMenus' => 'menu_role_id:placeholder',

    //通过role_id存储角色对应的api_path数组-set集合
    'roleApis' => 'api_role_id:placeholder',

    //通过api_type来存储对应的类型的api数组-set集合
    'apisType' => 'api_list_type:placeholder',
];