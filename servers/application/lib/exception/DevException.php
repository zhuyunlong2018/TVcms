<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/3/1
 * Time: 10:38
 */

namespace app\lib\exception;


class DevException extends BaseException
{
    public $code = 505;
    public $msg = '开发时异常';
    public $errorCode = 60000;
}