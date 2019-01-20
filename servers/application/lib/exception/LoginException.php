<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/13
 * Time: 10:24
 */

namespace app\lib\exception;


class LoginException extends BaseException
{
    public $code = 401;
    public $msg = '登录失败';
    public $errorCode = 10001;
}