<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

  	//发送邮件函数
  	function send_mail($mailto,$title,$content) {
  		//使用163邮箱服务器
  		$smtpserver = "smtp.163.com";
  		//163邮箱服务器端口
  		$smtpserverport = 25;
  		//你的163服务器邮箱账号
  		$smtpusermail = "xxxxxxxxxx";
  		// $smtpusermail = "zhonghuatuzi@163.com";
  		//收件人邮箱
  		$smtpemailto = $mailto;
  		//你的邮箱账号(去掉@163.com)
  		$smtpuser = "xxxxxxxxx";//你的163邮箱去掉后面的163.com
  		//你的邮箱密码
  		$smtppass = "xxxxxxxxx"; //你的163邮箱SMTP的授权码，千万不要填密码！！！

  		//邮件主题
  		$mailsubject = $title;
  		//邮件内容
  		$mailbody = $content;
  		//邮件格式（HTML/TXT）,TXT为文本邮件
  		$mailtype = "HTML";
      vendor('sendMail.smtp');
  		//这里面的一个true是表示使用身份验证,否则不使用身份验证.
  		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
  		//是否显示发送的调试信息
  		$smtp->debug = FALSE;
  		//发送邮件
  		$result = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

  	}
