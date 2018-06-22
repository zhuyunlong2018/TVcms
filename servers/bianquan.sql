CREATE TABLE IF NOT EXISTS `article` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_author` varchar(32) DEFAULT NULL COMMENT '作者',
  `a_title` varchar(32) DEFAULT NULL COMMENT '标题',
  `a_content` text DEFAULT NULL COMMENT '内容',
  `a_tag` varchar(32) DEFAULT NULL COMMENT '标签',
  `a_img` text DEFAULT NULL COMMENT '图片',
  `a_time` date DEFAULT NULL COMMENT '时间',
  `a_published` int(6) DEFAULT '0' COMMENT '状态：0关闭，1开放',
  `a_comment` int(6) DEFAULT '0' COMMENT '评论数',
  `a_praise` int(6) DEFAULT '0' COMMENT '点赞数',
  `a_viewer` int(6) DEFAULT '0' COMMENT '阅读量',
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `comment` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_article_id` int(6) DEFAULT NULL COMMENT '文章id',
  `c_user` varchar(32) DEFAULT NULL COMMENT '评论人',
  `c_content` text DEFAULT NULL COMMENT '内容',
  `c_time` date DEFAULT NULL COMMENT '时间',
  `c_type` int(6) DEFAULT '0' COMMENT '评论类型',
  `c_old_comment` varchar(30) DEFAULT NULL COMMENT '被评论人',
  `c_index` int(6) DEFAULT '0' COMMENT '评论楼层',
  `c_published` int(6) DEFAULT '0' COMMENT '状态：0关闭，1开放',
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(32) DEFAULT NULL COMMENT '用户名',
  `u_pwd` varchar(40) DEFAULT NULL COMMENT '密码',
  `u_email` text DEFAULT NULL COMMENT '邮箱',
  `u_status` varchar(32) DEFAULT NULL COMMENT '身份',
  `u_msg` text DEFAULT NULL COMMENT '备注',
  `u_time` date DEFAULT NULL COMMENT '注册时间',
  PRIMARY KEY (`u_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `webdata` (
  `total_id` int(11) NOT NULL AUTO_INCREMENT,
  `total_article` int(6) DEFAULT '0' COMMENT '文章数',
  `total_user` int(6) DEFAULT '0' COMMENT '用户数',
  `total_comment` int(6) DEFAULT '0' COMMENT '评论数',
  `total_praise` int(6) DEFAULT '0' COMMENT '点赞数',
  `total_tags` int(6) DEFAULT '0' COMMENT '标签数',
  `total_viewers`int(6) DEFAULT '0' COMMENT '访客数',
  PRIMARY KEY (`total_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(32) DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `production` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `pr_name` varchar(32) DEFAULT NULL COMMENT '标题',
  `pr_content` text DEFAULT NULL COMMENT '说明内容',
  `pr_src` text DEFAULT NULL COMMENT '连接',
  `pr_img` text DEFAULT NULL COMMENT '图片地址',
  `pr_published` int(6) DEFAULT '0' COMMENT '状态：0关闭，1开放',
  `pr_time` date DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`pr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `neighbors` (
  `nb_id` int(11) NOT NULL AUTO_INCREMENT,
  `nb_name` varchar(32) DEFAULT NULL COMMENT '标题',
  `nb_url` text DEFAULT NULL COMMENT '链接',
  `nb_icon` text DEFAULT NULL COMMENT '图标地址',
  `nb_published` int(6) DEFAULT '0' COMMENT '状态：0关闭，1开放',
  `nb_time` date DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`nb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `images` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_src` text DEFAULT NULL COMMENT '图片地址',
  `i_author` int(6) DEFAULT NULL COMMENT '上传用户id',
  `nb_time` date DEFAULT NULL COMMENT '上传时间',
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `about` (
  `about_id` int(11) NOT NULL AUTO_INCREMENT,
  `about_content` text DEFAULT NULL COMMENT 'about内容',
  PRIMARY KEY (`about_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



