/*
Navicat MySQL Data Transfer

Source Server         : 111
Source Server Version : 80012
Source Host           : localhost:3306
Source Database       : room_manage

Target Server Type    : MYSQL
Target Server Version : 80012
File Encoding         : 65001

Date: 2019-07-28 00:09:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `adminid` varchar(16) NOT NULL,
  `password` varchar(60) NOT NULL,
  `code` smallint(4) NOT NULL,
  `last_time` datetime DEFAULT NULL,
  `power` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for apply
-- ----------------------------
DROP TABLE IF EXISTS `apply`;
CREATE TABLE `apply` (
  `applyid` int(11) NOT NULL AUTO_INCREMENT,
  `applytime` datetime NOT NULL,
  `beginweek` smallint(6) NOT NULL,
  `endweek` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `day` smallint(6) NOT NULL,
  `section` varchar(10) NOT NULL,
  `buildid` smallint(6) NOT NULL,
  `roomid` varchar(10) NOT NULL,
  `organize` varchar(50) DEFAULT NULL,
  `people` smallint(6) DEFAULT NULL,
  `user` varchar(50) NOT NULL,
  `status` smallint(2) NOT NULL,
  `allowtime` datetime DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `remark1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`applyid`),
  KEY `foreign1` (`buildid`),
  KEY `foreign2` (`roomid`),
  KEY `F3` (`user`),
  CONSTRAINT `F3` FOREIGN KEY (`user`) REFERENCES `user` (`username`),
  CONSTRAINT `foreign1` FOREIGN KEY (`buildid`) REFERENCES `room` (`buildid`),
  CONSTRAINT `foreign2` FOREIGN KEY (`roomid`) REFERENCES `room` (`roomid`)
) ENGINE=InnoDB AUTO_INCREMENT=10045 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for building
-- ----------------------------
DROP TABLE IF EXISTS `building`;
CREATE TABLE `building` (
  `buildid` smallint(6) NOT NULL,
  `buildname` varchar(32) NOT NULL,
  `block` varchar(16) NOT NULL,
  `roomnumber` smallint(6) NOT NULL,
  `alias` varchar(32) DEFAULT NULL,
  `status` smallint(6) DEFAULT '0',
  PRIMARY KEY (`buildid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cookiesyllabus
-- ----------------------------
DROP TABLE IF EXISTS `cookiesyllabus`;
CREATE TABLE `cookiesyllabus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roomid` int(11) DEFAULT NULL,
  `buildname` varchar(50) DEFAULT NULL,
  `week` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `ju` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for info
-- ----------------------------
DROP TABLE IF EXISTS `info`;
CREATE TABLE `info` (
  `id` varchar(255) NOT NULL,
  `data1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `data2` varchar(255) DEFAULT NULL,
  `data3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for room
-- ----------------------------
DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `roomid` varchar(10) NOT NULL,
  `buildid` smallint(6) NOT NULL,
  `maxpeople` smallint(6) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `remarks` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`roomid`,`buildid`),
  KEY `f_buildid` (`buildid`),
  KEY `roomid` (`roomid`),
  CONSTRAINT `f_buildid` FOREIGN KEY (`buildid`) REFERENCES `building` (`buildid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for syllabus
-- ----------------------------
DROP TABLE IF EXISTS `syllabus`;
CREATE TABLE `syllabus` (
  `roomid` varchar(10) NOT NULL,
  `buildid` smallint(6) NOT NULL,
  `week` smallint(2) NOT NULL,
  `day` smallint(2) NOT NULL,
  `section` varchar(10) NOT NULL,
  `status` smallint(1) NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `toapply` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`roomid`,`buildid`,`week`,`day`,`section`),
  KEY `for2` (`buildid`),
  CONSTRAINT `for1` FOREIGN KEY (`roomid`) REFERENCES `room` (`roomid`),
  CONSTRAINT `for2` FOREIGN KEY (`buildid`) REFERENCES `building` (`buildid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `username` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `register_time` datetime NOT NULL,
  `last_time` datetime DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `school` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `schoolpsw` varchar(60) DEFAULT NULL,
  `code` smallint(4) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
