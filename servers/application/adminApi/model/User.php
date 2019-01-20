<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/19
 * Time: 21:15
 */

namespace app\adminApi\model;


use app\common\model\CommonUser;

class User extends CommonUser
{
    protected $hidden = ['create_time','delete_time','update_time','pivot','user_pwd','user_pwd_salt','user_token_key'];
}