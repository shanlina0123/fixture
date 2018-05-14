/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.5.5-10.1.31-MariaDB : Database - fixture
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fixture` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `fixture`;

/*Table structure for table `fixture_activity` */

DROP TABLE IF EXISTS `fixture_activity`;

CREATE TABLE `fixture_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL COMMENT '创建者id',
  `createuserid` int(11) DEFAULT NULL COMMENT '创建者id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `participatoryid` int(11) DEFAULT NULL COMMENT '活动参与方式id ',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `showurl` varchar(255) DEFAULT NULL COMMENT '封面图',
  `resume` varchar(255) DEFAULT NULL COMMENT '摘要 简述',
  `content` text COMMENT '内容',
  `isopen` tinyint(1) DEFAULT '1' COMMENT '是否公开 默认1  1所有显示  0只对成员显示',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1，0不显示 1显示',
  `userid` int(11) DEFAULT NULL COMMENT '用户id,对应用户表id',
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
  `userid` int(11) DEFAULT NULL COMMENT '观光团id,对应用户user表的id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='观光团参与的活动';

/*Data for the table `fixture_activity_inrecord` */

/*Table structure for table `fixture_client` */

DROP TABLE IF EXISTS `fixture_client`;

CREATE TABLE `fixture_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `sourcecateid` int(11) DEFAULT NULL COMMENT '客户来源分类 活动预约 观光团',
  `sourceid` int(11) DEFAULT NULL COMMENT '客户来源',
  `phone` varchar(30) DEFAULT NULL COMMENT '手机号',
  `name` varchar(200) DEFAULT NULL COMMENT '姓名',
  `area` int(11) DEFAULT NULL COMMENT '面积=平方米',
  `roomshap` varchar(20) DEFAULT NULL COMMENT '几室几厅几厨几卫',
  `content` text COMMENT '预约内容 （参观{xx工地}、免费量房、装修报价）',
  `wechatopenid` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `followstatusid` int(3) DEFAULT '4' COMMENT '客户跟进状态 ，默认4，对应 data_client_followstatus表，表中的4代表 未联系',
  `followcontent` varchar(255) DEFAULT NULL COMMENT '客户跟进备注',
  `userid` int(11) DEFAULT NULL COMMENT '邀请者id,对应用户user表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='C端活动录入的客户';

/*Data for the table `fixture_client` */

insert  into `fixture_client`(`id`,`uuid`,`companyid`,`storeid`,`sourcecateid`,`sourceid`,`phone`,`name`,`area`,`roomshap`,`content`,`wechatopenid`,`followstatusid`,`followcontent`,`userid`,`created_at`) values (3,'333',4,6,1,1,'15061025220','到完全',NULL,NULL,'大旗网大旗网 ',NULL,1,'的武器的',NULL,NULL);

/*Table structure for table `fixture_client_follow` */

DROP TABLE IF EXISTS `fixture_client_follow`;

CREATE TABLE `fixture_client_follow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uuid` char(32) DEFAULT NULL COMMENT 'uuid',
  `client_id` int(11) NOT NULL COMMENT '客户id',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `followstatus_id` int(11) NOT NULL COMMENT '跟进状态id',
  `follow_userid` int(11) NOT NULL COMMENT '跟进用户id',
  `follow_username` varchar(30) DEFAULT NULL COMMENT '跟进人',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='客户跟进记录';

/*Data for the table `fixture_client_follow` */

insert  into `fixture_client_follow`(`id`,`uuid`,`client_id`,`remarks`,`followstatus_id`,`follow_userid`,`follow_username`,`created_at`) values (1,'c1fe9073b9e721e14563d5b2c8a87b91',3,'测山川得到的武器的',3,17,NULL,'2018-05-03 06:50:18'),(2,'43f85ba1bb6805501c43483fbcfa6fea',3,'哈哈哈',2,17,NULL,'2018-05-03 07:08:44'),(3,'b5e464f758a19cd8ce011154857ddedf',3,'都完全户外群和',1,17,'哈哈','2018-05-11 09:50:58'),(4,'f66d2449f1eb85aae4f7e2a06514340f',3,'发的vv',3,17,'哈哈','2018-05-11 09:51:46'),(5,'8b6af6055617e8fdb9d48e61f4d05f21',3,'的武器的',1,17,'哈哈','2018-05-11 09:52:54');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='公司';

/*Data for the table `fixture_company` */

insert  into `fixture_company`(`id`,`uuid`,`vipmechanismid`,`provinceid`,`cityid`,`coucntryid`,`name`,`fullname`,`contacts`,`phone`,`addr`,`fulladdr`,`resume`,`logo`,`clientappid`,`deadline`,`created_at`,`updated_at`) values (1,'31645b462d8411e88aa754e1adc540fa',1,1,1,1,'积木家','西安积木家信息科技有限公司','总-张三','','龙首源8号','陕西省西安市龙首源8号','在互联网家装行业垂直市场，积木家专注为年轻人提供高品质低价格的互联网整居全包装修服务。',NULL,NULL,'2019-03-22 11:35:23','2018-03-22 11:35:41',NULL),(2,'a06291162d8411e88aa754e1adc540fa',1,1,1,2,'蘑菇家','西安蘑菇网科技有限公司','总-张四','','未央湖2号','陕西省西安市未央湖2号','整体家装,就选蘑菇加。蘑菇加,亚厦股份旗下互联网家装品牌。',NULL,NULL,'2019-03-22 11:37:26','2018-03-22 11:37:36',NULL),(3,'95bf5307ef7f4da54716d40867620444',NULL,140000,140200,140211,'啥活动','啥活动商场','的武器的',NULL,'的地位得到完全得到','山西大同市南郊区','的武器大全我青蛙打网球我的武器',NULL,'32222wwwww',NULL,'2018-03-25 09:44:30','2018-03-25 09:44:30'),(4,'6b5783e0af9dd8beaf17519748f26630',NULL,120000,120100,120102,'啊啊啊','啊啊啊','的武器大全',NULL,'达娃打网球的','天津市辖区河东区','的武器大全的武器大全我','user/6b5783e0af9dd8beaf17519748f26630/REu5U5P99U73ffA45DhsnTBIPl7LxGYUjdKC0L9Z.jpeg','aaasddd2222222',NULL,'2018-03-25 10:12:07','2018-03-30 10:20:26'),(5,'7d8438aec28f5638e7b1d2d3a7dc2ca0',NULL,610000,610100,610112,'小灰灰','小灰灰','tttttt',NULL,'gshs trgwsy','陕西西安市未央区','ttttttttttttttttttt','user/7d8438aec28f5638e7b1d2d3a7dc2ca0/N2RaYv6jqJbXQSaTXKQ2PeMMDMv5POWr4PXJWYXp.jpeg','0jk12390000000000000000000',NULL,'2018-03-27 06:01:40','2018-03-27 06:01:40');

/*Table structure for table `fixture_company_stagetemplate` */

DROP TABLE IF EXISTS `fixture_company_stagetemplate`;

CREATE TABLE `fixture_company_stagetemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `defaulttemplateid` int(11) DEFAULT NULL COMMENT '系统模板id，对应系统模板 stagetemplate 表id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `isdefault` tinyint(1) DEFAULT '0' COMMENT '是否属于自定义默认模板 1是 0否',
  `issystem` tinyint(1) DEFAULT '0' COMMENT '1系统添加的模板0自定义添加的模板',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='公司 - 自定义阶段模板名称';

/*Data for the table `fixture_company_stagetemplate` */

insert  into `fixture_company_stagetemplate`(`id`,`uuid`,`companyid`,`defaulttemplateid`,`name`,`isdefault`,`issystem`,`status`,`created_at`) values (1,'e62180be2e8411e8b20154e1adc540fa',4,1,'自定义模板jimu1',0,1,1,'2018-03-23 18:28:18'),(2,'e621829a2e8411e8b20154e1adc540fa',1,NULL,'自定义模板jimu2',1,0,1,'2018-03-23 18:28:18'),(3,'e621830f2e8411e8b20154e1adc540fa',2,NULL,'自定义模板mogu1',0,0,1,'2018-03-23 18:28:18'),(13,'4bf2ea68c47daa849c06038141515913',4,NULL,'标准01',1,0,1,'2018-03-29 08:03:57'),(17,'2b8ec069a6fe332e75215a313fa948ce',4,NULL,'测试模板',0,0,1,'2018-05-09 18:37:00'),(26,'5dcd864bcb19e90f7ae9dfedc15aa563',4,2,'其他阶段模板',0,1,1,'2018-05-10 14:23:04');

/*Table structure for table `fixture_company_stagetemplate_tag` */

DROP TABLE IF EXISTS `fixture_company_stagetemplate_tag`;

CREATE TABLE `fixture_company_stagetemplate_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `stagetemplateid` int(11) DEFAULT NULL COMMENT '自动以阶段模板id',
  `name` varchar(100) DEFAULT NULL COMMENT '自定义阶段名称',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COMMENT='公司 - 自定义模板阶段';

/*Data for the table `fixture_company_stagetemplate_tag` */

insert  into `fixture_company_stagetemplate_tag`(`id`,`uuid`,`companyid`,`stagetemplateid`,`name`,`sort`,`status`,`created_at`,`updated_at`) values (1,'e639b3b42e8411e8b20154e1adc540fa',1,1,'jimu阶段1',NULL,1,'2018-03-23 18:28:18',NULL),(2,'e63a38992e8411e8b20154e1adc540fa',1,1,'jimu阶段2',NULL,1,'2018-03-23 18:28:18',NULL),(11,'e63a39462e8411e8b20154e1adc540fa',1,1,'jimu阶段3',NULL,1,'2018-03-23 18:28:18',NULL),(12,'e63a3a402e8411e8b20154e1adc540fa',1,1,'jimu阶段4',NULL,1,'2018-03-23 18:28:18',NULL),(13,'e63a3a982e8411e8b20154e1adc540fa',1,1,'jimu阶段5',NULL,1,'2018-03-23 18:28:18',NULL),(14,'e63a3ae22e8411e8b20154e1adc540fa',1,2,'jimu阶段6',NULL,1,'2018-03-23 18:28:18',NULL),(15,'e63a3b2c2e8411e8b20154e1adc540fa',1,2,'jimu阶段7',NULL,1,'2018-03-23 18:28:18',NULL),(16,'e63a3b6f2e8411e8b20154e1adc540fa',1,2,'jimu阶段8',NULL,1,'2018-03-23 18:28:18',NULL),(17,'e63a3bb22e8411e8b20154e1adc540fa',1,2,'jimu阶段9',NULL,1,'2018-03-23 18:28:18',NULL),(18,'e63a3bf92e8411e8b20154e1adc540fa',2,3,'mogu阶段1',NULL,1,'2018-03-23 18:28:18',NULL),(19,'e63a3c3f2e8411e8b20154e1adc540fa',2,3,'mogu阶段2',NULL,1,'2018-03-23 18:28:18',NULL),(20,'e63a3c862e8411e8b20154e1adc540fa',2,3,'mogu阶段3',NULL,1,'2018-03-23 18:28:18',NULL),(90,'0ae3165436040a191d61573e40924f68',4,13,'设1',0,1,'2018-05-09 18:30:45','2018-05-09 18:30:45'),(91,'2deca56ba90e25d71236d4853bab5076',4,13,'签2',1,1,'2018-05-09 18:30:45','2018-05-09 18:30:45'),(92,'3a49ae14d7c53da3397b26fbe8253786',4,13,'拆3',2,1,'2018-05-09 18:30:45','2018-05-09 18:30:45'),(93,'ef8248301a41123123de121390fb26c5',4,13,'水4',3,1,'2018-05-09 18:30:45','2018-05-09 18:30:45'),(94,'52b9374f3aba837a3fa3649ef4ba2fd2',4,13,'泥5',4,1,'2018-05-09 18:30:45','2018-05-09 18:30:45'),(95,'8d512d54fac8474648171523d8afb205',4,13,'油6',5,1,'2018-05-09 18:30:45','2018-05-09 18:30:45'),(96,'e978b701ed1ab9df8828768180202b74',4,13,'安7',6,1,'2018-05-09 18:30:45','2018-05-09 18:30:45'),(97,'57ef3b8a1c9634ee09efd58387712779',4,13,'完成',7,1,'2018-05-09 18:30:45','2018-05-09 18:30:45'),(98,'a6c64c6af085496279779775f67f249e',4,17,'00',0,1,'2018-05-09 18:37:00',NULL),(99,'d63e8bd81b833cbb11d024fc6f2599a2',4,17,'01',1,1,'2018-05-09 18:37:00',NULL),(100,'7765db901f4b01ab96e2e3215841d5ef',4,17,'02',2,1,'2018-05-09 18:37:00',NULL),(101,'0a8d015db392f6670384f01a97da0a42',4,17,'03',3,1,'2018-05-09 18:37:00',NULL),(102,'fe18b28671c4e196bc1afbcc7940c229',4,17,'04',4,1,'2018-05-09 18:37:00',NULL),(103,'f405e3fd18f467a06a59584b2f18e329',4,17,'05',5,1,'2018-05-09 18:37:00',NULL),(112,'a30ba402771b5865912c9a4cf693db8b',4,26,'签约',0,1,'2018-05-10 14:23:04',NULL),(113,'25942f03a2c316f28a679b7a9cf303e8',4,26,'软装',1,1,'2018-05-10 14:23:04',NULL),(114,'575592cb75d4c11fd4439dfd3874ae00',4,26,'入住',2,1,'2018-05-10 14:23:04',NULL),(115,'f42456ec034c3f5fc9f5a8ee15d5f4fa',4,26,'完工',3,1,'2018-05-10 14:23:04',NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='数据源 - 视野';

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='数据源 - 城市';

/*Data for the table `fixture_data_city` */

insert  into `fixture_data_city`(`id`,`name`,`provinceid`,`status`,`created_at`) values (1,'西安市',1,1,'2018-03-19 16:45:53'),(2,'太原市',2,1,'2018-05-08 17:02:31'),(3,'北京市',3,1,'2018-05-08 17:03:02');

/*Table structure for table `fixture_data_client_followstatus` */

DROP TABLE IF EXISTS `fixture_data_client_followstatus`;

CREATE TABLE `fixture_data_client_followstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='数据源 - 客户跟进状态';

/*Data for the table `fixture_data_client_followstatus` */

insert  into `fixture_data_client_followstatus`(`id`,`name`,`status`,`created_at`) values (1,'已联系',1,NULL),(2,'已上门',1,NULL),(3,'无效',1,NULL),(4,'未联系',1,NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='数据源 - 活动参与方式';

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据源 - 职位';

/*Data for the table `fixture_data_position` */

/*Table structure for table `fixture_data_province` */

DROP TABLE IF EXISTS `fixture_data_province`;

CREATE TABLE `fixture_data_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='数据源 - 省份';

/*Data for the table `fixture_data_province` */

insert  into `fixture_data_province`(`id`,`name`,`status`,`created_at`) values (1,'陕西省',1,'2018-03-19 16:45:30'),(2,'山西省',1,'2018-05-08 17:03:53'),(3,'北京省',1,'2018-05-09 17:04:16');

/*Table structure for table `fixture_data_renovationmode` */

DROP TABLE IF EXISTS `fixture_data_renovationmode`;

CREATE TABLE `fixture_data_renovationmode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='数据源 - 装修方式';

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='数据源 - 户型风格';

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='数据源 - 户型';

/*Data for the table `fixture_data_roomtype` */

insert  into `fixture_data_roomtype`(`id`,`name`,`status`,`created_at`) values (1,'别墅',1,'2018-03-19 16:37:09'),(2,'公寓',1,'2018-03-19 16:37:09'),(3,'普通住宅',1,'2018-03-19 16:37:09'),(4,'大平房',1,'2018-03-19 16:37:09'),(5,'老公房',1,'2018-03-19 16:37:09'),(6,'工装',1,'2018-03-19 16:37:09'),(7,'其他',1,'2018-03-19 16:37:09');

/*Table structure for table `fixture_data_source` */

DROP TABLE IF EXISTS `fixture_data_source`;

CREATE TABLE `fixture_data_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `sourcecateid` int(11) DEFAULT NULL COMMENT '来源分类id  对应sourcecate表id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='数据源 - 客户来源';

/*Data for the table `fixture_data_source` */

insert  into `fixture_data_source`(`id`,`name`,`sourcecateid`,`status`,`created_at`) values (1,'预约参观',NULL,1,'2018-03-19 16:42:04'),(2,'免费量房',NULL,1,'2018-03-19 16:42:04'),(3,'我要报名',NULL,1,'2018-03-19 16:42:04'),(4,'装修报价',NULL,1,'2018-03-19 16:42:04');

/*Table structure for table `fixture_data_sourcecate` */

DROP TABLE IF EXISTS `fixture_data_sourcecate`;

CREATE TABLE `fixture_data_sourcecate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '来源分类',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据源 - 客户来源分类';

/*Data for the table `fixture_data_sourcecate` */

/*Table structure for table `fixture_data_stagetemplate` */

DROP TABLE IF EXISTS `fixture_data_stagetemplate`;

CREATE TABLE `fixture_data_stagetemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `isdefault` tinyint(1) DEFAULT '0' COMMENT '1默认 0不是默认',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='数据源 - 默认阶段模板名称';

/*Data for the table `fixture_data_stagetemplate` */

insert  into `fixture_data_stagetemplate`(`id`,`uuid`,`name`,`status`,`isdefault`,`created_at`) values (1,'0d8455612e8411e8b20154e1adc540fa','标准阶段模板',1,1,'2018-03-23 18:22:15'),(2,'0d8456152e8411e8b20154e1adc540fa','其他阶段模板',1,0,'2018-03-23 18:22:15');

/*Table structure for table `fixture_data_stagetemplate_tag` */

DROP TABLE IF EXISTS `fixture_data_stagetemplate_tag`;

CREATE TABLE `fixture_data_stagetemplate_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `stagetemplateid` int(11) DEFAULT NULL COMMENT '自动以阶段模板id',
  `name` varchar(100) DEFAULT NULL COMMENT '自定义阶段名称',
  `resume` varchar(100) DEFAULT NULL COMMENT '简述',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='数据源 - 默认模板阶段';

/*Data for the table `fixture_data_stagetemplate_tag` */

insert  into `fixture_data_stagetemplate_tag`(`id`,`uuid`,`stagetemplateid`,`name`,`resume`,`sort`,`status`,`created_at`,`updated_at`) values (1,'187c83292e8411e8b20154e1adc540fa',1,'签约','包括了解装修公司等',NULL,1,'2018-03-23 18:22:33',NULL),(2,'187c84152e8411e8b20154e1adc540fa',1,'设计','确定房子风格类型',NULL,1,'2018-03-23 18:22:33',NULL),(11,'187c845f2e8411e8b20154e1adc540fa',1,'拆改','拆墙、砌墙、铲墙皮、拆暖气、换塑钢窗',NULL,1,'2018-03-23 18:22:33',NULL),(12,'187c854c2e8411e8b20154e1adc540fa',1,'水电','开线槽、铺设管道',NULL,1,'2018-03-23 18:22:33',NULL),(13,'187c85ff2e8411e8b20154e1adc540fa',1,'泥木','瓷砖、吊顶',NULL,1,'2018-03-23 18:22:33',NULL),(14,'187c867b2e8411e8b20154e1adc540fa',1,'油漆','油漆',NULL,1,'2018-03-23 18:22:33',NULL),(15,'187c86e82e8411e8b20154e1adc540fa',1,'安装','橱柜、木门等安装',NULL,1,'2018-03-23 18:22:33',NULL),(16,'187c87552e8411e8b20154e1adc540fa',1,'软装','家具家电等',NULL,1,'2018-03-23 18:22:33',NULL),(17,'187c87bc2e8411e8b20154e1adc540fa',1,'入住','入住新房',NULL,1,'2018-03-23 18:22:33',NULL),(18,'187c88372e8411e8b20154e1adc540fa',1,'完工','结束装修',NULL,1,'2018-03-23 18:22:33',NULL),(19,'187c88ab2e8411e8b20154e1adc540fa',2,'签约','包括了解装修公司等',NULL,1,'2018-03-23 18:22:33',NULL),(20,'187c89202e8411e8b20154e1adc540fa',2,'软装','家具家电等',NULL,1,'2018-03-23 18:22:33',NULL),(21,'187c89942e8411e8b20154e1adc540fa',2,'入住','入住新房',NULL,1,'2018-03-23 18:22:33',NULL),(22,'187c8a092e8411e8b20154e1adc540fa',2,'完工','结束装修',NULL,1,'2018-03-23 18:22:33',NULL);

/*Table structure for table `fixture_data_vipmechanism` */

DROP TABLE IF EXISTS `fixture_data_vipmechanism`;

CREATE TABLE `fixture_data_vipmechanism` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据源 - 会员机制';

/*Data for the table `fixture_data_vipmechanism` */

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
  `title` varchar(200) DEFAULT NULL COMMENT '标题 活动',
  `resume` varchar(255) DEFAULT NULL COMMENT '简要文本 活动',
  `content` text COMMENT '内容',
  `type` tinyint(1) DEFAULT '0' COMMENT '类型 0工地动态 1活动动态',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1，1显示  0不显示  2只对成员显示',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='动态';

/*Data for the table `fixture_dynamic` */

insert  into `fixture_dynamic`(`id`,`uuid`,`companyid`,`storeid`,`sitetid`,`activityid`,`participatoryid`,`tablesign`,`createuserid`,`title`,`resume`,`content`,`type`,`status`,`created_at`) values (21,'50bb8352407bc1a2156e66a6fe2702a2',4,0,17,NULL,NULL,1,17,NULL,NULL,'新建工地：感谢业主大大信任，金色润城今日开工啦。大吉大利，家宅平安!',0,1,'2018-03-29 03:55:49'),(22,'f16370ba2f8916fc126b5a95745f44f0',4,NULL,17,NULL,NULL,1,17,NULL,NULL,'分为氛围',0,1,'2018-03-30 09:07:26'),(26,'308653f32a347b4dabc5342934aeb024',4,0,24,NULL,NULL,1,17,NULL,NULL,'新建工地：感谢业主大大信任，hdaudh今日开工啦。大吉大利，家宅平安!',0,1,'2018-05-08 19:14:50'),(28,'3055103262e31b5ef0d958c48e77cb43',4,NULL,25,NULL,NULL,1,17,NULL,NULL,'fdwefwe',0,1,'2018-05-09 14:47:26'),(29,'a07e60a35f523d1734a6314533e9e572',4,NULL,24,NULL,NULL,1,17,NULL,NULL,'的大范围',0,1,'2018-05-09 14:53:45'),(30,'6548406accf57ed9dfda029269810bd2',4,NULL,24,NULL,NULL,1,17,NULL,NULL,'是带我去带我去的',0,1,'2018-05-09 15:37:20'),(31,'31e33f09da267b7524ed22aa08f223a6',4,NULL,22,NULL,NULL,1,17,NULL,NULL,'得的',0,1,'2018-05-09 15:41:01'),(32,'e7628b9c378e5ed5c6b825b90bb8003e',4,NULL,22,NULL,NULL,1,17,NULL,NULL,'嗯我让他吩咐',0,1,'2018-05-09 15:42:32'),(34,'c1db63168bd7735d7683b9c39436cc20',4,6,19,NULL,NULL,1,17,NULL,NULL,'新建工地：感谢业主大大信任，测试工地今日开工啦。大吉大利，家宅平安!',0,1,'2018-05-10 14:53:09'),(35,'ca3716bf1e4ca4f479c0de46f78a1638',4,6,19,NULL,NULL,1,17,NULL,NULL,'测试跟新',0,1,'2018-05-10 14:57:13'),(36,'c60e4f92b8ae1e0e69f8478cbf64bf0f',4,6,19,NULL,NULL,1,17,NULL,NULL,'和AH',0,1,'2018-05-11 17:02:29');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='动态-图片视频';

/*Data for the table `fixture_dynamic_images` */

insert  into `fixture_dynamic_images`(`id`,`dynamicid`,`ossurl`,`type`,`created_at`) values (1,28,'site/28/dynamic/Fa0MmqDUdjyV8FFm4UEmnWHYFBSyOItfbVhYq6Jh.jpeg',0,'2018-05-09 14:47:26'),(2,28,'site/28/dynamic/M0Ej6VCceeRU634rhInLu9RpoBpe6vCFPg1H7H63.jpeg',0,'2018-05-09 14:47:26'),(3,30,'site/6548406accf57ed9dfda029269810bd2/dynamic/Plzs9caqXfhI7vZJlFvMdbtaBg1Q2tmWvishWNmP.jpeg',0,'2018-05-09 15:37:20'),(4,31,'site/31/dynamic/OqRfMMTCARvWmqW3Y490iYn9WZsndlQE8Y6znwCy.jpeg',0,'2018-05-09 15:41:01'),(5,32,'site/e7628b9c378e5ed5c6b825b90bb8003e/dynamic/TirOHAqSxHINd0jjCtTSOvx7f4w6jkxXwmr6Bd1w.jpeg',0,'2018-05-09 15:42:33'),(6,35,'site/8198a8edea026af729baa9bce46f9574/dynamic/wNjYjSeDvafkuPmXwlRnA6AtfuFz9cF8zR4uABx3.jpeg',0,'2018-05-10 14:57:13');

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

/*Table structure for table `fixture_filter_function` */

DROP TABLE IF EXISTS `fixture_filter_function`;

CREATE TABLE `fixture_filter_function` (
  `id` int(11) NOT NULL COMMENT '编号',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称',
  `pid` int(11) DEFAULT NULL COMMENT '父类id',
  `sort` int(11) DEFAULT '2' COMMENT '视野,默认2， 0全部 1城市 2个人  ',
  `ismenu` tinyint(1) DEFAULT NULL COMMENT '是否菜单显示 1显示 0不显示',
  `menuname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '菜单显示名称',
  `level` tinyint(1) DEFAULT NULL COMMENT '层级',
  `controller` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '接口地址  和真实一样',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '访问路径',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1可用 0 不可用',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='过滤 - 功能';

/*Data for the table `fixture_filter_function` */

insert  into `fixture_filter_function`(`id`,`uuid`,`name`,`pid`,`sort`,`ismenu`,`menuname`,`level`,`controller`,`url`,`status`,`created_at`) values (1,NULL,'角色管理',0,1,1,'角色管理',1,'RolesController','/roles',1,'2018-05-09 15:07:00'),(2,NULL,'用户管理',0,2,1,'用户管理',1,'AdminController','/admin',1,'2018-05-09 15:08:10'),(200,NULL,'列表',2,2,1,'用户列表',2,'AdminController','/admin/list',1,'2018-05-09 15:11:27'),(201,NULL,'新增',2,2,1,'新增',NULL,'AdminController',NULL,1,'2018-05-10 11:10:46');

/*Table structure for table `fixture_filter_role` */

DROP TABLE IF EXISTS `fixture_filter_role`;

CREATE TABLE `fixture_filter_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公司id 对应公司表company的id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1可用 0 不可用',
  `isdefault` tinyint(1) DEFAULT '0' COMMENT '是否默认 1默认 0非默认 ， 默认的不能删除',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `userid` int(11) DEFAULT NULL COMMENT '创建者id,对应用户user表id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='过滤 - 角色';

/*Data for the table `fixture_filter_role` */

insert  into `fixture_filter_role`(`id`,`uuid`,`name`,`status`,`isdefault`,`companyid`,`storeid`,`cityid`,`userid`,`created_at`,`updated_at`) values (1,'4a7fd8cb371511e89ce094de807e34a0','管理员',1,1,NULL,NULL,NULL,NULL,'2018-04-03 16:02:01',NULL),(2,'4a800506371511e89ce094de807e34a0','门店管理员',1,1,NULL,NULL,NULL,NULL,'2018-04-03 16:02:01','0000-00-00 00:00:00'),(32,'bc6f3e38dd19753a848c5e3cc09abe48','操作员',1,0,NULL,NULL,NULL,NULL,'2018-05-10 20:49:45','2018-05-10 20:50:45');

/*Table structure for table `fixture_filter_role_function` */

DROP TABLE IF EXISTS `fixture_filter_role_function`;

CREATE TABLE `fixture_filter_role_function` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id 对应role表id',
  `functionid` int(11) DEFAULT NULL COMMENT '功能id 对应功能表function的id',
  `islook` tinyint(1) DEFAULT '1' COMMENT '视野范围，默认3,1全部 2城市 3门店 4部分门店',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='过滤 - 角色功能';

/*Data for the table `fixture_filter_role_function` */

/*Table structure for table `fixture_log_message` */

DROP TABLE IF EXISTS `fixture_log_message`;

CREATE TABLE `fixture_log_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nickname` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `typename` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '关注  、赞、评论',
  `typeid` tinyint(1) DEFAULT NULL COMMENT '类型id 1关注 2赞 3 评论',
  `siteid` int(11) DEFAULT NULL COMMENT '来源工地id,工地名称',
  `sitename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activityid` int(11) DEFAULT NULL COMMENT '来源活动id',
  `activityname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '来源活动名称',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='消息 - 通知';

/*Data for the table `fixture_log_message` */

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
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `stageid` int(11) DEFAULT NULL COMMENT '阶段id （最新一次）  ',
  `stagetemplateid` int(11) DEFAULT NULL COMMENT '阶段模板id',
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='工地';

/*Data for the table `fixture_site` */

insert  into `fixture_site`(`id`,`uuid`,`companyid`,`storeid`,`cityid`,`stageid`,`stagetemplateid`,`roomtypeid`,`roomstyleid`,`renovationmodeid`,`budget`,`housename`,`name`,`addr`,`lng`,`lat`,`doornumber`,`acreage`,`roomshap`,`explodedossurl`,`isopen`,`stagetype`,`isfinish`,`createuserid`,`created_at`,`updated_at`) values (1,'8535cee4506ab19f7699a2edc4cf4f26',NULL,6,NULL,NULL,1,1,2,2,111,NULL,NULL,'二分五分',NULL,NULL,'范围范围发','11.00','1室1厅1厨1卫',NULL,0,0,0,17,'2018-03-25 09:27:51','2018-03-25 09:27:51'),(17,'919af2486be879365be7dcd4430bb33e',4,6,NULL,2,1,4,4,1,13,NULL,'金色润城','龙首南路101',NULL,NULL,'202','80.00','3室1厅1厨1卫','site/919af2486be879365be7dcd4430bb33e/info/bmk9XtuCIFhDkfRRvPWZMfg6dcr7WKF6N2EzHGk0.jpeg',1,0,0,17,'2018-03-29 03:55:49','2018-05-11 17:56:03'),(19,'8198a8edea026af729baa9bce46f9574',4,6,1,113,26,2,1,1,30,NULL,'测试工地','陕西省西安市新城区龙首中路龙首东北住宅小区(宫园1号东)','108.950134277','34.290740967','208','202.00','1室1厅1厨1卫','site/8198a8edea026af729baa9bce46f9574/info/E0WMzmwvzfcXV9x0Ud2Mfg1w9bkSsbUXkJlAZPxs.jpeg',1,0,0,17,'2018-05-10 14:53:09','2018-05-11 17:02:37');

/*Table structure for table `fixture_site_followrecord` */

DROP TABLE IF EXISTS `fixture_site_followrecord`;

CREATE TABLE `fixture_site_followrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `siteid` int(11) DEFAULT NULL COMMENT '工地id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `userid` int(11) DEFAULT NULL COMMENT '观光团id，对应用户user表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='观光团关注的工地';

/*Data for the table `fixture_site_followrecord` */

/*Table structure for table `fixture_site_invitation` */

DROP TABLE IF EXISTS `fixture_site_invitation`;

CREATE TABLE `fixture_site_invitation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `siteid` int(11) DEFAULT NULL COMMENT '工地id',
  `userid` int(11) DEFAULT NULL COMMENT '邀请者id，对应用户user表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='参与者被邀请的工地';

/*Data for the table `fixture_site_invitation` */

/*Table structure for table `fixture_site_stageschedule` */

DROP TABLE IF EXISTS `fixture_site_stageschedule`;

CREATE TABLE `fixture_site_stageschedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `dynamicid` int(11) DEFAULT NULL COMMENT '动态id',
  `siteid` int(11) DEFAULT NULL COMMENT '工地id',
  `stagetagid` int(11) DEFAULT NULL COMMENT '阶段id',
  `tablesign` tinyint(1) DEFAULT NULL COMMENT '表 1用户  2参与者  ',
  `stageuserid` int(11) DEFAULT NULL COMMENT '更新着id  用户表 和参与者表',
  `positionid` int(11) DEFAULT NULL COMMENT '阶段更新者职位id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='工地阶段进度记录';

/*Data for the table `fixture_site_stageschedule` */

insert  into `fixture_site_stageschedule`(`id`,`uuid`,`dynamicid`,`siteid`,`stagetagid`,`tablesign`,`stageuserid`,`positionid`,`created_at`) values (13,'2f5410ec7c0822250d87a8e2254cac3d',21,17,12,1,17,17,'2018-03-29 03:55:49'),(14,'41527906932cabb2532d3b8729a05e3e',22,17,2,1,17,NULL,'2018-03-30 09:07:26'),(15,'6ed24d7bfa496677bff6f5c414402e4d',34,19,112,1,17,17,'2018-05-10 14:53:09'),(16,'ba19375b1f310758f34a7da1d7756030',35,19,113,1,17,NULL,'2018-05-10 14:57:13'),(17,'46e29562dcc5c02fcac10281d61fc829',36,19,114,1,17,NULL,'2018-05-11 17:02:29');

/*Table structure for table `fixture_sms_history` */

DROP TABLE IF EXISTS `fixture_sms_history`;

CREATE TABLE `fixture_sms_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `type` tinyint(1) DEFAULT '0' COMMENT '1用户发送 0 系统后台发送',
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '发送短信内容',
  `code` int(6) NOT NULL COMMENT '验证码',
  `phone` char(11) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手机号码',
  `created_at` datetime NOT NULL COMMENT '发送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='发送短息表';

/*Data for the table `fixture_sms_history` */

insert  into `fixture_sms_history`(`id`,`companyid`,`userid`,`type`,`content`,`code`,`phone`,`created_at`) values (1,4,NULL,1,'温馨提示:您修改手机号码的验证码为：864966请勿向他人泄露！',864966,'2147483647','2018-05-11 14:25:04'),(2,4,NULL,1,'温馨提示:您修改手机号码的验证码为：272636请勿向他人泄露！',272636,'2147483647','2018-05-11 14:26:23'),(3,4,NULL,1,'温馨提示:您修改手机号码的验证码为：920843请勿向他人泄露！',920843,'15094014770','2018-05-11 14:27:27'),(4,4,NULL,1,'温馨提示:您修改手机号码的验证码为：186661请勿向他人泄露！',186661,'15094014770','2018-05-11 14:31:06'),(5,4,NULL,1,'温馨提示:您修改手机号码的验证码为：092115请勿向他人泄露！',92115,'15094014770','2018-05-11 15:44:02'),(6,4,NULL,1,'温馨提示:您修改手机号码的验证码为：7784请勿向他人泄露！',7784,'15094014770','2018-05-11 15:45:03'),(7,4,NULL,1,'温馨提示:您修改手机号码的验证码为：0418请勿向他人泄露！',418,'15094014770','2018-05-11 15:46:45'),(8,4,NULL,1,'温馨提示:您修改手机号码的验证码为：2162请勿向他人泄露！',2162,'15094014770','2018-05-11 15:49:47'),(9,4,NULL,1,'温馨提示:您修改手机号码的验证码为：9743请勿向他人泄露！',9743,'15094014770','2018-05-11 15:51:53'),(10,4,NULL,1,'温馨提示:您修改手机号码的验证码为：6819请勿向他人泄露！',6819,'15094014770','2018-05-11 15:57:38'),(11,4,NULL,1,'温馨提示:您修改手机号码的验证码为：7510请勿向他人泄露！',7510,'15094014770','2018-05-11 16:01:40'),(12,4,NULL,1,'温馨提示:您修改密码的验证码为：4815请勿向他人泄露！',4815,'15094014770','2018-05-11 16:16:25'),(13,4,17,1,'温馨提示:您修改密码的验证码为：8318请勿向他人泄露！',8318,'15094014770','2018-05-11 16:24:40'),(14,4,17,1,'温馨提示:您修改密码的验证码为：7293请勿向他人泄露！',7293,'15094014770','2018-05-11 16:26:33'),(15,4,17,1,'温馨提示:您修改密码的验证码为：5224请勿向他人泄露！',5224,'15094014770','2018-05-11 16:27:23'),(16,4,17,1,'温馨提示:您修改密码的验证码为：9270请勿向他人泄露！',9270,'15094014770','2018-05-11 16:28:09'),(17,4,17,1,'温馨提示:您修改密码的验证码为：7266请勿向他人泄露！',7266,'15094014770','2018-05-11 16:30:35'),(18,4,17,1,'温馨提示:您修改密码的验证码为：5821请勿向他人泄露！',5821,'15094014770','2018-05-11 16:31:17'),(19,4,17,1,'温馨提示:您修改密码的验证码为：4467请勿向他人泄露！',4467,'15094014770','2018-05-11 16:34:30'),(20,4,17,1,'温馨提示:您修改密码的验证码为：7568请勿向他人泄露！',7568,'15094014770','2018-05-11 16:34:42'),(21,4,17,1,'温馨提示:您修改密码的验证码为：4812请勿向他人泄露！',4812,'15094014770','2018-05-11 16:44:37'),(22,0,0,1,'温馨提示:您登陆的验证码为：7010请勿向他人泄露！',7010,'15094014770','2018-05-11 17:32:23'),(23,0,0,1,'温馨提示:您登陆的验证码为：4476请勿向他人泄露！',4476,'15094014770','2018-05-11 17:40:25'),(24,0,0,1,'温馨提示:您登陆的验证码为：3613请勿向他人泄露！',3613,'15094014770','2018-05-11 17:51:08');

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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='门店';

/*Data for the table `fixture_store` */

insert  into `fixture_store`(`id`,`uuid`,`companyid`,`cityid`,`name`,`addr`,`fulladdr`,`created_at`,`updated_at`) values (1,'a85dd50e2d8411e88aa754e1adc540fa',1,1,'苗伟伟的店1','未央区凤城八路12号','陕西省西安市未央区凤城八路12号','2018-05-10 14:49:18','2018-05-10 14:49:18'),(2,'b2aed97b2d8411e88aa754e1adc540fa',1,2,'jimu门店2','未央区太华北路3号','陕西省西安市未央区太华北路3号','2018-03-22 11:47:59',NULL),(3,'b6e64fc32d8411e88aa754e1adc540fa',1,1,'jimu门店3','高新区高新一路4号','山西省西安市高新区高新一路4号','2018-05-10 11:54:51','0000-00-00 00:00:00'),(4,'c29d944d2d8411e88aa754e1adc540fa',1,1,'jimu门店4','高新区软件园5号','陕西省西安市高新区软件园5号','2018-03-22 11:48:04',NULL),(6,'c7e845222d8411e88aa754e1adc540fa',4,1,'mogu门店1','高科广场1座','陕西省西安市高科广场1座','2018-03-22 11:57:34',NULL),(30,'7e3668095f13ad7279dd6ba1fce5e9f1',1,1,'吾问无为谓','南门','陕西省西安市南门','2018-05-09 15:55:13',NULL),(34,'fd2b2c19da0c4bb54e4f5fa7194bbebd',1,1,'哈哈哈1','哈哈哈哈哈哈','陕西省西安市哈哈哈哈哈哈','2018-05-10 10:33:04','2018-05-10 10:33:04'),(39,'604b688af8bdaef526b11c3c381c1562',1,1,'对的的店等等233','请问231','北京省北京市请问231','2018-05-10 14:52:05',NULL),(40,'e0412b0b781f740c80ae95b03df10218',1,1,'1233','123213','陕西省西安市123213','2018-05-10 14:53:48','2018-05-10 14:53:48');

/*Table structure for table `fixture_user` */

DROP TABLE IF EXISTS `fixture_user`;

CREATE TABLE `fixture_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `positionid` int(11) DEFAULT NULL COMMENT '职位id',
  `username` varchar(20) DEFAULT NULL COMMENT '用户账号，系统自动生成 字母+数字，随机字符串 ',
  `phone` varchar(30) DEFAULT NULL COMMENT '手机号',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `nickname` varchar(200) DEFAULT NULL COMMENT '姓名/昵称',
  `resume` varchar(255) DEFAULT NULL COMMENT '个人简介',
  `faceimg` longtext COMMENT '头像',
  `wechatopenid` varchar(100) DEFAULT NULL COMMENT '微信openid',
  `isadmin` tinyint(1) DEFAULT '0' COMMENT '是否系统默认管理员，无默认，0不是 1是',
  `isadminafter` tinyint(1) DEFAULT '0' COMMENT '是否后端创建过来的 1是 0不是',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型 0B端用户 1C端用户 ',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id  对应role表id',
  `isinvitationed` tinyint(1) DEFAULT '0' COMMENT '是否是被邀请的参与者 1是 0不是',
  `isowner` tinyint(1) DEFAULT '0' COMMENT 'C端用户，是否业主 1是 0否',
  `isdefault` tinyint(1) DEFAULT '0' COMMENT '是否默认 0否 1是',
  `status` tinyint(1) DEFAULT '1' COMMENT '当前进行中账号状态 ，默认1, 1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='用户';

/*Data for the table `fixture_user` */

insert  into `fixture_user`(`id`,`uuid`,`companyid`,`storeid`,`cityid`,`positionid`,`username`,`phone`,`password`,`nickname`,`resume`,`faceimg`,`wechatopenid`,`isadmin`,`isadminafter`,`type`,`roleid`,`isinvitationed`,`isowner`,`isdefault`,`status`,`created_at`,`updated_at`) values (1,'30b06afa2e3b11e8b20154e1adc540fa',1,6,1,NULL,'supperadmin','18092013099','2e31d1a90952288bd5341f2a084d9fae','管理员','我们加油！',NULL,NULL,0,1,0,2,0,0,1,1,'2018-03-23 09:40:38','2018-05-11 00:26:10'),(2,'30b06bff2e3b11e8b20154e1adc540fa',2,NULL,1,NULL,'supperadmin','15002960399','69f59c3285a0b5ed113d013cd7caa018','管理员','我们加油！',NULL,NULL,1,1,0,1,0,0,1,1,'2018-03-23 09:40:38','2018-03-22 02:34:16'),(3,'30b06c372e3b11e8b20154e1adc540fa',1,1,1,NULL,'jinmu1','18092013098','69f59c3285a0b5ed113d013cd7caa018','积木1','积木家庭1我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38','2018-05-11 00:09:45'),(4,'30b06d152e3b11e8b20154e1adc540fa',1,1,1,NULL,'jinmuauto1','18092013097','69f59c3285a0b5ed113d013cd7caa018','积木自定义1','积木家庭自定义1我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(5,'30b06e2c2e3b11e8b20154e1adc540fa',1,2,1,NULL,'jinmu2','18092013096','69f59c3285a0b5ed113d013cd7caa018','积木2','积木家庭2我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(6,'30b06ea02e3b11e8b20154e1adc540fa',1,2,1,NULL,'jinmuauto2','18092013095','69f59c3285a0b5ed113d013cd7caa018','积木自定义2','积木家庭自定义2我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(7,'30b06eff2e3b11e8b20154e1adc540fa',1,3,1,NULL,'jinmu3','18092013094','69f59c3285a0b5ed113d013cd7caa018','积木3','积木家庭3我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(8,'30b06f5b2e3b11e8b20154e1adc540fa',1,3,1,NULL,'jinmuauto3','18092013093','69f59c3285a0b5ed113d013cd7caa018','积木自定义3','积木家庭自定义3我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(9,'30b06fba2e3b11e8b20154e1adc540fa',1,4,1,NULL,'jinmu4','18092013092','69f59c3285a0b5ed113d013cd7caa018','积木4','积木家庭4我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(10,'30b070322e3b11e8b20154e1adc540fa',1,4,1,NULL,'jinmuauto4','18092013091','69f59c3285a0b5ed113d013cd7caa018','积木自定义4','积木家庭自定义4我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(11,'30b070b12e3b11e8b20154e1adc540fa',2,5,1,NULL,'jinmu5','15002960398','69f59c3285a0b5ed113d013cd7caa018','积木5','积木家庭5我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(12,'30b071452e3b11e8b20154e1adc540fa',2,5,1,NULL,'jinmuauto5','15002960397','69f59c3285a0b5ed113d013cd7caa018','积木自定义5','积木家庭自定义5我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(13,'30b0722a2e3b11e8b20154e1adc540fa',2,6,1,NULL,'jinmu6','15002960396','69f59c3285a0b5ed113d013cd7caa018','积木6','积木家庭6我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(14,'30b072f02e3b11e8b20154e1adc540fa',2,6,1,NULL,'jinmuauto6','15002960395','69f59c3285a0b5ed113d013cd7caa018','积木自定义6','积木家庭自定义6我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(15,'30b073882e3b11e8b20154e1adc540fa',2,7,1,NULL,'jinmu7','15002960394','69f59c3285a0b5ed113d013cd7caa018','积木7','积木家庭7我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(16,'30b074262e3b11e8b20154e1adc540fa',2,7,1,NULL,'jinmuauto7','15002960393','69f59c3285a0b5ed113d013cd7caa018','积木自定义7','积木家庭自定义7我们加油！',NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-23 09:40:38',NULL),(17,'17f441f7a5be0505e4e1c09654384d24',4,6,1,NULL,'yyz_47002','15094014770','69f59c3285a0b5ed113d013cd7caa018','哈哈',NULL,NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-25 08:18:12','2018-05-11 16:34:58'),(18,'834bc9447ffb0520dc4a6441fbc15aff',5,NULL,NULL,NULL,NULL,'18691895593','5bb133ced94fa40723c44056ac035fb8',NULL,NULL,NULL,NULL,1,1,0,1,0,0,0,1,'2018-03-27 05:59:52','2018-03-27 06:01:40'),(19,'f599007a71208c9857939ef8722e05fc',NULL,NULL,NULL,NULL,'yyz_4700','15094014700','69f59c3285a0b5ed113d013cd7caa018',NULL,NULL,NULL,NULL,1,1,0,NULL,0,0,0,1,'2018-05-08 16:02:37','2018-05-08 16:02:37'),(20,'f19f3b8c72ff34f5d1a662656d434185',NULL,NULL,NULL,NULL,'yyz_4777','15094014777','9dc3e47661a34d3dede92bcb1c712761',NULL,NULL,NULL,NULL,1,1,0,NULL,0,0,0,1,'2018-05-08 16:03:58','2018-05-08 16:03:58');

/*Table structure for table `fixture_user_store` */

DROP TABLE IF EXISTS `fixture_user_store`;

CREATE TABLE `fixture_user_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id,对应门店store表id',
  `userid` int(11) DEFAULT NULL COMMENT 'B端用户id,对应用户user表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户 - 拥有的门店（以后针对视野为部分门店时的扩展表）';

/*Data for the table `fixture_user_store` */

/*Table structure for table `fixture_user_token` */

DROP TABLE IF EXISTS `fixture_user_token`;

CREATE TABLE `fixture_user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '生成的token',
  `expiration` int(11) DEFAULT NULL COMMENT '过期时间',
  `userid` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户id',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型，默认1， 0=B端用户  1=C端用户',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户 - token';

/*Data for the table `fixture_user_token` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
