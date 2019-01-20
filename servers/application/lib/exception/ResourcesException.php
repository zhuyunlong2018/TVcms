<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/20
 * Time: 13:07
 */

namespace app\lib\exception;


class ResourcesException extends BaseException
{
    public $code = 404;
    public $errorCode = 10000;
    public $msg = "resources not found";
}