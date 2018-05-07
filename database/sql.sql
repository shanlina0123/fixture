/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.5.59 : Database - xxs_fixture
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`xxs_fixture` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `xxs_fixture`;

/*Table structure for table `fixture_activity` */

DROP TABLE IF EXISTS `fixture_activity`;

CREATE TABLE `fixture_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '创建者id',
  `createuserid` int(11) DEFAULT NULL COMMENT '创建者id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `participatoryid` int(11) DEFAULT NULL COMMENT '活动参与方式id ',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `resume` varchar(255) DEFAULT NULL COMMENT '摘要 简述',
  `content` text COMMENT '内容',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1，1所有显示  0所有不显示  2只对成员显示',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动';

/*Data for the table `fixture_activity` */

/*Table structure for table `fixture_activity_inrecord` */

DROP TABLE IF EXISTS `fixture_activity_inrecord`;

CREATE TABLE `fixture_activity_inrecord` (
  `id` int(11) DEFAULT NULL,
  `uuid` char(32) DEFAULT NULL,
  `activityid` int(11) DEFAULT NULL COMMENT '活动id',
  `followuserid` int(11) DEFAULT NULL COMMENT '观光团id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='观光团参与的活动';

/*Data for the table `fixture_activity_inrecord` */

/*Table structure for table `fixture_client` */

DROP TABLE IF EXISTS `fixture_client`;

CREATE TABLE `fixture_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `sourcecateid` int(11) DEFAULT NULL COMMENT '客户来源分类 活动预约 观光团',
  `sourceid` int(11) DEFAULT NULL COMMENT '客户来源',
  `phone` varchar(30) DEFAULT NULL COMMENT '手机号',
  `name` varchar(200) DEFAULT NULL COMMENT '姓名',
  `area` int(11) DEFAULT NULL COMMENT '面积=平方米',
  `roomshap` varchar(20) DEFAULT NULL COMMENT '几室几厅几厨几卫',
  `content` text COMMENT '预约内容 （参观{xx工地}、免费量房、装修报价）',
  `wechatopenid` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='C端客户';

/*Data for the table `fixture_client` */

/*Table structure for table `fixture_company` */

DROP TABLE IF EXISTS `fixture_company`;

CREATE TABLE `fixture_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `vipmechanismid` int(11) DEFAULT NULL COMMENT '会员机制id，默认 标准版',
  `provinceid` int(11) DEFAULT NULL COMMENT '省id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `coucntryid` int(11) DEFAULT NULL COMMENT '区id',
  `name` varchar(100) DEFAULT NULL COMMENT '公司名称',
  `fullname` varchar(255) DEFAULT NULL COMMENT '公司简称',
  `contacts` varchar(255) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(30) DEFAULT NULL COMMENT '联系方式, 暂不使用',
  `addr` varchar(255) DEFAULT NULL COMMENT '地址',
  `fulladdr` varchar(255) DEFAULT NULL COMMENT '详情地址  省市区+地址',
  `resume` varchar(255) DEFAULT NULL COMMENT '公司简介',
  `logo` longtext COMMENT '企业logo',
  `clientappid` varchar(100) DEFAULT NULL COMMENT '客户小程序appid',
  `deadline` datetime DEFAULT NULL COMMENT '机制过期时间，过期后自动成为标准版（后台自动定期处理）',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='公司';

/*Data for the table `fixture_company` */

insert  into `fixture_company`(`id`,`uuid`,`vipmechanismid`,`provinceid`,`cityid`,`coucntryid`,`name`,`fullname`,`contacts`,`phone`,`addr`,`fulladdr`,`resume`,`logo`,`clientappid`,`deadline`,`created_at`,`updated_at`) values (1,'31645b462d8411e88aa754e1adc540fa',1,1,1,1,'积木家','西安积木家信息科技有限公司','总-张三','','龙首源8号','陕西省西安市龙首源8号','在互联网家装行业垂直市场，积木家专注为年轻人提供高品质低价格的互联网整居全包装修服务。',NULL,NULL,'2019-03-22 11:35:23','2018-03-22 11:35:41',NULL),(2,'a06291162d8411e88aa754e1adc540fa',1,1,1,2,'蘑菇家','西安蘑菇网科技有限公司','总-张四','','未央湖2号','陕西省西安市未央湖2号','整体家装,就选蘑菇加。蘑菇加,亚厦股份旗下互联网家装品牌。',NULL,NULL,'2019-03-22 11:37:26','2018-03-22 11:37:36',NULL);

/*Table structure for table `fixture_company_stagetemplate` */

DROP TABLE IF EXISTS `fixture_company_stagetemplate`;

CREATE TABLE `fixture_company_stagetemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='公司 - 自定义阶段模板名称';

/*Data for the table `fixture_company_stagetemplate` */

insert  into `fixture_company_stagetemplate`(`id`,`uuid`,`companyid`,`name`,`status`,`created_at`) values (1,'e62180be2e8411e8b20154e1adc540fa',1,'自定义模板jimu1',1,'2018-03-23 18:28:18'),(2,'e621829a2e8411e8b20154e1adc540fa',1,'自定义模板jimu2',1,'2018-03-23 18:28:18'),(3,'e621830f2e8411e8b20154e1adc540fa',2,'自定义模板mogu1',1,'2018-03-23 18:28:18'),(4,'e621833c2e8411e8b20154e1adc540fa',2,'自定义模板mogu2',1,'2018-03-23 18:28:18');

/*Table structure for table `fixture_company_stagetemplate_tag` */

DROP TABLE IF EXISTS `fixture_company_stagetemplate_tag`;

CREATE TABLE `fixture_company_stagetemplate_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `stagetemplateid` int(11) DEFAULT NULL COMMENT '自动以阶段模板id',
  `name` varchar(100) DEFAULT NULL COMMENT '自定义阶段名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='公司 - 自定义模板阶段';

/*Data for the table `fixture_company_stagetemplate_tag` */

insert  into `fixture_company_stagetemplate_tag`(`id`,`uuid`,`companyid`,`stagetemplateid`,`name`,`status`,`created_at`,`updated_at`) values (1,'e639b3b42e8411e8b20154e1adc540fa',1,1,'jimu阶段1',1,'2018-03-23 18:28:18',NULL),(2,'e63a38992e8411e8b20154e1adc540fa',1,1,'jimu阶段2',1,'2018-03-23 18:28:18',NULL),(11,'e63a39462e8411e8b20154e1adc540fa',1,1,'jimu阶段3',1,'2018-03-23 18:28:18',NULL),(12,'e63a3a402e8411e8b20154e1adc540fa',1,1,'jimu阶段4',1,'2018-03-23 18:28:18',NULL),(13,'e63a3a982e8411e8b20154e1adc540fa',1,1,'jimu阶段5',1,'2018-03-23 18:28:18',NULL),(14,'e63a3ae22e8411e8b20154e1adc540fa',1,2,'jimu阶段6',1,'2018-03-23 18:28:18',NULL),(15,'e63a3b2c2e8411e8b20154e1adc540fa',1,2,'jimu阶段7',1,'2018-03-23 18:28:18',NULL),(16,'e63a3b6f2e8411e8b20154e1adc540fa',1,2,'jimu阶段8',1,'2018-03-23 18:28:18',NULL),(17,'e63a3bb22e8411e8b20154e1adc540fa',1,2,'jimu阶段9',1,'2018-03-23 18:28:18',NULL),(18,'e63a3bf92e8411e8b20154e1adc540fa',2,3,'mogu阶段1',1,'2018-03-23 18:28:18',NULL),(19,'e63a3c3f2e8411e8b20154e1adc540fa',2,3,'mogu阶段2',1,'2018-03-23 18:28:18',NULL),(20,'e63a3c862e8411e8b20154e1adc540fa',2,3,'mogu阶段3',1,'2018-03-23 18:28:18',NULL),(21,'e63a3cc92e8411e8b20154e1adc540fa',2,4,'mogu阶段4',1,'2018-03-23 18:28:18',NULL),(22,'e63a3d0c2e8411e8b20154e1adc540fa',2,4,'mogu阶段5',1,'2018-03-23 18:28:18',NULL),(23,'e63a3d4f2e8411e8b20154e1adc540fa',2,4,'mogu阶段6',1,'2018-03-23 18:28:18',NULL),(24,'e63a3f802e8411e8b20154e1adc540fa',2,4,'mogu阶段7',1,'2018-03-23 18:28:18',NULL);

/*Table structure for table `fixture_conf_pc` */

DROP TABLE IF EXISTS `fixture_conf_pc`;

CREATE TABLE `fixture_conf_pc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `content` longtext COMMENT '内容 json',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置 - B端PC';

/*Data for the table `fixture_conf_pc` */

/*Table structure for table `fixture_conf_smallroutine` */

DROP TABLE IF EXISTS `fixture_conf_smallroutine`;

CREATE TABLE `fixture_conf_smallroutine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `content` longtext COMMENT '内容 json',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置 - 小程序';

/*Data for the table `fixture_conf_smallroutine` */

/*Table structure for table `fixture_conf_sys` */

DROP TABLE IF EXISTS `fixture_conf_sys`;

CREATE TABLE `fixture_conf_sys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `content` longtext COMMENT '内容 json',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置 - 系统后台';

/*Data for the table `fixture_conf_sys` */

/*Table structure for table `fixture_conf_vipfunctionpoint` */

DROP TABLE IF EXISTS `fixture_conf_vipfunctionpoint`;

CREATE TABLE `fixture_conf_vipfunctionpoint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vipmechanismid` int(11) DEFAULT NULL COMMENT '会员机制id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `content` longtext COMMENT '内容 json',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置 - 会员机制功能';

/*Data for the table `fixture_conf_vipfunctionpoint` */

/*Table structure for table `fixture_data_authorityscan` */

DROP TABLE IF EXISTS `fixture_data_authorityscan`;

CREATE TABLE `fixture_data_authorityscan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='数据源 - 视野';

/*Data for the table `fixture_data_authorityscan` */

insert  into `fixture_data_authorityscan`(`id`,`name`,`status`,`created_at`) values (1,'所有',1,'2018-03-19 16:45:02'),(2,'城市',1,'2018-03-19 16:45:02'),(3,'门店',1,'2018-03-19 16:45:02');

/*Table structure for table `fixture_data_city` */

DROP TABLE IF EXISTS `fixture_data_city`;

CREATE TABLE `fixture_data_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `provinceid` int(11) DEFAULT NULL COMMENT '省份id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='数据源 - 城市';

/*Data for the table `fixture_data_city` */

insert  into `fixture_data_city`(`id`,`name`,`provinceid`,`status`,`created_at`) values (1,'西安市\r\n',1,1,'2018-03-19 16:45:53');

/*Table structure for table `fixture_data_country` */

DROP TABLE IF EXISTS `fixture_data_country`;

CREATE TABLE `fixture_data_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='数据源 - 区';

/*Data for the table `fixture_data_country` */

insert  into `fixture_data_country`(`id`,`name`,`cityid`,`status`,`created_at`) values (1,'未央区',1,1,'2018-03-19 16:45:53'),(2,'高新区',1,1,'2018-03-22 11:10:23');

/*Table structure for table `fixture_data_participatory` */

DROP TABLE IF EXISTS `fixture_data_participatory`;

CREATE TABLE `fixture_data_participatory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `content` text COMMENT '描述',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='数据源 - 活动参与方式';

/*Data for the table `fixture_data_participatory` */

insert  into `fixture_data_participatory`(`id`,`name`,`content`,`status`,`created_at`) values (1,'快速报价','房型+电话+内容',1,'2018-03-19 16:41:17'),(2,'在线咨询','电话+内容',1,'2018-03-19 16:41:17'),(3,'预约量房','电话+内容',1,'2018-03-19 16:41:17');

/*Table structure for table `fixture_data_position` */

DROP TABLE IF EXISTS `fixture_data_position`;

CREATE TABLE `fixture_data_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='数据源 - 职位';

/*Data for the table `fixture_data_position` */

insert  into `fixture_data_position`(`id`,`name`,`status`,`created_at`) values (1,'项目经理',1,'2018-03-19 16:36:44'),(2,'家装顾问',1,'2018-03-19 16:36:44'),(3,'项目监理',1,'2018-03-19 16:36:44'),(4,'设计师',1,'2018-03-19 16:36:44'),(5,'营销主管',1,'2018-03-19 16:36:44'),(6,'设计师主管',1,'2018-03-19 16:36:44'),(7,'业务',1,'2018-03-19 16:36:44'),(8,'客服主管',1,'2018-03-19 16:36:44'),(9,'资深设计师',1,'2018-03-19 16:36:44'),(10,'工长',1,'2018-03-19 16:36:44'),(11,'水电工',1,'2018-03-19 16:36:44'),(12,'设计总监',1,'2018-03-19 16:36:44'),(13,'油漆工',1,'2018-03-19 16:36:44'),(14,'客服',1,'2018-03-19 16:36:44'),(15,'泥工',1,'2018-03-19 16:36:44'),(16,'木工',1,'2018-03-19 16:36:44'),(17,'总经理',1,'2018-03-19 16:36:44'),(18,'瓦工',1,'2018-03-19 16:36:44'),(19,'质量总监',1,'2018-03-19 16:36:44'),(20,'董事长',1,'2018-03-19 16:36:44'),(21,'区域经理',1,'2018-03-19 16:36:44'),(22,'工程总监',1,'2018-03-19 16:36:44');

/*Table structure for table `fixture_data_province` */

DROP TABLE IF EXISTS `fixture_data_province`;

CREATE TABLE `fixture_data_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='数据源 - 省份';

/*Data for the table `fixture_data_province` */

insert  into `fixture_data_province`(`id`,`name`,`status`,`created_at`) values (1,'陕西省\r\n',1,'2018-03-19 16:45:30');

/*Table structure for table `fixture_data_renovationmode` */

DROP TABLE IF EXISTS `fixture_data_renovationmode`;

CREATE TABLE `fixture_data_renovationmode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='数据源 - 装修方式';

/*Data for the table `fixture_data_renovationmode` */

insert  into `fixture_data_renovationmode`(`id`,`name`,`status`,`created_at`) values (1,'清包',1,'2018-03-19 16:39:43'),(2,'半包',1,'2018-03-19 16:39:43'),(3,'全包',1,'2018-03-19 16:39:43'),(4,'拎包入住',1,'2018-03-19 16:39:43'),(5,'整装',1,'2018-03-19 16:39:43');

/*Table structure for table `fixture_data_roomstyle` */

DROP TABLE IF EXISTS `fixture_data_roomstyle`;

CREATE TABLE `fixture_data_roomstyle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='数据源 - 户型风格';

/*Data for the table `fixture_data_roomstyle` */

insert  into `fixture_data_roomstyle`(`id`,`name`,`status`,`created_at`) values (1,'现代',1,'2018-03-19 16:39:11'),(2,'中式',1,'2018-03-19 16:39:11'),(3,'欧式',1,'2018-03-19 16:39:11'),(4,'美式',1,'2018-03-19 16:39:11'),(5,'混搭',1,'2018-03-19 16:39:11'),(6,'田园',1,'2018-03-19 16:39:11'),(7,'新古典',1,'2018-03-19 16:39:11'),(8,'简约',1,'2018-03-19 16:39:11'),(9,'地中海',1,'2018-03-19 16:39:11'),(10,'东南亚',1,'2018-03-19 16:39:11');

/*Table structure for table `fixture_data_roomtype` */

DROP TABLE IF EXISTS `fixture_data_roomtype`;

CREATE TABLE `fixture_data_roomtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '创建时间',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='数据源 - 户型';

/*Data for the table `fixture_data_roomtype` */

insert  into `fixture_data_roomtype`(`id`,`name`,`status`,`created_at`) values (1,'别墅',1,'2018-03-19 16:37:09'),(2,'公寓',1,'2018-03-19 16:37:09'),(3,'普通住宅',1,'2018-03-19 16:37:09'),(4,'大平房',1,'2018-03-19 16:37:09'),(5,'老公房',1,'2018-03-19 16:37:09'),(6,'工装',1,'2018-03-19 16:37:09'),(7,'其他',1,'2018-03-19 16:37:09');

/*Table structure for table `fixture_data_source` */

DROP TABLE IF EXISTS `fixture_data_source`;

CREATE TABLE `fixture_data_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='数据源 - 客户来源';

/*Data for the table `fixture_data_source` */

insert  into `fixture_data_source`(`id`,`name`,`status`,`created_at`) values (1,'预约参观',1,'2018-03-19 16:42:04'),(2,'免费量房',1,'2018-03-19 16:42:04'),(3,'我要报名',1,'2018-03-19 16:42:04'),(4,'装修报价',1,'2018-03-19 16:42:04');

/*Table structure for table `fixture_data_sourcecate` */

DROP TABLE IF EXISTS `fixture_data_sourcecate`;

CREATE TABLE `fixture_data_sourcecate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '来源分类',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='数据源 - 客户来源分类';

/*Data for the table `fixture_data_sourcecate` */

insert  into `fixture_data_sourcecate`(`id`,`name`,`status`,`created_at`) values (1,'姓名客户',1,'2018-03-19 16:42:24'),(2,'关注客户',1,'2018-03-19 16:42:24');

/*Table structure for table `fixture_data_stagetemplate` */

DROP TABLE IF EXISTS `fixture_data_stagetemplate`;

CREATE TABLE `fixture_data_stagetemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='数据源 - 默认阶段模板名称';

/*Data for the table `fixture_data_stagetemplate` */

insert  into `fixture_data_stagetemplate`(`id`,`uuid`,`name`,`status`,`created_at`) values (1,'0d8455612e8411e8b20154e1adc540fa','标准阶段模板',1,'2018-03-23 18:22:15'),(2,'0d8456152e8411e8b20154e1adc540fa','其他阶段模板',1,'2018-03-23 18:22:15');

/*Table structure for table `fixture_data_stagetemplate_tag` */

DROP TABLE IF EXISTS `fixture_data_stagetemplate_tag`;

CREATE TABLE `fixture_data_stagetemplate_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `stagetemplateid` int(11) DEFAULT NULL COMMENT '自动以阶段模板id',
  `name` varchar(100) DEFAULT NULL COMMENT '自定义阶段名称',
  `resume` varchar(100) DEFAULT NULL COMMENT '简述',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='数据源 - 默认模板阶段';

/*Data for the table `fixture_data_stagetemplate_tag` */

insert  into `fixture_data_stagetemplate_tag`(`id`,`uuid`,`stagetemplateid`,`name`,`resume`,`status`,`created_at`,`updated_at`) values (1,'187c83292e8411e8b20154e1adc540fa',1,'签约','包括了解装修公司等',1,'2018-03-23 18:22:33',NULL),(2,'187c84152e8411e8b20154e1adc540fa',1,'设计','确定房子风格类型',1,'2018-03-23 18:22:33',NULL),(11,'187c845f2e8411e8b20154e1adc540fa',1,'拆改','拆墙、砌墙、铲墙皮、拆暖气、换塑钢窗',1,'2018-03-23 18:22:33',NULL),(12,'187c854c2e8411e8b20154e1adc540fa',1,'水电','开线槽、铺设管道',1,'2018-03-23 18:22:33',NULL),(13,'187c85ff2e8411e8b20154e1adc540fa',1,'泥木','瓷砖、吊顶',1,'2018-03-23 18:22:33',NULL),(14,'187c867b2e8411e8b20154e1adc540fa',1,'油漆','油漆',1,'2018-03-23 18:22:33',NULL),(15,'187c86e82e8411e8b20154e1adc540fa',1,'安装','橱柜、木门等安装',1,'2018-03-23 18:22:33',NULL),(16,'187c87552e8411e8b20154e1adc540fa',1,'软装','家具家电等',1,'2018-03-23 18:22:33',NULL),(17,'187c87bc2e8411e8b20154e1adc540fa',1,'入住','入住新房',1,'2018-03-23 18:22:33',NULL),(18,'187c88372e8411e8b20154e1adc540fa',1,'完工','结束装修',1,'2018-03-23 18:22:33',NULL),(19,'187c88ab2e8411e8b20154e1adc540fa',2,'签约','包括了解装修公司等',1,'2018-03-23 18:22:33',NULL),(20,'187c89202e8411e8b20154e1adc540fa',2,'软装','家具家电等',1,'2018-03-23 18:22:33',NULL),(21,'187c89942e8411e8b20154e1adc540fa',2,'入住','入住新房',1,'2018-03-23 18:22:33',NULL),(22,'187c8a092e8411e8b20154e1adc540fa',2,'完工','结束装修',1,'2018-03-23 18:22:33',NULL);

/*Table structure for table `fixture_data_vipmechanism` */

DROP TABLE IF EXISTS `fixture_data_vipmechanism`;

CREATE TABLE `fixture_data_vipmechanism` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='数据源 - 会员机制';

/*Data for the table `fixture_data_vipmechanism` */

insert  into `fixture_data_vipmechanism`(`id`,`name`,`status`,`created_at`) values (1,'标准版',1,'2018-03-19 16:43:02'),(2,'专业版',1,'2018-03-19 16:43:02'),(3,'定制版',1,'2018-03-19 16:43:02');

/*Table structure for table `fixture_dynamic` */

DROP TABLE IF EXISTS `fixture_dynamic`;

CREATE TABLE `fixture_dynamic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `sitetid` int(11) DEFAULT NULL COMMENT '工地id',
  `activityid` int(11) DEFAULT NULL COMMENT '活动id',
  `participatoryid` int(11) DEFAULT NULL COMMENT '活动参与方式id ',
  `tablesign` tinyint(1) DEFAULT NULL COMMENT '表 1用户  2参与者  ',
  `createuserid` int(11) DEFAULT NULL COMMENT '创建者id 用户 参与者  ',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `resume` varchar(255) DEFAULT NULL,
  `content` text COMMENT '内容',
  `type` tinyint(1) DEFAULT '0' COMMENT '类型 0工地动态 1活动动态',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1，1显示  0不显示  2只对成员显示',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='动态';

/*Data for the table `fixture_dynamic` */

/*Table structure for table `fixture_dynamic_comment` */

DROP TABLE IF EXISTS `fixture_dynamic_comment`;

CREATE TABLE `fixture_dynamic_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `dynamicid` int(11) DEFAULT NULL COMMENT '动态id',
  `siteid` int(11) DEFAULT NULL COMMENT '工地id',
  `pid` int(11) DEFAULT NULL COMMENT '父类id   记录id',
  `content` text COMMENT '内容',
  `createuserid` int(11) DEFAULT NULL COMMENT '创建人id 回复人id',
  `tablesign` tinyint(1) DEFAULT NULL COMMENT '表标识 1用户 2参与者 3观光团',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='动态 - 评论';

/*Data for the table `fixture_dynamic_comment` */

/*Table structure for table `fixture_dynamic_images` */

DROP TABLE IF EXISTS `fixture_dynamic_images`;

CREATE TABLE `fixture_dynamic_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dynamicid` int(11) DEFAULT NULL COMMENT '动态id',
  `ossurl` longtext COMMENT '图片oss地址  最多9张图片 或 1个小视频',
  `type` tinyint(1) DEFAULT '0' COMMENT '文件类型 ，默认0，0图片 1视频',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='动态-图片视频';

/*Data for the table `fixture_dynamic_images` */

/*Table structure for table `fixture_dynamic_statistics` */

DROP TABLE IF EXISTS `fixture_dynamic_statistics`;

CREATE TABLE `fixture_dynamic_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dynamicid` int(11) DEFAULT NULL COMMENT '动态id',
  `siteid` int(11) DEFAULT NULL COMMENT '工地id',
  `linkednum` int(11) DEFAULT NULL COMMENT '浏览量 =进入页面次数',
  `commentnum` int(11) DEFAULT NULL COMMENT '评论数和回复数',
  `thumbsupnum` int(11) DEFAULT NULL COMMENT '点赞数，只可增加。',
  `follownum` int(11) DEFAULT NULL COMMENT '关注数=观光团围观数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='动态 - 统计';

/*Data for the table `fixture_dynamic_statistics` */

/*Table structure for table `fixture_filter_authorityoperation` */

DROP TABLE IF EXISTS `fixture_filter_authorityoperation`;

CREATE TABLE `fixture_filter_authorityoperation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `itemid` int(11) DEFAULT NULL COMMENT '业务编号',
  `name` varchar(255) DEFAULT NULL COMMENT '名称 ',
  `pid` int(11) DEFAULT NULL COMMENT '父类id ',
  `level` tinyint(1) DEFAULT NULL COMMENT '级别',
  `ismenu` tinyint(1) DEFAULT NULL COMMENT '是否显示在菜单  默认1 ，1显示 0不显示',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 是否有效   默认1，1启用 0禁用',
  `isdefault` tinyint(1) DEFAULT '1' COMMENT '是否通用功能 ，默认1  ，1是 0不是',
  `modulename` varchar(100) DEFAULT NULL COMMENT '模块名称',
  `controlname` varchar(100) DEFAULT NULL,
  `actionname` varchar(100) DEFAULT NULL COMMENT '方法名称',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COMMENT='过滤 - 业务功能';

/*Data for the table `fixture_filter_authorityoperation` */

insert  into `fixture_filter_authorityoperation`(`id`,`uuid`,`itemid`,`name`,`pid`,`level`,`ismenu`,`sort`,`status`,`isdefault`,`modulename`,`controlname`,`actionname`,`created_at`) values (1,'a22fc6422dbc11e88aa754e1adc540fa',1,'项目管理',0,1,1,1,1,1,'Server',NULL,NULL,'2018-03-22 18:31:17'),(2,'a22fc7b02dbc11e88aa754e1adc540fa',2,'系统设置',0,1,1,2,1,1,'Server',NULL,NULL,'2018-03-22 18:31:17'),(3,'a22fc8212dbc11e88aa754e1adc540fa',3,'数据分析',0,1,1,3,1,1,'Server',NULL,NULL,'2018-03-22 18:31:17'),(4,'a22fc8722dbc11e88aa754e1adc540fa',4,'会员中心',0,1,1,4,1,1,'Server',NULL,NULL,'2018-03-22 18:31:17'),(5,'a22fc8c32dbc11e88aa754e1adc540fa',5,'消息通知',0,1,1,5,1,1,'Server',NULL,NULL,'2018-03-22 18:31:17'),(6,'a22fc9182dbc11e88aa754e1adc540fa',100,'活动管理',1,2,1,1,1,1,'Server','Activity','index','2018-03-22 18:31:17'),(7,'a22fc9772dbc11e88aa754e1adc540fa',101,'活动列表',100,3,0,1,1,1,'Server','Activity','index','2018-03-22 18:31:17'),(8,'a22fc9cf2dbc11e88aa754e1adc540fa',102,'新建活动',100,3,0,2,1,1,'Server','Activity','create,store','2018-03-22 18:31:17'),(9,'a22fca282dbc11e88aa754e1adc540fa',103,'修改活动',100,3,0,3,1,1,'Server','Activity','edit,update','2018-03-22 18:31:17'),(10,'a22fca8a2dbc11e88aa754e1adc540fa',104,'活动详情',100,3,0,4,1,1,'Server','Activity','show','2018-03-22 18:31:17'),(11,'a22fcadb2dbc11e88aa754e1adc540fa',200,'工地管理',1,2,1,2,1,1,'Server','Site','index','2018-03-22 18:31:17'),(12,'a22fcb2d2dbc11e88aa754e1adc540fa',201,'工地列表',200,3,0,1,1,1,'Server','Site','index','2018-03-22 18:31:17'),(13,'a22fcb7a2dbc11e88aa754e1adc540fa',202,'新建工地',200,3,1,2,1,1,'Server','Site','create,store','2018-03-22 18:31:17'),(14,'a22fcbee2dbc11e88aa754e1adc540fa',203,'修改工地',200,3,0,3,1,1,'Server','Site','edit,update','2018-03-22 18:31:17'),(15,'a22fcc402dbc11e88aa754e1adc540fa',204,'删除工地',200,3,0,4,1,1,'Server','Site','destory','2018-03-22 18:31:17'),(16,'a22fcc912dbc11e88aa754e1adc540fa',205,'更新工地',200,3,0,5,1,1,'Server','Site','需要开发人员自定义','2018-03-22 18:31:17'),(17,'a22fcce52dbc11e88aa754e1adc540fa',300,'阶段模板管理',1,2,0,3,1,1,'Server','Stagetemplate','index','2018-03-22 18:31:17'),(18,'a22fcd362dbc11e88aa754e1adc540fa',301,'模板列表',300,3,0,1,1,1,'Server','Stagetemplate','index','2018-03-22 18:31:17'),(19,'a22fcd842dbc11e88aa754e1adc540fa',302,'新增模板',300,3,0,2,1,1,'Server','Stagetemplate','create,store','2018-03-22 18:31:17'),(20,'a22fcdd22dbc11e88aa754e1adc540fa',303,'修改模板',300,3,0,3,1,1,'Server','Stagetemplate','edit,update','2018-03-22 18:31:17'),(21,'a22fce232dbc11e88aa754e1adc540fa',304,'删除模板',300,3,0,4,1,1,'Server','Stagetemplate','destory','2018-03-22 18:31:17'),(22,'a22fce6d2dbc11e88aa754e1adc540fa',400,'客户预约',1,2,1,4,1,1,'Server','Client','index','2018-03-22 18:31:17'),(23,'a22fceba2dbc11e88aa754e1adc540fa',401,'客户列表',400,3,0,1,1,1,'Server','Client','index','2018-03-22 18:31:17'),(24,'a22fcf0b2dbc11e88aa754e1adc540fa',402,'一键已读',400,3,0,2,1,1,'Server','Client','需要开发人员自定义','2018-03-22 18:31:17'),(25,'a22fcf592dbc11e88aa754e1adc540fa',500,'门店管理',2,2,1,5,1,1,'Server','Store','index','2018-03-22 18:31:17'),(26,'a22fcfa72dbc11e88aa754e1adc540fa',501,'门店列表',500,3,0,1,1,1,'Server','Store','index','2018-03-22 18:31:17'),(27,'a22fcff42dbc11e88aa754e1adc540fa',502,'添加门店',500,3,0,2,1,1,'Server','Store','create,store','2018-03-22 18:31:17'),(28,'a22fd0422dbc11e88aa754e1adc540fa',503,'修改门店',500,3,0,3,1,1,'Server','Store','edit,update','2018-03-22 18:31:17'),(29,'a22fd08f2dbc11e88aa754e1adc540fa',504,'删除门店',500,3,0,4,1,1,'Server','Store','destory','2018-03-22 18:31:17'),(30,'a22fd0dd2dbc11e88aa754e1adc540fa',505,'门店详情',500,3,0,5,1,1,'Server','Store','show','2018-03-22 18:31:17'),(31,'a22fd1352dbc11e88aa754e1adc540fa',600,'用户管理',2,2,0,6,1,1,'Server','User','index','2018-03-22 18:31:17'),(32,'a22fd1b42dbc11e88aa754e1adc540fa',601,'用户列表',600,3,0,1,1,1,'Server','User','index','2018-03-22 18:31:17'),(33,'a22fd2132dbc11e88aa754e1adc540fa',602,'新增用户',600,3,0,2,1,1,'Server','User','create,store','2018-03-22 18:31:17'),(34,'a22fd2612dbc11e88aa754e1adc540fa',603,'修改用户',600,3,0,3,1,1,'Server','User','edit,update','2018-03-22 18:31:17'),(35,'a22fd2ae2dbc11e88aa754e1adc540fa',604,'删除用户',600,3,0,4,1,1,'Server','User','destory','2018-03-22 18:31:17'),(36,'a22fd3112dbc11e88aa754e1adc540fa',605,'设置状态',600,3,0,5,1,1,'Server','User','需要开发人员自定义','2018-03-22 18:31:17'),(37,'a22fd3ba2dbc11e88aa754e1adc540fa',700,'角色管理',2,2,1,7,1,1,'Server','Filter','index','2018-03-22 18:31:17'),(38,'a22fd4082dbc11e88aa754e1adc540fa',701,'角色列表',700,3,0,1,1,1,'Server','Filter','index','2018-03-22 18:31:17'),(39,'a22fd4552dbc11e88aa754e1adc540fa',702,'新增角色',700,3,0,2,1,1,'Server','Filter','create,store','2018-03-22 18:31:17'),(40,'a22fd4a32dbc11e88aa754e1adc540fa',703,'修改角色',700,3,0,3,1,1,'Server','Filter','edit,update','2018-03-22 18:31:17'),(41,'a22fd4f12dbc11e88aa754e1adc540fa',704,'删除角色',700,3,0,4,1,1,'Server','Filter','destory','2018-03-22 18:31:17'),(42,'a22fd5422dbc11e88aa754e1adc540fa',800,'配置权限',2,2,0,8,1,1,'Server','Filter','index','2018-03-22 18:31:17'),(43,'a22fd58f2dbc11e88aa754e1adc540fa',801,'勾选权限',800,3,0,1,1,1,'Server','Filter','需要开发人员自定义','2018-03-22 18:31:17'),(44,'a22fd5e02dbc11e88aa754e1adc540fa',900,'数据分析',3,2,1,9,0,1,'Server','Analysis','index','2018-03-22 18:31:17'),(45,'a22fd62e2dbc11e88aa754e1adc540fa',901,'客户分析',900,3,1,1,0,1,'Server','Analysis','index','2018-03-22 18:31:17'),(46,'a22fd67c2dbc11e88aa754e1adc540fa',902,'工地分析',900,3,1,2,0,1,'Server','Analysis','需要开发人员自定义','2018-03-22 18:31:17'),(47,'a22fd6d42dbc11e88aa754e1adc540fa',903,'内部人员营销排行',900,3,1,3,0,1,'Server','Analysis','需要开发人员自定义','2018-03-22 18:31:17'),(48,'a22fd7282dbc11e88aa754e1adc540fa',904,'活动分析',900,3,1,4,0,1,'Server','Analysis','需要开发人员自定义','2018-03-22 18:31:17'),(49,'a22fd7792dbc11e88aa754e1adc540fa',1000,'会员中心',4,2,1,10,1,1,'Server','Vip','index','2018-03-22 18:31:17'),(50,'a22fd7c72dbc11e88aa754e1adc540fa',1001,'会员机制',1000,3,1,1,1,1,'Server','Vip','index','2018-03-22 18:31:17'),(51,'a22fd8152dbc11e88aa754e1adc540fa',2000,'消息通知',5,2,1,11,1,1,'Server','Message','index','2018-03-22 18:31:17'),(52,'a22fd8662dbc11e88aa754e1adc540fa',2001,'通知消息',2000,3,1,1,1,1,'Server','Message','index','2018-03-22 18:31:17'),(53,'a22fd8b02dbc11e88aa754e1adc540fa',2002,'一键已读',2000,3,0,2,1,1,'Server','Message','需要开发人员自定义','2018-03-22 18:31:17'),(54,'a22fd9012dbc11e88aa754e1adc540fa',3000,'咨询消息',5,2,1,12,1,1,'Server','Message','index','2018-03-22 18:31:17'),(55,'a22fd94e2dbc11e88aa754e1adc540fa',3001,'消息列表',3000,3,0,1,1,1,'Server','Message','index','2018-03-22 18:31:17'),(56,'a22fd9a02dbc11e88aa754e1adc540fa',3002,'回复消息',3000,3,0,2,1,1,'Server','Message','需要开发人员自定义','2018-03-22 18:31:17');

/*Table structure for table `fixture_filter_role` */

DROP TABLE IF EXISTS `fixture_filter_role`;

CREATE TABLE `fixture_filter_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态  默认1，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='过滤 - 自定义角色';

/*Data for the table `fixture_filter_role` */

insert  into `fixture_filter_role`(`id`,`uuid`,`companyid`,`storeid`,`name`,`status`,`created_at`,`updated_at`) values (1,'507be0e82d8d11e88aa754e1adc540fa',1,1,'自定义项目管理员',1,'2018-03-22 12:56:57',NULL),(2,'554c05d22d8d11e88aa754e1adc540fa',1,2,'自定义系统管理员',1,'2018-03-22 12:56:59',NULL),(3,'593754bf2d8d11e88aa754e1adc540fa',1,3,'自定义数据分析管理员',1,'2018-03-22 12:57:02',NULL),(4,'5d41b7d92d8d11e88aa754e1adc540fa',1,4,'自定义会员管理员',1,'2018-03-22 12:57:04',NULL),(5,'60bf7c392d8d11e88aa754e1adc540fa',2,5,'自定义消息管理员',1,'2018-03-22 12:57:06',NULL),(6,'d72f25fc2d8d11e88aa754e1adc540fa',2,6,'自定义门店管理员',1,'2018-03-22 13:00:13',NULL),(7,'ed34f9172d8d11e88aa754e1adc540fa',2,7,'自定义门店管理员',1,'2018-03-22 13:00:30',NULL);

/*Table structure for table `fixture_filter_role_default` */

DROP TABLE IF EXISTS `fixture_filter_role_default`;

CREATE TABLE `fixture_filter_role_default` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态  默认1，1启用 0禁用',
  `isallowdel` tinyint(1) DEFAULT '0' COMMENT '是否允许删除 1可以 0不可以',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='过滤 - 默认角色';

/*Data for the table `fixture_filter_role_default` */

insert  into `fixture_filter_role_default`(`id`,`uuid`,`name`,`status`,`isallowdel`,`created_at`) values (1,'5bedf8942dbd11e88aa754e1adc540fa','超级管理员',1,0,'2018-03-22 12:56:53'),(2,'6222f3bf2dbd11e88aa754e1adc540fa','门店管理员',1,0,'2018-03-22 18:39:38');

/*Table structure for table `fixture_filter_roleauthority` */

DROP TABLE IF EXISTS `fixture_filter_roleauthority`;

CREATE TABLE `fixture_filter_roleauthority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `authorityoperationitemid` int(11) DEFAULT NULL COMMENT '业务功能id 0代表所有功能，个别的使用具体itemid值',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COMMENT='过滤 - 自定义角色权限';

/*Data for the table `fixture_filter_roleauthority` */

insert  into `fixture_filter_roleauthority`(`id`,`uuid`,`authorityoperationitemid`,`roleid`,`created_at`) values (1,'5bef36f42dc011e88aa754e1adc540fa',1,1,'2018-03-22 19:01:23'),(2,'5bef38272dc011e88aa754e1adc540fa',100,1,'2018-03-22 19:01:23'),(3,'5bef38942dc011e88aa754e1adc540fa',101,1,'2018-03-22 19:01:23'),(4,'5bef38de2dc011e88aa754e1adc540fa',102,1,'2018-03-22 19:01:23'),(5,'5bef39252dc011e88aa754e1adc540fa',103,1,'2018-03-22 19:01:23'),(6,'5bef39612dc011e88aa754e1adc540fa',104,1,'2018-03-22 19:01:23'),(7,'5bef39a72dc011e88aa754e1adc540fa',200,1,'2018-03-22 19:01:23'),(8,'5bef39e32dc011e88aa754e1adc540fa',201,1,'2018-03-22 19:01:23'),(9,'5bef3a492dc011e88aa754e1adc540fa',202,1,'2018-03-22 19:01:23'),(10,'5bef3a892dc011e88aa754e1adc540fa',203,1,'2018-03-22 19:01:23'),(11,'5bef3ac82dc011e88aa754e1adc540fa',204,1,'2018-03-22 19:01:23'),(12,'5bef3b082dc011e88aa754e1adc540fa',205,1,'2018-03-22 19:01:23'),(13,'5bef3b4b2dc011e88aa754e1adc540fa',300,1,'2018-03-22 19:01:23'),(14,'5bef3b8a2dc011e88aa754e1adc540fa',301,1,'2018-03-22 19:01:23'),(15,'5bef3c302dc011e88aa754e1adc540fa',302,1,'2018-03-22 19:01:23'),(16,'5bef3c702dc011e88aa754e1adc540fa',303,1,'2018-03-22 19:01:23'),(17,'5bef3cab2dc011e88aa754e1adc540fa',304,1,'2018-03-22 19:01:23'),(18,'5bef3ceb2dc011e88aa754e1adc540fa',400,1,'2018-03-22 19:01:23'),(19,'5bef3d272dc011e88aa754e1adc540fa',401,1,'2018-03-22 19:01:23'),(20,'5bef3d632dc011e88aa754e1adc540fa',402,1,'2018-03-22 19:01:23'),(21,'5bef3d9f2dc011e88aa754e1adc540fa',2,2,'2018-03-22 19:01:23'),(22,'5bef3dde2dc011e88aa754e1adc540fa',500,2,'2018-03-22 19:01:23'),(23,'5bef3e1a2dc011e88aa754e1adc540fa',501,2,'2018-03-22 19:01:23'),(24,'5bef3e562dc011e88aa754e1adc540fa',502,2,'2018-03-22 19:01:23'),(25,'5bef3e922dc011e88aa754e1adc540fa',503,2,'2018-03-22 19:01:23'),(26,'5bef3ed22dc011e88aa754e1adc540fa',504,2,'2018-03-22 19:01:23'),(27,'5bef3f0d2dc011e88aa754e1adc540fa',505,2,'2018-03-22 19:01:23'),(28,'5bef3f4d2dc011e88aa754e1adc540fa',600,2,'2018-03-22 19:01:23'),(29,'5bef3f852dc011e88aa754e1adc540fa',601,2,'2018-03-22 19:01:23'),(30,'5bef3fc52dc011e88aa754e1adc540fa',602,2,'2018-03-22 19:01:23'),(31,'5bef40012dc011e88aa754e1adc540fa',603,2,'2018-03-22 19:01:23'),(32,'5bef403d2dc011e88aa754e1adc540fa',604,2,'2018-03-22 19:01:23'),(33,'5bef40752dc011e88aa754e1adc540fa',605,2,'2018-03-22 19:01:23'),(34,'5bef40b52dc011e88aa754e1adc540fa',700,2,'2018-03-22 19:01:23'),(35,'5bef40fb2dc011e88aa754e1adc540fa',701,2,'2018-03-22 19:01:23'),(36,'5bef41372dc011e88aa754e1adc540fa',702,2,'2018-03-22 19:01:23'),(37,'5bef41702dc011e88aa754e1adc540fa',703,2,'2018-03-22 19:01:23'),(38,'5bef41af2dc011e88aa754e1adc540fa',704,2,'2018-03-22 19:01:23'),(39,'5bef41eb2dc011e88aa754e1adc540fa',800,2,'2018-03-22 19:01:23'),(40,'5bef42272dc011e88aa754e1adc540fa',801,2,'2018-03-22 19:01:23'),(41,'5bef42662dc011e88aa754e1adc540fa',3,3,'2018-03-22 19:01:23'),(42,'5bef42a22dc011e88aa754e1adc540fa',900,3,'2018-03-22 19:01:23'),(43,'5bef42de2dc011e88aa754e1adc540fa',901,3,'2018-03-22 19:01:23'),(44,'5bef431a2dc011e88aa754e1adc540fa',902,3,'2018-03-22 19:01:23'),(45,'5bef43562dc011e88aa754e1adc540fa',903,3,'2018-03-22 19:01:23'),(46,'5bef43962dc011e88aa754e1adc540fa',904,3,'2018-03-22 19:01:23'),(47,'5bef43d52dc011e88aa754e1adc540fa',4,4,'2018-03-22 19:01:23'),(48,'5bef44112dc011e88aa754e1adc540fa',1000,4,'2018-03-22 19:01:23'),(49,'5bef444d2dc011e88aa754e1adc540fa',1001,4,'2018-03-22 19:01:23'),(50,'5bef44892dc011e88aa754e1adc540fa',5,5,'2018-03-22 19:01:23'),(51,'5bef44c52dc011e88aa754e1adc540fa',2000,5,'2018-03-22 19:01:23'),(52,'5bef45042dc011e88aa754e1adc540fa',2001,5,'2018-03-22 19:01:23'),(53,'5bef45402dc011e88aa754e1adc540fa',2002,5,'2018-03-22 19:01:23'),(54,'5bef45802dc011e88aa754e1adc540fa',0,6,'2018-03-22 19:01:23'),(55,'5bef45bf2dc011e88aa754e1adc540fa',0,7,'2018-03-22 19:01:23');

/*Table structure for table `fixture_filter_roleauthority_default` */

DROP TABLE IF EXISTS `fixture_filter_roleauthority_default`;

CREATE TABLE `fixture_filter_roleauthority_default` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `roleid` int(11) DEFAULT NULL COMMENT '默认角色id',
  `authorityoperationitemid` int(11) DEFAULT NULL COMMENT '业务功能id 0代表所有功能，个别的使用具体itemid值',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='过滤 - 默认角色权限';

/*Data for the table `fixture_filter_roleauthority_default` */

insert  into `fixture_filter_roleauthority_default`(`id`,`uuid`,`roleid`,`authorityoperationitemid`,`created_at`) values (1,'c21cd5b32dbd11e88aa754e1adc540fa',1,0,'2018-03-22 18:42:33'),(2,'16db02932dbe11e88aa754e1adc540fa',2,0,'2018-03-22 18:42:36');

/*Table structure for table `fixture_filter_userauth` */

DROP TABLE IF EXISTS `fixture_filter_userauth`;

CREATE TABLE `fixture_filter_userauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id',
  `roleflag` tinyint(1) DEFAULT '0' COMMENT '角色分类 ，默认0， 0默认角色  1自动以角色',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='过滤 - 用户角色';

/*Data for the table `fixture_filter_userauth` */

insert  into `fixture_filter_userauth`(`id`,`uuid`,`userid`,`roleid`,`roleflag`,`created_at`,`updated_at`) values (1,'3b00cccd2e4011e8b20154e1adc540fa',1,1,0,'2018-03-23 10:16:43',NULL),(2,'3b00ce2a2e4011e8b20154e1adc540fa',2,1,0,'2018-03-23 10:16:43',NULL),(3,'3b00ce982e4011e8b20154e1adc540fa',3,2,0,'2018-03-23 10:16:43',NULL),(4,'3b00cede2e4011e8b20154e1adc540fa',5,2,0,'2018-03-23 10:16:43',NULL),(5,'3b00cf2c2e4011e8b20154e1adc540fa',7,2,0,'2018-03-23 10:16:43',NULL),(6,'3b00cf722e4011e8b20154e1adc540fa',9,2,0,'2018-03-23 10:16:43',NULL),(7,'3b00cfb52e4011e8b20154e1adc540fa',11,2,0,'2018-03-23 10:16:43',NULL),(8,'3b00cff82e4011e8b20154e1adc540fa',13,2,0,'2018-03-23 10:16:43',NULL),(9,'3b00d03b2e4011e8b20154e1adc540fa',15,2,0,'2018-03-23 10:16:43',NULL),(10,'3b00d07b2e4011e8b20154e1adc540fa',4,1,1,'2018-03-23 10:16:43',NULL),(11,'3b00d0be2e4011e8b20154e1adc540fa',6,2,1,'2018-03-23 10:16:43',NULL),(12,'3b00d1122e4011e8b20154e1adc540fa',8,3,1,'2018-03-23 10:16:43',NULL),(13,'3b00d1872e4011e8b20154e1adc540fa',10,4,1,'2018-03-23 10:16:43',NULL),(14,'3b00d1c62e4011e8b20154e1adc540fa',12,5,1,'2018-03-23 10:16:43',NULL),(15,'3b00d2092e4011e8b20154e1adc540fa',14,6,1,'2018-03-23 10:16:43',NULL),(16,'3b00d2492e4011e8b20154e1adc540fa',16,7,1,'2018-03-23 10:16:43',NULL);

/*Table structure for table `fixture_log_vipupgrade` */

DROP TABLE IF EXISTS `fixture_log_vipupgrade`;

CREATE TABLE `fixture_log_vipupgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `vipmechanismid` int(11) DEFAULT NULL COMMENT '会员机制id，默认 标准版',
  `deadline` datetime DEFAULT NULL COMMENT '过期时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员机制升级记录';

/*Data for the table `fixture_log_vipupgrade` */

/*Table structure for table `fixture_loginvalidate` */

DROP TABLE IF EXISTS `fixture_loginvalidate`;

CREATE TABLE `fixture_loginvalidate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `table` varchar(100) DEFAULT NULL COMMENT '表名称',
  `tablesign` tinyint(1) DEFAULT NULL COMMENT '表标识 1用户  2参与者  3观光团',
  `wechatopenid` varchar(100) DEFAULT NULL COMMENT '微信openid',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型，默认1， 0=B端用户  1=C端用户',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='B-C端分发登录';

/*Data for the table `fixture_loginvalidate` */

/*Table structure for table `fixture_ouristparty` */

DROP TABLE IF EXISTS `fixture_ouristparty`;

CREATE TABLE `fixture_ouristparty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `nickname` varchar(200) DEFAULT NULL COMMENT '昵称',
  `faceimg` longtext COMMENT '头像',
  `wechatopenid` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='观光团';

/*Data for the table `fixture_ouristparty` */

/*Table structure for table `fixture_qa_feedback` */

DROP TABLE IF EXISTS `fixture_qa_feedback`;

CREATE TABLE `fixture_qa_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `content` text,
  `isdealit` tinyint(1) DEFAULT '0' COMMENT '是否处理，默认0，0未处理  1已处理',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='问题 - 反馈';

/*Data for the table `fixture_qa_feedback` */

/*Table structure for table `fixture_site` */

DROP TABLE IF EXISTS `fixture_site`;

CREATE TABLE `fixture_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `stagetemplateid` int(11) DEFAULT NULL COMMENT '阶段id （最新一次）  默认阶段模板id 或 自定义阶段模板id',
  `isdefaulttemplate` tinyint(1) DEFAULT '0' COMMENT '是否默认的阶段模板id',
  `roomtypeid` int(11) DEFAULT NULL COMMENT '户型id',
  `roomstyleid` int(11) DEFAULT NULL COMMENT '风格id',
  `renovationmodeid` int(11) DEFAULT NULL COMMENT '装修方式id',
  `budget` int(11) DEFAULT NULL COMMENT '预算 单位万元',
  `housename` int(11) DEFAULT NULL COMMENT '楼盘名称 地图自动解析',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `addr` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `lng` varchar(30) DEFAULT NULL COMMENT '经度',
  `lat` varchar(30) DEFAULT NULL COMMENT '维度',
  `doornumber` varchar(100) DEFAULT NULL COMMENT '门牌',
  `acreage` decimal(5,2) DEFAULT NULL COMMENT '面积-平方米 不包含单位',
  `roomshap` varchar(20) DEFAULT NULL COMMENT '房型 几室几厅几厨几卫',
  `explodedossurl` longtext COMMENT '展示图',
  `isopen` tinyint(1) DEFAULT '1' COMMENT '是否公开（允许项目被其他人发现）默认1,1公开 0不公开',
  `stagetype` tinyint(1) DEFAULT '0' COMMENT '更新阶段者类型，默认0， 0用户 1参与者 （最新一次） ',
  `isfinish` tinyint(1) DEFAULT '0' COMMENT '是否完工，默认0， 1完工 0未完工',
  `createuserid` int(11) DEFAULT NULL COMMENT '创建者id 对应user表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工地';

/*Data for the table `fixture_site` */

/*Table structure for table `fixture_site_followrecord` */

DROP TABLE IF EXISTS `fixture_site_followrecord`;

CREATE TABLE `fixture_site_followrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `siteid` int(11) DEFAULT NULL COMMENT '工地id',
  `followuserid` int(11) DEFAULT NULL COMMENT '观光团id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='观光团关注的工地';

/*Data for the table `fixture_site_followrecord` */

/*Table structure for table `fixture_site_participant` */

DROP TABLE IF EXISTS `fixture_site_participant`;

CREATE TABLE `fixture_site_participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `siteid` int(11) DEFAULT NULL COMMENT '工地id',
  `positionid` int(11) DEFAULT NULL COMMENT '职位id',
  `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
  `faceimg` longtext COMMENT '头像',
  `wechatopenid` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工地参与者（团队成员）';

/*Data for the table `fixture_site_participant` */

/*Table structure for table `fixture_site_stageschedule` */

DROP TABLE IF EXISTS `fixture_site_stageschedule`;

CREATE TABLE `fixture_site_stageschedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `dynamicid` int(11) DEFAULT NULL COMMENT '动态id',
  `siteid` int(11) DEFAULT NULL COMMENT '工地id',
  `stagetagid` int(11) DEFAULT NULL COMMENT '阶段id',
  `isstagedefault` tinyint(1) DEFAULT '0' COMMENT '是否默认阶段模板的阶段',
  `tablesign` tinyint(1) DEFAULT NULL COMMENT '表 1用户  2参与者  ',
  `stageuserid` int(11) DEFAULT NULL COMMENT '更新着id  用户表 和参与者表',
  `positionid` int(11) DEFAULT NULL COMMENT '阶段更新者职位id',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工地阶段进度记录';

/*Data for the table `fixture_site_stageschedule` */

/*Table structure for table `fixture_store` */

DROP TABLE IF EXISTS `fixture_store`;

CREATE TABLE `fixture_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `addr` varchar(255) DEFAULT NULL COMMENT '地址',
  `fulladdr` text COMMENT '省+市+地址',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='门店';

/*Data for the table `fixture_store` */

insert  into `fixture_store`(`id`,`uuid`,`companyid`,`cityid`,`name`,`addr`,`fulladdr`,`created_at`,`updated_at`) values (1,'a85dd50e2d8411e88aa754e1adc540fa',1,1,'jimu门店1','未央区凤城八路1号','陕西省西安市未央区凤城八路1号','2018-03-22 11:47:57',NULL),(2,'b2aed97b2d8411e88aa754e1adc540fa',1,1,'jimu门店2','未央区太华北路3号','陕西省西安市未央区太华北路3号','2018-03-22 11:47:59',NULL),(3,'b6e64fc32d8411e88aa754e1adc540fa',1,1,'jimu门店3','高新区高新一路4号','陕西省西安市高新区高新一路4号','2018-03-22 11:48:01',NULL),(4,'c29d944d2d8411e88aa754e1adc540fa',1,1,'jimu门店4','高新区软件园5号','陕西省西安市高新区软件园5号','2018-03-22 11:48:04',NULL),(5,'c7e845222d8411e88aa754e1adc540fa',2,1,'mogu门店1','高科广场1座','陕西省西安市高科广场1座','2018-03-22 11:57:34',NULL),(6,'cb1d59752d8411e88aa754e1adc540fa',2,1,'mogu门店2','新时代广场2座','陕西省西安市新时代广场2座','2018-03-22 11:57:37',NULL),(7,'ce36ae552d8411e88aa754e1adc540fa',2,1,'mogu门店3','智慧广场3座','陕西省西安市智慧广场3座','2018-03-22 11:57:39',NULL);

/*Table structure for table `fixture_user` */

DROP TABLE IF EXISTS `fixture_user`;

CREATE TABLE `fixture_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `username` varchar(20) DEFAULT NULL COMMENT '用户账号，系统自动生成 字母+数字，随机字符串 ',
  `phone` varchar(30) DEFAULT NULL COMMENT '手机号',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `nickname` varchar(100) DEFAULT NULL COMMENT '昵称',
  `resume` varchar(255) DEFAULT NULL COMMENT '个人简介',
  `faceimg` longtext COMMENT '头像',
  `wechatopenid` varchar(100) DEFAULT NULL COMMENT '微信openid',
  `isadmin` tinyint(1) DEFAULT NULL COMMENT '是否管理员，无默认， 0非管理员  1门店管理员 2总管理员  ',
  `isblankout` tinyint(1) DEFAULT '1' COMMENT '是否作废 ，默认1,1正常 0作废',
  `status` tinyint(1) DEFAULT '1' COMMENT '当前进行中账号状态 ，默认1, 1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='用户';

/*Data for the table `fixture_user` */

insert  into `fixture_user`(`id`,`uuid`,`companyid`,`storeid`,`cityid`,`username`,`phone`,`password`,`nickname`,`resume`,`faceimg`,`wechatopenid`,`isadmin`,`isblankout`,`status`,`created_at`,`updated_at`) values (1,'30b06afa2e3b11e8b20154e1adc540fa',1,NULL,1,'supperadmin','18092013099','69f59c3285a0b5ed113d013cd7caa018','admin','我们加油！',NULL,NULL,2,1,1,'2018-03-23 09:40:38','2018-03-20 09:39:10'),(2,'30b06bff2e3b11e8b20154e1adc540fa',2,NULL,1,'supperadmin','15002960399','69f59c3285a0b5ed113d013cd7caa018','admin','我们加油！',NULL,NULL,2,1,1,'2018-03-23 09:40:38','2018-03-22 02:34:16'),(3,'30b06c372e3b11e8b20154e1adc540fa',1,1,1,'jinmu1','18092013098','69f59c3285a0b5ed113d013cd7caa018','积木1','积木家庭1我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(4,'30b06d152e3b11e8b20154e1adc540fa',1,1,1,'jinmuauto1','18092013097','69f59c3285a0b5ed113d013cd7caa018','积木自定义1','积木家庭自定义1我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(5,'30b06e2c2e3b11e8b20154e1adc540fa',1,2,1,'jinmu2','18092013096','69f59c3285a0b5ed113d013cd7caa018','积木2','积木家庭2我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(6,'30b06ea02e3b11e8b20154e1adc540fa',1,2,1,'jinmuauto2','18092013095','69f59c3285a0b5ed113d013cd7caa018','积木自定义2','积木家庭自定义2我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(7,'30b06eff2e3b11e8b20154e1adc540fa',1,3,1,'jinmu3','18092013094','69f59c3285a0b5ed113d013cd7caa018','积木3','积木家庭3我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(8,'30b06f5b2e3b11e8b20154e1adc540fa',1,3,1,'jinmuauto3','18092013093','69f59c3285a0b5ed113d013cd7caa018','积木自定义3','积木家庭自定义3我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(9,'30b06fba2e3b11e8b20154e1adc540fa',1,4,1,'jinmu4','18092013092','69f59c3285a0b5ed113d013cd7caa018','积木4','积木家庭4我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(10,'30b070322e3b11e8b20154e1adc540fa',1,4,1,'jinmuauto4','18092013091','69f59c3285a0b5ed113d013cd7caa018','积木自定义4','积木家庭自定义4我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(11,'30b070b12e3b11e8b20154e1adc540fa',2,5,1,'jinmu5','15002960398','69f59c3285a0b5ed113d013cd7caa018','积木5','积木家庭5我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(12,'30b071452e3b11e8b20154e1adc540fa',2,5,1,'jinmuauto5','15002960397','69f59c3285a0b5ed113d013cd7caa018','积木自定义5','积木家庭自定义5我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(13,'30b0722a2e3b11e8b20154e1adc540fa',2,6,1,'jinmu6','15002960396','69f59c3285a0b5ed113d013cd7caa018','积木6','积木家庭6我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(14,'30b072f02e3b11e8b20154e1adc540fa',2,6,1,'jinmuauto6','15002960395','69f59c3285a0b5ed113d013cd7caa018','积木自定义6','积木家庭自定义6我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(15,'30b073882e3b11e8b20154e1adc540fa',2,7,1,'jinmu7','15002960394','69f59c3285a0b5ed113d013cd7caa018','积木7','积木家庭7我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL),(16,'30b074262e3b11e8b20154e1adc540fa',2,7,1,'jinmuauto7','15002960393','69f59c3285a0b5ed113d013cd7caa018','积木自定义7','积木家庭自定义7我们加油！',NULL,NULL,1,1,1,'2018-03-23 09:40:38',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
