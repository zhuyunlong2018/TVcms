<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/1
 * Time: 21:10
 */

namespace app\lib\exception;


class RepeatException extends BaseException
{
    public $code = 404;
    public $errorCode = 20001;
    public $msg = "resources repeat";
}