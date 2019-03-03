<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/3/3
 * Time: 11:18
 */

namespace app\admin\service;


use app\lib\File;

class Uploads
{
    public function uploadUnboundExpired($key) {
        File::unlink($key,config('path.temporary'));
    }

}