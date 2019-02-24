<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/21
 * Time: 20:07
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

     //过期时间4h
//    'exp' =>  600,
    'exp' =>  14400,

   //leeway in seconds
    'leeway'=> 60
];