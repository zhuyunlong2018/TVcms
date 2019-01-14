<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/14
 * Time: 21:54
 */

namespace app\adminApi\validate;



class pagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'require|number|gt:0',
        'limit' => 'isPositiveInteger|gt:0'
    ];

    protected $message = [
        'page' => '分页参数必须是正整数',
        'limit' => '分页参数必须是正整数'
    ];

}