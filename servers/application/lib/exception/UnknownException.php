<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/2/22
 * Time: 9:10
 */

namespace app\lib\exception;


class UnknownException extends BaseException
{
    public $code = 501;
    public $msg = '出现某种错误，休息一下';
    public $errorCode = 50001;
}