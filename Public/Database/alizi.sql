
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `alizi_advert`;
CREATE TABLE `alizi_advert` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '',
  `name` varchar(100) NOT NULL COMMENT '',
  `banner` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL COMMENT '',
  `link` varchar(255) NOT NULL COMMENT '',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '',
  `target` enum('_blank','_self') NOT NULL,
  `description` mediumtext NOT NULL COMMENT '',
  `sort_order` mediumint(5) NOT NULL DEFAULT '0' COMMENT '',
  `create_time` int(10) NOT NULL,
  `type` enum('幻灯片','广告') NOT NULL DEFAULT '幻灯片' COMMENT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='广告幻灯片表-alizi.net';

DROP TABLE IF EXISTS `alizi_alipay_log`;
CREATE TABLE `alizi_alipay_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pay_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '',
  `discount` mediumint(5) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL COMMENT '',
  `trade_no` varchar(64) NOT NULL,
  `buyer_email` varchar(32) DEFAULT NULL,
  `gmt_create` datetime DEFAULT NULL,
  `notify_type` varchar(50) DEFAULT NULL,
  `quantity` mediumint(5) DEFAULT NULL,
  `out_trade_no` varchar(32) NOT NULL COMMENT '',
  `seller_id` varchar(30) DEFAULT NULL,
  `notify_time` datetime NOT NULL,
  `trade_status` varchar(50) NOT NULL DEFAULT '',
  `is_total_fee_adjust` char(1) DEFAULT NULL,
  `total_fee` decimal(8,2) NOT NULL COMMENT '',
  `gmt_payment` datetime DEFAULT NULL,
  `seller_email` varchar(32) NOT NULL DEFAULT '' COMMENT '',
  `price` decimal(10,2) DEFAULT NULL,
  `buyer_id` varchar(30) DEFAULT NULL,
  `notify_id` varchar(32) DEFAULT NULL,
  `use_coupon` char(1) DEFAULT NULL,
  `sign_type` varchar(32) DEFAULT NULL,
  `sign` varchar(50) DEFAULT NULL,
  `body` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `out_trade_no` (`out_trade_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='支付宝支付记录-alizi.net';

DROP TABLE IF EXISTS `alizi_article`;
CREATE TABLE `alizi_article` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(12) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL COMMENT '',
  `brief` text,
  `tags` varchar(100) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL COMMENT '',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `content` longtext NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `is_frozen` tinyint(1) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL COMMENT '',
  `add_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='产品表-alizi.net';

DROP TABLE IF EXISTS `alizi_category`;
CREATE TABLE `alizi_category` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '',
  `sort_order` mediumint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='产品分类表-alizi.net';

DROP TABLE IF EXISTS `alizi_comments`;
CREATE TABLE `alizi_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(12) NOT NULL,
  `name` varchar(25) NOT NULL,
  `content` text NOT NULL,
  `add_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表-alizi.net';

DROP TABLE IF EXISTS `alizi_item`;
CREATE TABLE `alizi_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(12) unsigned NOT NULL DEFAULT '1',
  `sn` varchar(15) NOT NULL,
  `category_id` int(12) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL COMMENT '',
  `brief` varchar(255) NOT NULL DEFAULT '',
  `tags` varchar(100) NOT NULL DEFAULT '',
  `original_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `price` decimal(12,2) NOT NULL COMMENT '价格',
  `salenum` int(12) NOT NULL DEFAULT '0',
  `qrcode_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '',
  `qrcode_pay_info` text,
  `qrcode` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `is_big` tinyint(1) NOT NULL DEFAULT '0' COMMENT '',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `params` text COMMENT '套餐属性',
  `params_type` enum('radio','select') DEFAULT 'select',
  `options` text,
  `extends` text,
  `content` longtext,
  `payment` varchar(255) DEFAULT '',
  `shipping_id` int(12) NOT NULL DEFAULT '0',
  `remark` text,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `is_sent` tinyint(1) NOT NULL DEFAULT '0',
  `is_auto_send` tinyint(1) NOT NULL DEFAULT '0' COMMENT '',
  `send_content` text,
  `sms_send` text,
  `timer` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL COMMENT '',
  `add_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`),
  KEY `title` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='产品表-alizi.net';

DROP TABLE IF EXISTS `alizi_item_template`;
CREATE TABLE `alizi_item_template` (
  `id` bigint(20) NOT NULL COMMENT '产品id',
  `template` varchar(25) NOT NULL COMMENT '',
  `options` text NOT NULL COMMENT '',
  `width` varchar(20) NOT NULL DEFAULT '1' COMMENT '',
  `show_notice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '',
  `show_comments` tinyint(1) NOT NULL DEFAULT '0',
  `info` text,
  `color` varchar(255) NOT NULL,
  `redirect_uri` varchar(255) DEFAULT NULL,
  `extend` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品模板表-alizi.net';


DROP TABLE IF EXISTS `alizi_order`;
CREATE TABLE `alizi_order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(12) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '',
  `order_no` varchar(25) NOT NULL COMMENT '',
  `channel_id` varchar(20) NOT NULL DEFAULT '',
  `item_id` int(12) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_params` varchar(255) NOT NULL COMMENT '',
  `item_extends` varchar(255) NOT NULL DEFAULT '',
  `item_price` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `order_price` decimal(12,2) NOT NULL,
  `shipping_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `quantity` mediumint(5) NOT NULL DEFAULT '1' COMMENT '',
  `datetime` datetime NOT NULL,
  `name` varchar(20) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `phone` varchar(20) NOT NULL DEFAULT '',
  `region` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(50) NOT NULL,
  `zcode` varchar(10) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL DEFAULT '',
  `remark` varchar(100) NOT NULL,
  `payment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '',
  `payment_num` varchar(20) NOT NULL,
  `delivery_name` varchar(20) NOT NULL COMMENT '',
  `delivery_no` varchar(25) NOT NULL COMMENT '',
  `device` tinyint(1) NOT NULL DEFAULT '1' COMMENT '',
  `add_ip` varchar(15) NOT NULL DEFAULT '',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `is_sent` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `add_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='产品订单表-alizi.net';

DROP TABLE IF EXISTS `alizi_order_log`;
CREATE TABLE `alizi_order_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '',
  `add_time` int(10) NOT NULL,
  `user_id` int(12) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='产品订单记录表-alizi.net';

DROP TABLE IF EXISTS `alizi_shipping`;
CREATE TABLE `alizi_shipping` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `less_num` tinyint(4) NOT NULL DEFAULT '1' COMMENT '',
  `less_num_cost` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `step_num` tinyint(3) NOT NULL DEFAULT '1' COMMENT '',
  `step_num_cost` decimal(10,2) NOT NULL DEFAULT '1.00' COMMENT '',
  `is_free_num` tinyint(1) NOT NULL DEFAULT '0',
  `is_free_cost` tinyint(1) NOT NULL DEFAULT '0',
  `free_num` mediumint(5) NOT NULL DEFAULT '0' COMMENT '',
  `free_cost` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='运费模板-alizi.net';

DROP TABLE IF EXISTS `alizi_user`;
CREATE TABLE `alizi_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(12) unsigned NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL COMMENT '',
  `password` char(32) NOT NULL COMMENT '',
  `role` enum('admin','member') NOT NULL DEFAULT 'admin' COMMENT '',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '',
  `mobile` varchar(15) NOT NULL,
  `qq` varchar(50) NOT NULL DEFAULT '' COMMENT '',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '',
  `info` mediumtext NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `login_ip` char(16) NOT NULL,
  `login_time` datetime NOT NULL,
  `create_time` int(10) NOT NULL COMMENT '',
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='产品用户表-alizi.net';



DROP TABLE IF EXISTS `alizi_setting`;
CREATE TABLE `alizi_setting` (
  `name` varchar(50) NOT NULL COMMENT '',
  `value` text NOT NULL COMMENT '',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品系统设置表-alizi.net';

-- ----------------------------
-- Records of alizi_setting
-- ----------------------------
INSERT INTO `alizi_setting` VALUES ('title', 'PHP订单管理系统');
INSERT INTO `alizi_setting` VALUES ('keywords', 'PHP订单管理系统');
INSERT INTO `alizi_setting` VALUES ('logo_pc', '');
INSERT INTO `alizi_setting` VALUES ('logo', '');
INSERT INTO `alizi_setting` VALUES ('description', 'PHP订单管理系统');
INSERT INTO `alizi_setting` VALUES ('footer', 'Copyright (c) 2016 <a href=\"http://www.010xr.com\"  target=\"_blank\">www.010xr.com</a> All Rights Reserved');
INSERT INTO `alizi_setting` VALUES ('contact_tel', '13800000000');
INSERT INTO `alizi_setting` VALUES ('contact_qq', '');
INSERT INTO `alizi_setting` VALUES ('system_status', '1');
INSERT INTO `alizi_setting` VALUES ('system_close_info', 'http://www.010xr.com');
INSERT INTO `alizi_setting` VALUES ('URL_MODEL', '0');
INSERT INTO `alizi_setting` VALUES ('theme_color', 'ED145B');
INSERT INTO `alizi_setting` VALUES ('system_template', 'thin');
INSERT INTO `alizi_setting` VALUES ('order_options', '[\"price\",\"quantity\",\"payment\",\"name\",\"mobile\",\"region\",\"address\",\"remark\"]');
INSERT INTO `alizi_setting` VALUES ('show_notice', '0');
INSERT INTO `alizi_setting` VALUES ('record_order', '0');
INSERT INTO `alizi_setting` VALUES ('repeat_order', '1');
INSERT INTO `alizi_setting` VALUES ('slider_show', '1');
INSERT INTO `alizi_setting` VALUES ('slider_num', '5');
INSERT INTO `alizi_setting` VALUES ('item_hot_show', '1');
INSERT INTO `alizi_setting` VALUES ('item_hot_num', '8');
INSERT INTO `alizi_setting` VALUES ('item_category_show', '1');
INSERT INTO `alizi_setting` VALUES ('item_category_num', '6');
INSERT INTO `alizi_setting` VALUES ('item_category_id', '1,2');
INSERT INTO `alizi_setting` VALUES ('show_header', '1');
INSERT INTO `alizi_setting` VALUES ('show_bottom_nav', '1');
INSERT INTO `alizi_setting` VALUES ('payment_global', '1');
INSERT INTO `alizi_setting` VALUES ('payOnDelivery_status', '1');
INSERT INTO `alizi_setting` VALUES ('payOnDelivery_fee', '0');
INSERT INTO `alizi_setting` VALUES ('payOnDelivery_info', '选择货到付款，安全放心');
INSERT INTO `alizi_setting` VALUES ('bankpay_status', '0');
INSERT INTO `alizi_setting` VALUES ('bankpay_discount', '0');
INSERT INTO `alizi_setting` VALUES ('bankpay_info', '请联系在线客服获取银行账号');
INSERT INTO `alizi_setting` VALUES ('alipay_status', '0');
INSERT INTO `alizi_setting` VALUES ('alipay_type', '[\"1\",\"2\",\"3\"]');
INSERT INTO `alizi_setting` VALUES ('alipay_mail', '');
INSERT INTO `alizi_setting` VALUES ('alipay_pid', '');
INSERT INTO `alizi_setting` VALUES ('alipay_key', '');
INSERT INTO `alizi_setting` VALUES ('alipay_discount', '1');
INSERT INTO `alizi_setting` VALUES ('alipay_discount_info', '支付宝万岁');
INSERT INTO `alizi_setting` VALUES ('wxpay_status', '1');
INSERT INTO `alizi_setting` VALUES ('wxpay_appid', 'wxd4c21c6036a8844b');
INSERT INTO `alizi_setting` VALUES ('wxpay_mchid', '1286703301');
INSERT INTO `alizi_setting` VALUES ('wxpay_key', '7686861380843208f9ca8552ab2d1044');
INSERT INTO `alizi_setting` VALUES ('wxpay_secret', 'ad84f25864bb7c489230df778016ca77');
INSERT INTO `alizi_setting` VALUES ('wxpay_type', '[\"1\"]');
INSERT INTO `alizi_setting` VALUES ('wxpay_discount', '1');
INSERT INTO `alizi_setting` VALUES ('wxpay_discount_info', '使用微信支付');
INSERT INTO `alizi_setting` VALUES ('mail_send', '0');
INSERT INTO `alizi_setting` VALUES ('mail_proxy', '0');
INSERT INTO `alizi_setting` VALUES ('mail_send_status', '[\"0\",\"1\",\"3\"]');
INSERT INTO `alizi_setting` VALUES ('mail_smtp', 'smtp.163.com');
INSERT INTO `alizi_setting` VALUES ('mail_port', '25');
INSERT INTO `alizi_setting` VALUES ('mail_account', '');
INSERT INTO `alizi_setting` VALUES ('mail_password', '');
INSERT INTO `alizi_setting` VALUES ('mail_to', 'admin@alizi.net');
INSERT INTO `alizi_setting` VALUES ('mail_title', '[AliziStatus]：[AliziTitle]');
INSERT INTO `alizi_setting` VALUES ('sms_send', '0');
INSERT INTO `alizi_setting` VALUES ('sms_admin', '0');
INSERT INTO `alizi_setting` VALUES ('sms_admin_mobile', '');
INSERT INTO `alizi_setting` VALUES ('sms_account', '');
INSERT INTO `alizi_setting` VALUES ('sms_password', '');
INSERT INTO `alizi_setting` VALUES ('weixin_status', '0');
INSERT INTO `alizi_setting` VALUES ('weixin_appid', '');
INSERT INTO `alizi_setting` VALUES ('weixin_appsecret', '');
INSERT INTO `alizi_setting` VALUES ('weixin_token', '');
INSERT INTO `alizi_setting` VALUES ('weixin_encodingaeskey', '');
INSERT INTO `alizi_setting` VALUES ('safe_mobile_limit', '20');
INSERT INTO `alizi_setting` VALUES ('safe_order_interval', '20');
INSERT INTO `alizi_setting` VALUES ('safe_ip_limit', '50');
INSERT INTO `alizi_setting` VALUES ('safe_ip_denied', '');