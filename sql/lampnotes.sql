-- MySQL dump 10.15  Distrib 10.0.15-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: lampnotes
-- ------------------------------------------------------
-- Server version	10.0.15-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `lampnotes`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `lampnotes` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `lampnotes`;

--
-- Table structure for table `t_comments`
--

DROP TABLE IF EXISTS `t_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(15) NOT NULL,
  `content` mediumtext NOT NULL,
  `post_time` int(11) NOT NULL DEFAULT '0',
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`,`post_time`),
  KEY `user_id` (`user_id`,`post_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_counter`
--

DROP TABLE IF EXISTS `t_counter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `counter_name` varchar(20) NOT NULL,
  `counter_value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `counter_name` (`counter_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_site`
--

DROP TABLE IF EXISTS `t_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(50) NOT NULL DEFAULT '',
  `score` int(11) NOT NULL DEFAULT '0',
  `topic_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_topics`
--

DROP TABLE IF EXISTS `t_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `user_name` varchar(15) NOT NULL DEFAULT '' COMMENT '用户名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `url` varchar(255) NOT NULL,
  `content` text NOT NULL COMMENT '内容',
  `site_id` mediumint(9) NOT NULL DEFAULT '0',
  `view_count` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数',
  `comment_count` int(11) NOT NULL DEFAULT '0' COMMENT '回复数',
  `up_count` int(11) NOT NULL DEFAULT '0' COMMENT '顶次数',
  `down_count` int(11) NOT NULL DEFAULT '0' COMMENT '差评次数',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `hot_score` int(11) NOT NULL DEFAULT '0' COMMENT '热度',
  `special_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '特殊类型',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `hot_score` (`hot_score`),
  KEY `idx_st_ut` (`special_type`,`hot_score`,`update_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_url`
--

DROP TABLE IF EXISTS `t_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_url` (
  `topic_id` int(11) NOT NULL COMMENT '话题ID',
  `hash` bigint(20) NOT NULL,
  PRIMARY KEY (`topic_id`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `user_name` varchar(15) NOT NULL COMMENT '用户名',
  `nick_name` varchar(15) NOT NULL DEFAULT '' COMMENT '昵称',
  `email` varchar(50) NOT NULL COMMENT '用户邮箱',
  `password` char(32) NOT NULL COMMENT '用户密码',
  `salt` char(10) NOT NULL COMMENT '混淆码',
  `reg_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '注册IP',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_ip` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '激活状态',
  `topic_count` int(11) NOT NULL DEFAULT '0' COMMENT '话题数',
  `comment_count` int(11) NOT NULL DEFAULT '0' COMMENT '回复数',
  `like_count` int(11) NOT NULL DEFAULT '0' COMMENT '收到的好评次数',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `level` smallint(6) NOT NULL DEFAULT '0' COMMENT '等级',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `nick_name` (`nick_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_user_profile`
--

DROP TABLE IF EXISTS `t_user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_user_profile` (
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `gender` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别(0:保密,1:男,2:女)',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `headline` varchar(20) NOT NULL DEFAULT '' COMMENT '一句话介绍',
  `city_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '所在城市',
  `city_name` varchar(20) NOT NULL DEFAULT '' COMMENT '城市名称',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '通讯地址',
  `homepage` varchar(50) NOT NULL DEFAULT '' COMMENT '个人主页',
  `resume` varchar(255) NOT NULL DEFAULT '' COMMENT '个人简介',
  `qq` varchar(20) NOT NULL DEFAULT '' COMMENT 'QQ号码',
  `wechat` varchar(50) NOT NULL DEFAULT '' COMMENT '微信号码',
  `weibo` varchar(100) NOT NULL DEFAULT '' COMMENT '微博地址',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_vote_log`
--

DROP TABLE IF EXISTS `t_vote_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_vote_log` (
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`,`user_id`),
  KEY `idx_uid_tid` (`user_id`,`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-08 21:32:49
