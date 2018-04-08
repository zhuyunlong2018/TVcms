CREATE TABLE IF NOT EXISTS `user`(
   `u_id` INT UNSIGNED AUTO_INCREMENT,
   `u_name` VARCHAR(30) NOT NULL,
   `u_pwd` VARCHAR(40) NOT NULL,
   `u_mail` VARCHAR(30) NOT NULL,
   `u_status` VARCHAR(30) NOT NULL,
   `u_msg` VARCHAR(30) NOT NULL,
   `u_time` DATE,
   PRIMARY KEY ( `u_id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `article`(
   `a_id` INT UNSIGNED AUTO_INCREMENT,
   `a_author` VARCHAR(30) NOT NULL,
   `a_title` VARCHAR(30) NOT NULL,
   `a_content` TEXT NOT NULL,
   `a_tag` TEXT NOT NULL,
   `a_time` DATE,
   `a_img` TEXT NOT NULL,
   `a_published` INT(6) NOT NULL,
   `a_comment` INT(6) NOT NULL,
   `a_praise` INT(6) NOT NULL,
   PRIMARY KEY ( `a_id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `comment`(
   `c_id` INT UNSIGNED AUTO_INCREMENT,
   `c_article_id` INT(6) NOT NULL,
   `c_user` VARCHAR(30) NOT NULL,
   `c_content` TEXT NOT NULL,
   `c_time` DATE,
   `c_type` INT(6) NOT NULL,
   `c_old_comment` VARCHAR(30) NOT NULL,
   `c_index` INT(6) NOT NULL,
   `c_published` INT(6) NOT NULL,
   PRIMARY KEY ( `c_id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `images`(
   `i_id` INT UNSIGNED AUTO_INCREMENT,
   `i_src` TEXT NOT NULL,
   `i_author` VARCHAR(30) NOT NULL,
   `i_time` DATE,
   PRIMARY KEY ( `i_id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `webdata`(
   `total_article` INT NOT NULL,
   `total_user` INT NOT NULL,
   `total_comment` INT NOT NULL,
   `total_praise` INT NOT NULL,
   `total_tags` INT NOT NULL,
   `total_viewers` INT NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `webdata` (`total_article`, `total_user`, `total_comment`,`total_praise`,`total_tags`,`total_viewers`) VALUES   
(0, 0, 0, 0, 0, 0);  





CREATE TABLE IF NOT EXISTS `tags`(
   `tag_id` INT UNSIGNED AUTO_INCREMENT,
   `tag_name` TEXT NOT NULL,
   PRIMARY KEY ( `tag_id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `neighbors`(
   `nb_id` INT UNSIGNED AUTO_INCREMENT,
   `nb_name` TEXT NOT NULL,
   `nb_url` TEXT NOT NULL,
   `nb_icon` TEXT NOT NULL,
   `nb_time` DATE,
   `nb_published` INT NOT NULL,
   PRIMARY KEY ( `nb_id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `production`(
   `pr_id` INT UNSIGNED AUTO_INCREMENT,
   `pr_name` TEXT NOT NULL,
   `pr_content` TEXT NOT NULL,
   `pr_src` TEXT NOT NULL,
   `pr_img` TEXT NOT NULL,
   `pr_time` DATE,
   `pr_published` INT NOT NULL,
   PRIMARY KEY ( `pr_id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `about`(
   `about` TEXT NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `about` (`about`) VALUES   
('hello');  


