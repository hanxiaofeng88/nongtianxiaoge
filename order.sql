/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : order

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-04-23 15:55:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for alizi_advert
-- ----------------------------
DROP TABLE IF EXISTS `alizi_advert`;
CREATE TABLE `alizi_advert` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `target` enum('_blank','_self') NOT NULL,
  `description` mediumtext NOT NULL,
  `sort_order` mediumint(5) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL,
  `type` enum('幻灯片','广告') NOT NULL DEFAULT '幻灯片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='广告幻灯片表-alizi.net';

-- ----------------------------
-- Records of alizi_advert
-- ----------------------------
INSERT INTO `alizi_advert` VALUES ('1', '0', '云南贡茶', '/201509/56bf544bdb9cd.jpg', '/201509/5607ef1848e42.jpg', 'javascript:;', '1', '_self', '', '0', '1443360670', '幻灯片');
INSERT INTO `alizi_advert` VALUES ('2', '0', '台湾美食', '/201509/56bf54a7f3738.jpg', '/201509/5607ef23d8713.jpg', 'javascript:;', '1', '_self', '', '0', '1443360670', '幻灯片');

-- ----------------------------
-- Table structure for alizi_alipay_log
-- ----------------------------
DROP TABLE IF EXISTS `alizi_alipay_log`;
CREATE TABLE `alizi_alipay_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pay_type` tinyint(1) NOT NULL DEFAULT '1',
  `discount` mediumint(5) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `trade_no` varchar(64) NOT NULL,
  `buyer_email` varchar(32) DEFAULT NULL,
  `gmt_create` datetime DEFAULT NULL,
  `notify_type` varchar(50) DEFAULT NULL,
  `quantity` mediumint(5) DEFAULT NULL,
  `out_trade_no` varchar(32) NOT NULL,
  `seller_id` varchar(30) DEFAULT NULL,
  `notify_time` datetime NOT NULL,
  `trade_status` varchar(50) NOT NULL DEFAULT '',
  `is_total_fee_adjust` char(1) DEFAULT NULL,
  `total_fee` decimal(8,2) NOT NULL,
  `gmt_payment` datetime DEFAULT NULL,
  `seller_email` varchar(32) NOT NULL DEFAULT '',
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

-- ----------------------------
-- Records of alizi_alipay_log
-- ----------------------------

-- ----------------------------
-- Table structure for alizi_article
-- ----------------------------
DROP TABLE IF EXISTS `alizi_article`;
CREATE TABLE `alizi_article` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(12) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `brief` text,
  `tags` varchar(100) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `is_frozen` tinyint(1) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL,
  `add_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='产品表-alizi.net';

-- ----------------------------
-- Records of alizi_article
-- ----------------------------
INSERT INTO `alizi_article` VALUES ('1', '3', 'PHP订单系统', '1、自适应电脑和手机界面，不必再多此一举区分两个版本。\n2、独立后台方便管理，产品可在后台上传修改，订单可导出Excel表。\n3、集成多种支付方式：①支付宝即时到账；②微信支付；③个人二维码付款；④货到付款；⑤银行转账。\n4、精美的模板，非市面上粗俗烂作的模板与之可比；模板可随意切换且能自定义样式，让您的页面总是与众不同。\n5、防刷单防丢单，邮件即时通知。\n6、可计算运费，设置推广渠道，物流查询等等……', '', '/201509/56e2dad3193a5.jpg', '1', '0', '<p><span style=\"font-family:&#39;Microsoft YaHei&#39;, tahoma, Simsun, &#39;Arial Unicode MS&#39;, Mingliu, Arial, Helvetica;font-size:18px;line-height:2;\">1、自适应电脑和手机界面，不必再多此一举区分两个版本。</span><br/><span style=\"font-family:&#39;Microsoft YaHei&#39;, tahoma, Simsun, &#39;Arial Unicode MS&#39;, Mingliu, Arial, Helvetica;font-size:18px;line-height:2;\">2、独立后台方便管理，产品可在后台上传修改，订单可导出Excel表。</span><br/><span style=\"font-family:&#39;Microsoft YaHei&#39;, tahoma, Simsun, &#39;Arial Unicode MS&#39;, Mingliu, Arial, Helvetica;font-size:18px;line-height:2;\">3、集成多种支付方式：①支付宝即时到账；②微信支付；③个人二维码付款；</span><span style=\"font-family:&#39;Microsoft YaHei&#39;, tahoma, Simsun, &#39;Arial Unicode MS&#39;, Mingliu, Arial, Helvetica;font-size:18px;line-height:2;\">④货到付款；⑤银行转账。</span><br/><span style=\"font-family:&#39;Microsoft YaHei&#39;, tahoma, Simsun, &#39;Arial Unicode MS&#39;, Mingliu, Arial, Helvetica;font-size:18px;line-height:2;\">4、精美的模板，非市面上粗俗烂作的模板与之可比；</span><span style=\"font-family:&#39;Microsoft YaHei&#39;, tahoma, Simsun, &#39;Arial Unicode MS&#39;, Mingliu, Arial, Helvetica;font-size:18px;line-height:2;\">模板可随意切换且能自定义样式，让您的页面总是与众不同。</span><br/><span style=\"font-family:&#39;Microsoft YaHei&#39;, tahoma, Simsun, &#39;Arial Unicode MS&#39;, Mingliu, Arial, Helvetica;font-size:18px;line-height:2;\">5、防刷单防丢单，邮件即时通知。</span><br/><span style=\"font-family:&#39;Microsoft YaHei&#39;, tahoma, Simsun, &#39;Arial Unicode MS&#39;, Mingliu, Arial, Helvetica;font-size:18px;line-height:2;\">6、可计算运费，设置推广渠道，物流查询等等……</span></p>', '0', '0', '1555555295', '1459236989');
INSERT INTO `alizi_article` VALUES ('2', '3', 'test', '测试', '测试', '', '1', '0', '<p><span style=\"color: rgb(34, 34, 34); font-family: Consolas, \" lucida=\"\" courier=\"\" white-space:=\"\">btn-qrcode</span></p>', '0', '0', '1555555269', '1555555254');

-- ----------------------------
-- Table structure for alizi_category
-- ----------------------------
DROP TABLE IF EXISTS `alizi_category`;
CREATE TABLE `alizi_category` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` mediumint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='产品分类表-alizi.net';

-- ----------------------------
-- Records of alizi_category
-- ----------------------------
INSERT INTO `alizi_category` VALUES ('1', '特产美食', '1', '0');
INSERT INTO `alizi_category` VALUES ('2', '精美礼品', '1', '0');
INSERT INTO `alizi_category` VALUES ('3', '关于阿狸子', '2', '0');

-- ----------------------------
-- Table structure for alizi_comments
-- ----------------------------
DROP TABLE IF EXISTS `alizi_comments`;
CREATE TABLE `alizi_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(12) NOT NULL,
  `name` varchar(25) NOT NULL,
  `content` text NOT NULL,
  `add_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表-alizi.net';

-- ----------------------------
-- Records of alizi_comments
-- ----------------------------

-- ----------------------------
-- Table structure for alizi_item
-- ----------------------------
DROP TABLE IF EXISTS `alizi_item`;
CREATE TABLE `alizi_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(12) unsigned NOT NULL DEFAULT '1',
  `sn` varchar(15) NOT NULL,
  `category_id` int(12) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `brief` varchar(255) NOT NULL DEFAULT '',
  `tags` varchar(100) NOT NULL DEFAULT '',
  `original_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `price` decimal(12,2) NOT NULL COMMENT '价格',
  `salenum` int(12) NOT NULL DEFAULT '0',
  `qrcode_pay` tinyint(1) NOT NULL DEFAULT '0',
  `qrcode_pay_info` text,
  `qrcode` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `is_big` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
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
  `is_auto_send` tinyint(1) NOT NULL DEFAULT '0',
  `send_content` text,
  `sms_send` text,
  `timer` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL,
  `add_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`),
  KEY `title` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='产品表-alizi.net';

-- ----------------------------
-- Records of alizi_item
-- ----------------------------
INSERT INTO `alizi_item` VALUES ('1', '2', '1uaXmYzy', '1', '古早味黑糖沙琪玛', '纯手工制作 始于1984年的味道', '推荐#传统手工制作', '0.00', '1.00', '19', '1', '请打开微信二维码扫描支付', '/201904/5cbeb68b3ae74.jpg', '/201509/5608077d63901.jpg', '', '1', '0', '0', '0', '[{\"title\":\"\\u7ea2\\u7cd6\\u6c99\\u742a\\u739b\",\"price\":\"15\",\"image\":\"\",\"qrcode\":\"\\/201904\\/5cbeb68b3ae74.jpg\"}]', 'radio', '', '[{\"title\":\"\\u9009\\u62e9\\u989c\\u8272\",\"value\":\"\\u7ea2\\u8272#\\u767d\\u8272#\\u7d2b\\u8272\",\"type\":\"radio\"}]', '<p>\r\n	<img alt=\"\" src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010135822_53493.jpg\"/><img alt=\"\" src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010135826_20535.jpg\"/><img alt=\"\" src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010135829_32518.jpg\"/> </p><p>{[AliziOrder]}<br/></p>', '', '0', '', '0', '0', '0', '', 'null', '0', '1556002468', '1443181406');
INSERT INTO `alizi_item` VALUES ('2', '1', '2uaXmYzy', '2', '东港杏仁夹心海苔', '台湾风味 香脆可口 小朋友最爱', '纯天然#香脆可口', '0.00', '0.01', '65', '0', '请使用微信扫描二维码进行支付<br>这是说明信息', '/201510/562ce2f947edd.png', '/201509/56080d00b7b11.jpg', '/201509/56080d00b7b11.jpg', '1', '0', '0', '0', '[{\"title\":\"250g\\u5305\\u88c5\",\"price\":\"10\",\"image\":\"\",\"qrcode\":\"\\/201510\\/562ce2f947edd.png\"},{\"title\":\"500g\\u5305\\u88c5\",\"price\":\"20\",\"image\":\"\",\"qrcode\":\"\\/201510\\/562ce2f947edd.png\"}]', 'radio', '', '[{\"title\":\"\\u5957\\u9910\\u9009\\u62e9\",\"value\":\"\\u301001\\u3011\\u9177\\u777f\\u9ed1#\\u301002\\u3011\\u72c2\\u91ce\\u6a59#\\u301003\\u3011\\u4f18\\u96c5\\u767d#\\u301004\\u3011\\u9999\\u69df\\u91d1\",\"type\":\"radio\"}]', '<p>\r\n	<img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010135936_37956.jpg\" alt=\"\"/><img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010135945_51764.jpg\" alt=\"\"/><img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010135950_61870.jpg\" alt=\"\"/> </p><h2>\r\n	订购说明</h2><p>{[AliziOrder]}</p>', '', '0', '', '0', '0', '0', '这是自动发货内容\r\nwww.010xr.com', 'null', '3600', '1464066860', '1443368205');
INSERT INTO `alizi_item` VALUES ('3', '1', 'u3aXmYzy', '1', '补气血黑糖玫瑰四物', '台湾进口-调经补血-四物饮', '推荐#满100元免运费', '0.00', '23.00', '9', '0', '', '', '/201509/56080e15a27f3.jpg', '', '1', '0', '0', '0', '[]', 'radio', '', '[{\"title\":\"\\u9009\\u62e9\\u989c\\u8272\",\"value\":\"\\u7ea2\\u8272#\\u767d\\u8272#\\u7d2b\\u8272\",\"type\":\"checkbox\"}]', '<p>\r\n	<img alt=\"\" src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010140114_75095.jpg\"/> </p><p>\r\n	<br/></p><p>\r\n	<img alt=\"\" src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010140110_73688.jpg\"/><img alt=\"\" src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010140120_41243.jpg\"/> </p><p>\r\n	<span>&nbsp;{[AliziOrder]}</span> </p>', '', '0', '', '0', '0', '1', 'alizi.net\r\n这是自动发货信息\r\n\r\n', 'null', '86500', '1464067026', '1443368471');
INSERT INTO `alizi_item` VALUES ('4', '1', '4uaXmYzy', '2', '2015年新货 吐鲁番野生黑桑椹干', '2015新货 特级黑桑葚子 新疆特产', '新疆特产#天然食品', '0.00', '32.00', '0', '0', '', '', '/201509/56081c9aae76b.jpg', '', '1', '0', '0', '0', '[]', 'radio', '', '', '<p>\r\n	<img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010140507_52499.jpg\" alt=\"\"/><img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010140516_25149.jpg\" alt=\"\"/><img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010140524_14560.jpg\" alt=\"\"/> </p><p>\r\n	&nbsp;{[AliziOrder]}</p>', '', '0', '', '0', '0', '0', '', 'null', '0', '1464067125', '1443372198');
INSERT INTO `alizi_item` VALUES ('5', '1', '5uaXmYzy', '2', '和田大马士革玫瑰花', '无任何加工 药用品质', '满100元免运费#25元起售', '0.00', '25.00', '1291', '0', '', '/201510/562ce2f947edd.png', '/201509/56081cbf499f2.jpg', '', '1', '0', '0', '0', '[]', 'radio', '', '[{\"title\":\"\\u5fae\\u4fe1\\u6635\\u79f0\",\"value\":\"\\u6ce8\\u610f\\u662f\\u3010\\u5fae\\u4fe1\\u6635\\u79f0\\u3011\\u800c\\u4e0d\\u662f\\u5fae\\u4fe1\\u8d26\\u53f7\",\"type\":\"text\"}]', '<p><br/></p><h2>商品描述</h2><p>\r\n	<img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010135602_46221.jpg\" alt=\"\"/> </p><p>\r\n	<br/></p><p>\r\n	<img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010135620_39002.jpg\" alt=\"\"/> </p><p>\r\n	<br/></p><p>\r\n	<img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010135720_94870.jpg\" alt=\"\"/> </p><p><br/></p><h2>在线下单</h2><p>\r\n	{[AliziOrder]}</p>', '', '0', '\r\n<script src=\"http://hm.baidu.com/hm.js?58d0df5a2df91e0d74f6d2b371edebda\"></script>', '0', '0', '0', '自动发货\r\nwww.010xr.com', 'null', '0', '1466670235', '1443372229');
INSERT INTO `alizi_item` VALUES ('6', '2', '6uaXmYzy', '1', '阿克苏温185纸皮核桃sms1', '2015新货 个大壳薄 无任何添加', '原味生核桃#限时抢购', '66.00', '55.00', '21', '0', '', '', '/201509/56081cda457b4.jpg', '', '1', '0', '0', '0', '[{\"title\":\"\\u9999\\u69df\\u91d1\",\"price\":\"540\",\"image\":\"\",\"qrcode\":\"\"},{\"title\":\"\\u5496\\u5561\\u8272\",\"price\":\"100\",\"image\":\"\",\"qrcode\":\"\"}]', 'radio', '', '[{\"title\":\"\\u5c3a\\u7801\",\"value\":\" S\\/165\\uff08\\u9002\\u5408100\\u65a4-125\\u65a4\\uff09# M\\/170\\uff08\\u9002\\u5408125\\u65a4-140\\u65a4\\uff09# L\\/175\\uff08\\u9002\\u5408140\\u65a4-155\\u65a4\\uff09#XL\\/180\\uff08\\u9002\\u5408155\\u65a4-170\\u65a4\\uff09\",\"type\":\"checkbox\"},{\"title\":\"\\u989c\\u8272\",\"value\":\"\\u7ea2\\u8272#\\u767d\\u8272#\\u7d2b\\u8272\",\"type\":\"radio\"},{\"title\":\"\\u5f71\\u7247\\u7f16\\u53f7\",\"value\":\"\",\"type\":\"text\"}]', '<p>\n	<span style=\"color:#333333;font-family:Arial, Helvetica, sans-serif，, 宋体;line-height:25px;background-color:#FFFFFF;\">&nbsp;<a href=\"#aliziOrder\" class=\"alizi-btn\">立即下单</a><img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010140356_49453.jpg\" alt=\"\"/><img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010140409_83321.jpg\" alt=\"\"/><img src=\"http://alizi.5hi.cn/Public/Uploads/201510/20151010140415_33013.jpg\" alt=\"\"/></span> </p><p>{[AliziOrder]}</p><p><br/></p>', '', '0', '', '0', '0', '0', '', 'null', '10', '1555999048', '1443372259');
INSERT INTO `alizi_item` VALUES ('7', '2', '1p7LSu3a', '1', 'test', '', '', '1.00', '0.01', '22', '1', '', '/201904/5cb7e8c6a98f7.jpg', '/201904/5cbab5b7c0317.jpg', '/201904/5cbab5b7c0317.jpg', '1', '0', '0', '0', '[]', 'radio', null, '[{\"title\":\"1\",\"value\":\"1\",\"type\":\"text\"}]', '<p><img src=\"http://dingdan.com/Public/Uploads/201904/15557454679009.jpg\" _src=\"http://dingdan.com/Public/Uploads/201904/15557454679009.jpg\"/>ad</p>', '', '0', '', '0', '0', '0', '', 'null', '0', '1555745474', '1555554234');
INSERT INTO `alizi_item` VALUES ('8', '2', 'ntxg001', '1', '钱排三华李', '', '', '49.00', '36.00', '13', '1', '', '/201904/5cbeb6f8520b0.jpg', '', '', '1', '0', '0', '0', '[{\"title\":\"3\\u65a4\",\"price\":\"36\",\"image\":\"\",\"qrcode\":\"\\/201904\\/5cbeb6f8520b0.jpg\"},{\"title\":\"5\\u65a4\",\"price\":\"68\",\"image\":\"\",\"qrcode\":\"\\/201904\\/5cbeb6f8520b0.jpg\"},{\"title\":\"10\\u65a4\",\"price\":\"119\",\"image\":\"\",\"qrcode\":\"\\/201904\\/5cbeb6f8520b0.jpg\"}]', 'radio', null, '', '<p>dfdf&nbsp;</p>', '', '0', '', '0', '0', '0', '', 'null', '1', '1556002562', '1555999497');

-- ----------------------------
-- Table structure for alizi_item_template
-- ----------------------------
DROP TABLE IF EXISTS `alizi_item_template`;
CREATE TABLE `alizi_item_template` (
  `id` bigint(20) NOT NULL COMMENT '产品id',
  `template` varchar(25) NOT NULL,
  `options` text NOT NULL,
  `width` varchar(20) NOT NULL DEFAULT '1',
  `show_notice` tinyint(1) NOT NULL DEFAULT '0',
  `show_comments` tinyint(1) NOT NULL DEFAULT '0',
  `info` text,
  `color` varchar(255) NOT NULL,
  `redirect_uri` varchar(255) DEFAULT NULL,
  `extend` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品模板表-alizi.net';

-- ----------------------------
-- Records of alizi_item_template
-- ----------------------------
INSERT INTO `alizi_item_template` VALUES ('7', 'thin', '[\"quantity\",\"price\",\"datetime\",\"name\",\"mobile\",\"region\",\"address\",\"remark\",\"payment\"]', '750px', '0', '0', '', '{\"body_bg\":\"F1F1F1\",\"form_bg\":\"FFFFFF\",\"title_bg\":\"666666\",\"button_bg\":\"EE3300\",\"font\":\"333333\",\"border\":\"666666\",\"nav_bg\":\"EE3300\"}', '', 'a:3:{s:7:\"padding\";s:1:\"0\";s:10:\"bottom_nav\";s:1:\"0\";s:15:\"bottom_nav_list\";a:3:{i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";}}');
INSERT INTO `alizi_item_template` VALUES ('8', 'thin', '[\"quantity\",\"price\",\"datetime\",\"name\",\"mobile\",\"region\",\"address\",\"remark\",\"payment\"]', '750px', '0', '0', '', '{\"body_bg\":\"F1F1F1\",\"form_bg\":\"FFFFFF\",\"title_bg\":\"666666\",\"button_bg\":\"EE3300\",\"font\":\"333333\",\"border\":\"666666\",\"nav_bg\":\"EE3300\"}', '', 'a:3:{s:7:\"padding\";s:1:\"0\";s:10:\"bottom_nav\";s:1:\"0\";s:15:\"bottom_nav_list\";a:3:{i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";}}');

-- ----------------------------
-- Table structure for alizi_order
-- ----------------------------
DROP TABLE IF EXISTS `alizi_order`;
CREATE TABLE `alizi_order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(12) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `order_no` varchar(25) NOT NULL,
  `channel_id` varchar(20) NOT NULL DEFAULT '',
  `item_id` int(12) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_params` varchar(255) NOT NULL,
  `item_extends` varchar(255) NOT NULL DEFAULT '',
  `item_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `order_price` decimal(12,2) NOT NULL,
  `shipping_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `quantity` mediumint(5) NOT NULL DEFAULT '1',
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
  `payment` tinyint(1) NOT NULL DEFAULT '1',
  `payment_num` varchar(20) NOT NULL,
  `delivery_name` varchar(20) NOT NULL,
  `delivery_no` varchar(25) NOT NULL,
  `device` tinyint(1) NOT NULL DEFAULT '1',
  `add_ip` varchar(15) NOT NULL DEFAULT '',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `is_sent` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `add_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='产品订单表-alizi.net';

-- ----------------------------
-- Records of alizi_order
-- ----------------------------
INSERT INTO `alizi_order` VALUES ('1', '0', '0', '190418774121', '', '6', '阿克苏温185纸皮核桃sms', '香槟金', '{\"\\u5c3a\\u7801\":[\" S\\/165\\uff08\\u9002\\u5408100\\u65a4-125\\u65a4\\uff09\",\"XL\\/180\\uff08\\u9002\\u5408155\\u65a4-170\\u65a4\\uff09\"],\"\\u989c\\u8272\":\"\\u7ea2\\u8272\",\"\\u5f71\\u7247\\u7f16\\u53f7\":\"542\"}', '55.00', '50.00', '0.00', '50.00', '1', '0000-00-00 00:00:00', '410', '13071644032', '', '广东省 广州市 荔湾区', '410', '', '', '', '14', '3', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=6uaXmYzy', 'http://dingdan.com/index.php?m=Item&a=index', '1555553507', '0');
INSERT INTO `alizi_order` VALUES ('2', '0', '0', '190418486846', '', '6', '阿克苏温185纸皮核桃sms', '香槟金', '{\"\\u5c3a\\u7801\":[\" S\\/165\\uff08\\u9002\\u5408100\\u65a4-125\\u65a4\\uff09\",\"XL\\/180\\uff08\\u9002\\u5408155\\u65a4-170\\u65a4\\uff09\"],\"\\u989c\\u8272\":\"\\u7ea2\\u8272\",\"\\u5f71\\u7247\\u7f16\\u53f7\":\"14\"}', '55.00', '50.00', '0.00', '50.00', '1', '0000-00-00 00:00:00', '14', '13071606344', '', '河南省 郑州市 中原区', '141414', '', '', '', '14', '3', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=6uaXmYzy', 'http://dingdan.com/index.php?m=Item&a=index', '1555553545', '0');
INSERT INTO `alizi_order` VALUES ('3', '0', '4', '190418239528', '', '6', '阿克苏温185纸皮核桃sms', '香槟金', '{\"\\u5c3a\\u7801\":[\" S\\/165\\uff08\\u9002\\u5408100\\u65a4-125\\u65a4\\uff09\"],\"\\u989c\\u8272\":\"\\u7ea2\\u8272\",\"\\u5f71\\u7247\\u7f16\\u53f7\":\"pop;\"}', '55.00', '50.00', '0.00', '50.00', '1', '0000-00-00 00:00:00', 'kdsd', '13721606032', '', '河南省 郑州市 中原区', 'efdfgfg', '', '', '', 'fdfgdg', '1', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=6uaXmYzy', 'http://dingdan.com/index.php?m=Item&a=index', '1555553600', '1555740253');
INSERT INTO `alizi_order` VALUES ('4', '0', '7', '190418518700', '', '6', '阿克苏温185纸皮核桃sms', '香槟金', '{\"\\u5c3a\\u7801\":[\" S\\/165\\uff08\\u9002\\u5408100\\u65a4-125\\u65a4\\uff09\"],\"\\u989c\\u8272\":\"\\u7ea2\\u8272\",\"\\u5f71\\u7247\\u7f16\\u53f7\":\"jh\"}', '55.00', '50.00', '0.00', '50.00', '1', '0000-00-00 00:00:00', 'jfdfdsf', '13721606032', '', '湖北省 武汉市 江岸区', 'wdljkl', '', '', '', 'fdsf', '1', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=6uaXmYzy', 'http://dingdan.com/index.php?m=Order&a=pay&order_no=190418239528', '1555553683', '1555739827');
INSERT INTO `alizi_order` VALUES ('5', '0', '0', '190423304584', '', '6', '阿克苏温185纸皮核桃sms1', '香槟金', '{\"\\u5c3a\\u7801\":[\" S\\/165\\uff08\\u9002\\u5408100\\u65a4-125\\u65a4\\uff09\",\" M\\/170\\uff08\\u9002\\u5408125\\u65a4-140\\u65a4\\uff09\"],\"\\u989c\\u8272\":\"\\u767d\\u8272\",\"\\u5f71\\u7247\\u7f16\\u53f7\":\"hgghjhgjghj\"}', '55.00', '540.00', '0.00', '540.00', '1', '0000-00-00 00:00:00', 'kjh', '13071606032', '', '广东省 广州市 荔湾区', 'hgjh', '', '', '', '', '1', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Index&a=order&id=6uaXmYzy', 'http://dingdan.com/', '1555985848', '0');
INSERT INTO `alizi_order` VALUES ('6', '0', '0', '190423725505', '', '6', '阿克苏温185纸皮核桃sms1', '香槟金', '{\"\\u5c3a\\u7801\":[\" S\\/165\\uff08\\u9002\\u5408100\\u65a4-125\\u65a4\\uff09\",\" M\\/170\\uff08\\u9002\\u5408125\\u65a4-140\\u65a4\\uff09\"],\"\\u989c\\u8272\":\"\\u767d\\u8272\",\"\\u5f71\\u7247\\u7f16\\u53f7\":\"101\"}', '55.00', '540.00', '0.00', '540.00', '1', '0000-00-00 00:00:00', '101', '13074909606', '', '北京市 市辖区 东城区', '141222222', '', '', '', '', '1', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Index&a=order&id=6uaXmYzy', 'http://dingdan.com/index.php?m=Index&a=category', '1556001831', '0');
INSERT INTO `alizi_order` VALUES ('7', '0', '0', '190423552400', '', '1', '古早味黑糖沙琪玛', '黑糖沙琪玛', '{\"\\u9009\\u62e9\\u989c\\u8272\":\"\\u7ea2\\u8272\"}', '1.00', '12.00', '0.00', '12.00', '1', '0000-00-00 00:00:00', '101', '13074909606', '', '北京市 市辖区 东城区', '141222222', '', '', '', '', '5', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Index&a=order&id=1uaXmYzy', 'http://dingdan.com/', '1556002157', '0');
INSERT INTO `alizi_order` VALUES ('8', '0', '0', '190423629727', '', '1', '古早味黑糖沙琪玛', '黑糖沙琪玛', '{\"\\u9009\\u62e9\\u989c\\u8272\":\"\\u7ea2\\u8272\"}', '1.00', '12.00', '0.00', '12.00', '1', '0000-00-00 00:00:00', '101', '13074909606', '', '北京市 市辖区 东城区', '141222222', '', '', '', '', '5', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=1uaXmYzy', 'http://dingdan.com/index.php?m=Item&a=index', '1556002199', '0');
INSERT INTO `alizi_order` VALUES ('9', '0', '0', '190423745348', '', '1', '古早味黑糖沙琪玛', '红糖沙琪玛', '{\"\\u9009\\u62e9\\u989c\\u8272\":\"\\u7ea2\\u8272\"}', '1.00', '15.00', '0.00', '15.00', '1', '0000-00-00 00:00:00', '101', '13074909606', '', '北京市 市辖区 东城区', '141222222', '', '', '', '', '5', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=1uaXmYzy', 'http://dingdan.com/index.php?m=Item&a=index', '1556002223', '0');
INSERT INTO `alizi_order` VALUES ('10', '0', '0', '190423997850', '', '1', '古早味黑糖沙琪玛', '黑糖沙琪玛', '{\"\\u9009\\u62e9\\u989c\\u8272\":\"\\u7ea2\\u8272\"}', '1.00', '12.00', '0.00', '12.00', '1', '0000-00-00 00:00:00', '101', '13074909606', '', '北京市 市辖区 东城区', '141222222', '', '', '', '', '5', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=1uaXmYzy', 'http://dingdan.com/index.php?m=Item&a=index', '1556002327', '0');
INSERT INTO `alizi_order` VALUES ('11', '0', '0', '190423650383', '', '1', '古早味黑糖沙琪玛', '红糖沙琪玛', '{\"\\u9009\\u62e9\\u989c\\u8272\":\"\\u7ea2\\u8272\"}', '1.00', '15.00', '0.00', '15.00', '1', '0000-00-00 00:00:00', '101', '13074909606', '', '北京市 市辖区 东城区', '141222222', '', '', '', '', '5', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=1uaXmYzy', 'http://dingdan.com/index.php?m=Order&a=pay&order_no=190423997850', '1556002374', '0');
INSERT INTO `alizi_order` VALUES ('12', '0', '0', '190423165676', '', '1', '古早味黑糖沙琪玛', '黑糖沙琪玛', '{\"\\u9009\\u62e9\\u989c\\u8272\":\"\\u7ea2\\u8272\"}', '1.00', '12.00', '0.00', '12.00', '1', '0000-00-00 00:00:00', '101', '13074909606', '', '北京市 市辖区 东城区', '141222222', '', '', '', '', '5', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=1uaXmYzy', 'http://dingdan.com/index.php?m=Order&a=pay&order_no=190423650383', '1556002409', '0');
INSERT INTO `alizi_order` VALUES ('13', '0', '0', '190423675685', '', '1', '古早味黑糖沙琪玛', '红糖沙琪玛', '{\"\\u9009\\u62e9\\u989c\\u8272\":\"\\u7ea2\\u8272\"}', '1.00', '15.00', '0.00', '15.00', '1', '0000-00-00 00:00:00', '101', '13074909606', '', '北京市 市辖区 东城区', '141222222', '', '', '', '', '5', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=1uaXmYzy', 'http://dingdan.com/index.php?m=Order&a=pay&order_no=190423165676', '1556002455', '0');
INSERT INTO `alizi_order` VALUES ('14', '0', '0', '190423572256', '', '1', '古早味黑糖沙琪玛', '红糖沙琪玛', '{\"\\u9009\\u62e9\\u989c\\u8272\":\"\\u7ea2\\u8272\"}', '1.00', '15.00', '0.00', '15.00', '1', '0000-00-00 00:00:00', '101', '13074909606', '', '北京市 市辖区 东城区', '141222222', '', '', '', '', '5', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Item&a=order&id=1uaXmYzy', 'http://dingdan.com/index.php?m=Order&a=pay&order_no=190423675685', '1556002480', '0');
INSERT INTO `alizi_order` VALUES ('15', '0', '0', '190423751466', '', '8', '钱排三华李', '3斤', 'null', '36.00', '36.00', '0.00', '36.00', '1', '0000-00-00 00:00:00', '101', '13074909606', '', '北京市 市辖区 东城区', '141222222', '', '', '', 'csdf', '5', '', '', '', '1', '127.0.0.1', '0', '0', 'http://dingdan.com/index.php?m=Index&a=order&id=ntxg001', 'http://dingdan.com/index.php?m=Index&a=category', '1556002570', '0');

-- ----------------------------
-- Table structure for alizi_order_log
-- ----------------------------
DROP TABLE IF EXISTS `alizi_order_log`;
CREATE TABLE `alizi_order_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `add_time` int(10) NOT NULL,
  `user_id` int(12) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='产品订单记录表-alizi.net';

-- ----------------------------
-- Records of alizi_order_log
-- ----------------------------
INSERT INTO `alizi_order_log` VALUES ('1', '1', '0', '1555553507', '0', '14');
INSERT INTO `alizi_order_log` VALUES ('2', '2', '0', '1555553545', '0', '14');
INSERT INTO `alizi_order_log` VALUES ('3', '3', '0', '1555553600', '0', 'fdfgdg');
INSERT INTO `alizi_order_log` VALUES ('4', '4', '0', '1555553683', '0', 'fdsf');
INSERT INTO `alizi_order_log` VALUES ('5', '4', '3', '1555739005', '2', '');
INSERT INTO `alizi_order_log` VALUES ('6', '3', '1', '1555739703', '2', 'sad ');
INSERT INTO `alizi_order_log` VALUES ('7', '4', '4', '1555739817', '2', 'd ');
INSERT INTO `alizi_order_log` VALUES ('8', '4', '7', '1555739827', '2', '');
INSERT INTO `alizi_order_log` VALUES ('9', '3', '3', '1555740244', '2', '都');
INSERT INTO `alizi_order_log` VALUES ('10', '3', '4', '1555740253', '2', '是的撒');
INSERT INTO `alizi_order_log` VALUES ('11', '5', '0', '1555985848', '0', '');
INSERT INTO `alizi_order_log` VALUES ('12', '6', '0', '1556001831', '0', '');
INSERT INTO `alizi_order_log` VALUES ('13', '7', '0', '1556002157', '0', '');
INSERT INTO `alizi_order_log` VALUES ('14', '8', '0', '1556002199', '0', '');
INSERT INTO `alizi_order_log` VALUES ('15', '9', '0', '1556002223', '0', '');
INSERT INTO `alizi_order_log` VALUES ('16', '10', '0', '1556002327', '0', '');
INSERT INTO `alizi_order_log` VALUES ('17', '11', '0', '1556002374', '0', '');
INSERT INTO `alizi_order_log` VALUES ('18', '12', '0', '1556002409', '0', '');
INSERT INTO `alizi_order_log` VALUES ('19', '13', '0', '1556002455', '0', '');
INSERT INTO `alizi_order_log` VALUES ('20', '14', '0', '1556002480', '0', '');
INSERT INTO `alizi_order_log` VALUES ('21', '15', '0', '1556002570', '0', 'csdf');

-- ----------------------------
-- Table structure for alizi_setting
-- ----------------------------
DROP TABLE IF EXISTS `alizi_setting`;
CREATE TABLE `alizi_setting` (
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品系统设置表-alizi.net';

-- ----------------------------
-- Records of alizi_setting
-- ----------------------------
INSERT INTO `alizi_setting` VALUES ('title', '农田小哥订单管理系统');
INSERT INTO `alizi_setting` VALUES ('keywords', '农田小哥订单管理系统');
INSERT INTO `alizi_setting` VALUES ('logo_pc', '/201904/5cbead3200ffa.jpg');
INSERT INTO `alizi_setting` VALUES ('logo', '/201904/5cbead3200ffa.jpg');
INSERT INTO `alizi_setting` VALUES ('description', '农田小哥订单管理系统');
INSERT INTO `alizi_setting` VALUES ('footer', 'Copyright (c) 2019 <a href=\"www.nongtianxiaoge.com\"  target=\"_blank\">www.nongtianxiaoge.com</a> All Rights Reserved');
INSERT INTO `alizi_setting` VALUES ('contact_tel', '13800000000');
INSERT INTO `alizi_setting` VALUES ('contact_qq', '');
INSERT INTO `alizi_setting` VALUES ('system_status', '1');
INSERT INTO `alizi_setting` VALUES ('system_close_info', 'http://www.nongtianxiaoge.com');
INSERT INTO `alizi_setting` VALUES ('URL_MODEL', '2');
INSERT INTO `alizi_setting` VALUES ('theme_color', 'ED165A');
INSERT INTO `alizi_setting` VALUES ('system_template', 'thin');
INSERT INTO `alizi_setting` VALUES ('order_options', '[\"price\",\"quantity\",\"payment\",\"name\",\"mobile\",\"region\",\"address\",\"remark\"]');
INSERT INTO `alizi_setting` VALUES ('show_notice', '1');
INSERT INTO `alizi_setting` VALUES ('record_order', '1');
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
INSERT INTO `alizi_setting` VALUES ('payOnDelivery_status', '0');
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
INSERT INTO `alizi_setting` VALUES ('wxpay_status', '0');
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
INSERT INTO `alizi_setting` VALUES ('delivery_setting', '[\"huitongkuaidi\",\"yuananda\"]');
INSERT INTO `alizi_setting` VALUES ('notice', '');
INSERT INTO `alizi_setting` VALUES ('contact_phone', '');
INSERT INTO `alizi_setting` VALUES ('lazyload', '0');

-- ----------------------------
-- Table structure for alizi_shipping
-- ----------------------------
DROP TABLE IF EXISTS `alizi_shipping`;
CREATE TABLE `alizi_shipping` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `less_num` tinyint(4) NOT NULL DEFAULT '1',
  `less_num_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `step_num` tinyint(3) NOT NULL DEFAULT '1',
  `step_num_cost` decimal(10,2) NOT NULL DEFAULT '1.00',
  `is_free_num` tinyint(1) NOT NULL DEFAULT '0',
  `is_free_cost` tinyint(1) NOT NULL DEFAULT '0',
  `free_num` mediumint(5) NOT NULL DEFAULT '0',
  `free_cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='运费模板-alizi.net';

-- ----------------------------
-- Records of alizi_shipping
-- ----------------------------
INSERT INTO `alizi_shipping` VALUES ('1', '满100免运费', '2', '10.00', '1', '2.00', '1', '1', '50', '100.00', '1455506416');

-- ----------------------------
-- Table structure for alizi_user
-- ----------------------------
DROP TABLE IF EXISTS `alizi_user`;
CREATE TABLE `alizi_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(12) unsigned NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `password` char(32) NOT NULL,
  `role` enum('admin','member') NOT NULL DEFAULT 'admin',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `realname` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(15) NOT NULL,
  `qq` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `info` mediumtext NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `login_ip` char(16) NOT NULL,
  `login_time` datetime NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='产品用户表-alizi.net';

-- ----------------------------
-- Records of alizi_user
-- ----------------------------
INSERT INTO `alizi_user` VALUES ('2', '0', 'admin', 'dcafaaf0e55d98d2f5ddec9bbc2463a2', 'admin', '1', '', '', '', '', '', '0', '127.0.0.1', '2019-04-23 14:13:51', '0', '1555552508');
INSERT INTO `alizi_user` VALUES ('3', '0', '1234', '85dcf91c51b058b4fda7e73b37f4fd85', 'member', '1', '111', '13071601631', '1', '', '', '0', '127.0.0.1', '2019-04-23 10:24:08', '1555553118', '0');
