<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/2/15
 * Time: 16:08
 */

namespace app\lib;

/**
 * 自定义日志类
 * Class WriteLog
 * @package app\lib
 */
class WriteLog
{
    protected $content;
    protected $file;

    public function __construct($content,$file=null)
    {
       $this->content = $content;
       if($file) {
           $this->file = APP_PATH.$file;
       } else {
           $this->file = APP_PATH."/log/log.txt";
       }
       $this->write();
    }

    public function write() {
        $file = fopen($this->file,"a+");
        $time = date('Y-m-d H:i:s',time());
        $tag = "\r\n------------------------------------------\n
            [ $time ]\r\n";
        fwrite($file,$tag);
        fwrite($file,print_r($this->content, true));
        fclose($file);
    }

}