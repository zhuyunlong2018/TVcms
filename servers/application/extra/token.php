<?php
/**
 * Created by PhpStorm.
 * CommonUser: pc
 * Date: 2019/1/9
 * Time: 19:43
 */

return [
    //加密关键词
    'key' => md5('f1e6585wefweda'),

    //签发者
    'iss' => 'www.bianquan',

    //jwt所面向的用户
    'aud' => 'www.user',

    //在什么时间之后该jwt才可用
    'nbf' =>  10,

     //过期时间-100min
    'exp' =>  6000,

   //leeway in seconds
    'leeway'=> 60
];