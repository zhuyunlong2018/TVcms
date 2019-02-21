<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/2/21
 * Time: 10:01
 */

namespace app\api\controller;


use app\common\controller\BaseController;
use app\lib\Protect;
use app\lib\Redis;
use app\lib\Response;
use app\lib\Uploads as UploadsLib;
use think\Request;
/*
 * 公共上传接口,本类上传为临时上传，过期未绑定将删除资源
 */
class Uploads extends BaseController
{
    protected $path;
    protected $notification;
    protected $expire = 600;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->path = config('path.temporary');
    }

    /**
     *上传一张图片
     */
    public function imageBase64()
    {
        Protect::IpAndSidCount();
        $img = (input('image'));
        $save = UploadsLib::saveBase64($img,$this->path);
        if($save){
            //保存成功，设置24小时未绑定过期未处理删除
            Redis::init(2)->setex($this->notification.$save,$this->expire,'expired');
            return new Response(['msg'=>'上传成功，请在10分钟内绑定图片，过期将删除','data'=>$save]);
        }
    }


}