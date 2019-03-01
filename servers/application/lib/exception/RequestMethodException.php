<?php


namespace app\lib\exception;

/**
 * token验证失败时抛出此异常 
 */
class RequestMethodException extends BaseException
{
    public $code = 401;
    public $msg = '请求方式错误';
    public $errorCode = 10002;
}