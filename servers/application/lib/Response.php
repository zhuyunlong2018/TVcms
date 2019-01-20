<?php
namespace app\lib;


/**
 * Class Response
 * @package app\lib 统一成功返回类
 */
class Response
{
    public $msg = 'request success';
    public $errorCode = 0;
    public $data = null;


    /**
     * 构造函数，接收一个关联数组
     * @param array $params 关联数组只应包含data、msg和errorCode，且不应该是空值
     */
    public function __construct($params=[])
    {
        if(!is_array($params)){
            return;
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
        if(array_key_exists('data',$params)){
            $this->data = $params['data'];
        }
    }
}

