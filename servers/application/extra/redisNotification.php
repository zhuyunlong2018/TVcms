<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/21
 * Time: 20:07
 */

/*
 * redis定时任务说明，'|#|'为分割符号，key组成分为三部分
 * 1、键失效时执行回调的类
 * 2、回调类中回调函数的名称
 * 3、传入回调函数的参数值
 */
return [
    //上传图片未绑定且过期,
    'uploadUnbound'   => 'app\admin\service\Uploads|#|uploadUnboundExpired|#|'

];