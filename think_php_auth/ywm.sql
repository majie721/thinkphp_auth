/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : ywm

Target Server Type    : MYSQL


Date: 2017-02-17 13:05:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for y_admin
-- ----------------------------
DROP TABLE IF EXISTS `y_admin`;
CREATE TABLE `y_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminname` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '\\\\1--正常  0禁用',
  `lasttime` int(11) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of y_admin
-- ----------------------------
INSERT INTO `y_admin` VALUES ('1', 'admin', '0', '1', '1487302794', '202cb962ac59075b964b07152d234b70');
INSERT INTO `y_admin` VALUES ('2', 'admin1', '0', '1', '1487306024', '202cb962ac59075b964b07152d234b70');





-- ----------------------------
-- Table structure for y_think_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `y_think_auth_group`;
CREATE TABLE `y_think_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  `discribe` varchar(255) DEFAULT NULL COMMENT '//描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of y_think_auth_group
-- ----------------------------
INSERT INTO `y_think_auth_group` VALUES ('15', '超级管理员', '1', '6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,', '所有权限');
INSERT INTO `y_think_auth_group` VALUES ('16', '游客组', '1', '6,7,8,9,10,13,17,', '浏览demo');

-- ----------------------------
-- Table structure for y_think_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `y_think_auth_group_access`;
CREATE TABLE `y_think_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of y_think_auth_group_access
-- ----------------------------
INSERT INTO `y_think_auth_group_access` VALUES ('1', '15');
INSERT INTO `y_think_auth_group_access` VALUES ('2', '16');

-- ----------------------------
-- Table structure for y_think_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `y_think_auth_rule`;
CREATE TABLE `y_think_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `mudel` varchar(20) DEFAULT NULL COMMENT '//规则所属模块',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of y_think_auth_rule
-- ----------------------------
INSERT INTO `y_think_auth_rule` VALUES ('6', 'Index/index', '后台首页', '1', '1', '', '系统');
INSERT INTO `y_think_auth_rule` VALUES ('7', 'User/index', '用户列表', '1', '1', '', '客户');
INSERT INTO `y_think_auth_rule` VALUES ('8', 'User/edit', '用户编辑', '1', '1', '', '客户');
INSERT INTO `y_think_auth_rule` VALUES ('9', 'User/excel', '用户excel下载', '1', '1', '', '客户');
INSERT INTO `y_think_auth_rule` VALUES ('10', 'Grant/adminInfo', '管理员列表', '1', '1', '', '权限管理');
INSERT INTO `y_think_auth_rule` VALUES ('11', 'Grant/adminEdit', '管理员修改', '1', '1', '', '权限管理');
INSERT INTO `y_think_auth_rule` VALUES ('12', 'Grant/adminAdd', '管理员添加', '1', '1', '', '权限管理');
INSERT INTO `y_think_auth_rule` VALUES ('13', 'Grant/group', '权限组列表', '1', '1', '', '权限管理');
INSERT INTO `y_think_auth_rule` VALUES ('14', 'Grant/groupAdd', '添加权限组', '1', '1', '', '权限管理');
INSERT INTO `y_think_auth_rule` VALUES ('15', 'Grant/groupEdit', '修改权限组', '1', '1', '', '权限管理');
INSERT INTO `y_think_auth_rule` VALUES ('16', 'Grant/groupDel', '删除权限组', '1', '1', '', '权限管理');
INSERT INTO `y_think_auth_rule` VALUES ('17', 'Grant/rules', '权限节点列表', '1', '1', '', '权限管理');
INSERT INTO `y_think_auth_rule` VALUES ('18', 'Grant/rulesAdd', '权限节点添加', '1', '1', '', '权限管理');
INSERT INTO `y_think_auth_rule` VALUES ('19', 'Grant/rulesEdit', '权限节点编辑', '1', '1', '', '权限管理');
INSERT INTO `y_think_auth_rule` VALUES ('20', 'Grant/rulesDel', '权限节点删除', '1', '1', '', '权限管理');


-- ----------------------------
-- Table structure for y_user
-- ----------------------------
DROP TABLE IF EXISTS `y_user`;
CREATE TABLE `y_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(13) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `registertime` int(11) NOT NULL,
  `lasttime` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '状态 1正常  0--禁用',
  `grade` tinyint(4) DEFAULT NULL COMMENT '级别  ',
  `referrer` int(11) DEFAULT NULL COMMENT '推荐人的id',
  `ident` tinyint(4) NOT NULL DEFAULT '0' COMMENT '实名认证 0--未认证  1--已认证',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of y_user
-- ----------------------------
INSERT INTO `y_user` VALUES ('3', '18823418494', 'e10adc3949ba59abbe56e057f20f883e', '1483947173', null, '1', null, '0', '0');
INSERT INTO `y_user` VALUES ('4', '15527866292', 'e10adc3949ba59abbe56e057f20f883e', '1483947999', null, '1', null, '188234184', '0');



