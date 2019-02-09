<?php


namespace app\lib\exception;

/**
 * token验证失败时抛出此异常 
 */
class AuthException extends BaseException
{
    public $code = 401;
    public $msg = '权限不足';
    public $errorCode = 10002;
}