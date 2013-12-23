CREATE TABLE `users` (
      `user_id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
      `password` varchar(45) NOT NULL COMMENT '密码',
      `nickname` varchar(32) CHARACTER SET utf8 NOT NULL,
      `email` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '电子邮件',
      `icon_bucket` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
      `icon_key` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
      `roles` varchar(255) NOT NULL COMMENT '用户角色',
      `created_at` datetime NOT NULL COMMENT '注册时间',
      `user_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
      `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '用户状态：0为未认证，1为正常，2为禁止',
      PRIMARY KEY (`user_id`),
      UNIQUE KEY `idx_username` (`username`),
      UNIQUE KEY `idx_nick_name` (`nickname`),
      KEY `idx_user_created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3000 DEFAULT CHARSET=latin1 COMMENT='用户表';

CREATE TABLE `user_tokens` (
      `user_id` int(11) unsigned NOT NULL,
      `token` varchar(32) NOT NULL,
      `login_ip` BIGINT( 11 ) NOT NULL,
      `created_at` datetime NOT NULL,
      `expire_date` datetime NOT NULL,
      `token_type` enum('auth','verify','reset','flexauth') NOT NULL DEFAULT 'auth',
      PRIMARY KEY (`user_id`,`token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `users` ADD `phone_number` VARCHAR( 15 ) NOT NULL default '' COMMENT '手机号码' AFTER `status` ;
ALTER TABLE `users` add key `idx_user_phone_number` (`phone_number`);

CREATE TABLE `user_logins` (
      `user_id` int(11) unsigned NOT NULL COMMENT '',
      `login_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '',
      `login_ip` int(11) NOT NULL,
      `login_at` datetime NOT NULL,
      PRIMARY KEY (`login_id`),
      KEY `idx_user_last_logins` (`user_id`,`login_at`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;