<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/16
 * Time: 9:28
 */

namespace app\lib;


class Email
{
    function send_mail($mailTo,$mailSubject,$mailBody) {
        vendor('sendMail.smtp');
        //这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp = new smtp(config('email.smtpServer'),
            config('email.smtpServerPort'),
            true,
            config('email.smtUuser'),
            config('email.smtpPass'));
        //是否显示发送的调试信息
        $smtp->debug = FALSE;
        //发送邮件
        $result = $smtp->sendmail($mailTo, config('email.smtpUserMail'), $mailSubject,
            $mailBody,config('email.mailType'));

    }
}