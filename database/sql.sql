/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.5.5-10.1.30-MariaDB : Database - xxs_fixture
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
  `id` int(11) NOT NULL,
  `uuid` char(32) DEFAULT NULL,
  `activityid` int(11) DEFAULT NULL COMMENT '活动id',
  `userid` int(11) DEFAULT NULL COMMENT '观光团id,对应用户user表的id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='观光团参与的活动';

/*Data for the table `fixture_activity_inrecord` */

/*Table structure for table `fixture_activity_luck_num` */

DROP TABLE IF EXISTS `fixture_activity_luck_num`;

CREATE TABLE `fixture_activity_luck_num` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `activityluckyid` int(11) DEFAULT NULL COMMENT '抽奖活动id',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id',
  `chancenum` int(11) DEFAULT NULL COMMENT '个人总抽奖次数',
  `chanceusenum` int(11) DEFAULT NULL COMMENT '已使用的抽奖次数',
  `iswin` tinyint(1) DEFAULT '0' COMMENT '是否中奖 1已中奖 0未中奖',
  `friendhelpusenum` int(11) DEFAULT NULL COMMENT '已使用过的好友助力抽奖次数',
  `userid` int(11) DEFAULT NULL COMMENT '参与活动者 对应用户表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抽奖活动的统计数';

/*Data for the table `fixture_activity_luck_num` */

/*Table structure for table `fixture_activity_lucky` */

DROP TABLE IF EXISTS `fixture_activity_lucky`;

CREATE TABLE `fixture_activity_lucky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL COMMENT '创建者id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `sharetitle` varchar(255) DEFAULT NULL COMMENT '微信分享标题名称',
  `bgurl` varchar(255) DEFAULT NULL COMMENT '活动背景图',
  `makeurl` varchar(255) DEFAULT NULL COMMENT '立即抽奖图',
  `loseurl` varchar(255) DEFAULT NULL COMMENT '未中奖图',
  `resume` varchar(255) DEFAULT NULL COMMENT '摘要 简述',
  `startdate` datetime DEFAULT NULL COMMENT '开始日期',
  `enddate` datetime DEFAULT NULL COMMENT '结束日期',
  `ispeoplelimit` tinyint(1) DEFAULT '0' COMMENT '是否人数限制，默认 0，0不限制 1限制 ',
  `peoplelimitnum` int(11) DEFAULT NULL COMMENT '限制参与的人数',
  `ischancelimit` tinyint(1) DEFAULT '0' COMMENT '是否限制总抽奖机会 ，0不限制 1限制',
  `chancelimitnum` int(11) DEFAULT NULL COMMENT '每人最多的抽奖机会',
  `everywinnum` int(11) DEFAULT NULL COMMENT '每人中奖次数',
  `winpoint` decimal(10,2) DEFAULT NULL COMMENT '总中奖率,例如页面 30%=0.3,这意味着每10次抽奖3次获奖',
  `ishasconnectinfo` tinyint(1) DEFAULT '1' COMMENT '是否有联系信息  0无（关闭） 1有（参与前填写） 2有（参与后填写）',
  `isonline` tinyint(4) DEFAULT '1' COMMENT '是否上线 1上线 0下线',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1，0不显示 1显示',
  `userid` int(11) DEFAULT NULL COMMENT '创建者，对应用户表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抽奖活动';

/*Data for the table `fixture_activity_lucky` */

/*Table structure for table `fixture_activity_lucky_prize` */

DROP TABLE IF EXISTS `fixture_activity_lucky_prize`;

CREATE TABLE `fixture_activity_lucky_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `cityid` int(11) DEFAULT NULL COMMENT '城市id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `activityluckyid` int(11) DEFAULT NULL COMMENT '抽奖活动id',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num` int(11) DEFAULT NULL COMMENT '数量',
  `lastnum` int(11) DEFAULT NULL COMMENT '剩余数量',
  `levelid` int(11) DEFAULT NULL COMMENT '奖品等级id',
  `levelname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '奖品等级名称',
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userid` int(11) DEFAULT NULL COMMENT '创建者，对应用户表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='抽奖活动奖项';

/*Data for the table `fixture_activity_lucky_prize` */

/*Table structure for table `fixture_activity_lucky_record` */

DROP TABLE IF EXISTS `fixture_activity_lucky_record`;

CREATE TABLE `fixture_activity_lucky_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `activityluckid` int(11) DEFAULT NULL COMMENT '抽奖活动id',
  `prizeid` int(11) DEFAULT NULL COMMENT '奖品id',
  `prizename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '奖品',
  `clientid` int(11) DEFAULT NULL COMMENT '中奖者的id ,对应客户表id',
  `clientname` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '客户姓名',
  `iswin` tinyint(1) DEFAULT '0' COMMENT '是否中奖 1中奖 0未中奖',
  `userid` int(11) DEFAULT NULL COMMENT '抽奖者 对应用户表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='抽奖纪录';

/*Data for the table `fixture_activity_lucky_record` */

/*Table structure for table `fixture_client` */

DROP TABLE IF EXISTS `fixture_client`;

CREATE TABLE `fixture_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `cityid` int(11) DEFAULT NULL COMMENT '城市id',
  `sourcecateid` int(11) DEFAULT NULL COMMENT '客户来源分类',
  `sourceid` int(11) DEFAULT NULL COMMENT '客户来源',
  `phone` varchar(30) DEFAULT NULL COMMENT '手机号',
  `name` varchar(200) DEFAULT NULL COMMENT '姓名',
  `area` int(11) DEFAULT NULL COMMENT '面积=平方米',
  `roomshap` varchar(20) DEFAULT NULL COMMENT '几室几厅几厨几卫',
  `content` text COMMENT '预约内容、抽奖的活动名称 （参观{xx工地}、免费量房、装修报价）',
  `clientcity` varchar(255) DEFAULT NULL COMMENT '客户所在城市',
  `wechatopenid` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `followstatusid` int(3) DEFAULT '4' COMMENT '客户跟进状态 ，默认4，对应 data_client_followstatus表，表中的4代表 未联系',
  `followcontent` varchar(255) DEFAULT NULL COMMENT '客户跟进备注',
  `userid` int(11) DEFAULT NULL COMMENT '当前跟进者id,对应用户user表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='C端活动录入的客户';

/*Data for the table `fixture_client` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户跟进记录';

/*Data for the table `fixture_client_follow` */

/*Table structure for table `fixture_company` */

DROP TABLE IF EXISTS `fixture_company`;

CREATE TABLE `fixture_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `vipmechanismid` int(11) DEFAULT '1' COMMENT '会员机制id，默认 标准版',
  `provinceid` int(11) DEFAULT NULL COMMENT '省id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `coucntryid` int(11) DEFAULT NULL COMMENT '区id',
  `name` varchar(100) DEFAULT NULL COMMENT '公司名称',
  `fullname` varchar(255) DEFAULT NULL COMMENT '公司简称',
  `contacts` varchar(255) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(30) DEFAULT NULL COMMENT '联系方式',
  `addr` varchar(255) DEFAULT NULL COMMENT '地址',
  `fulladdr` varchar(255) DEFAULT NULL COMMENT '详情地址  省市区+地址',
  `resume` varchar(300) DEFAULT NULL COMMENT '公司简介',
  `logo` longtext COMMENT '企业logo',
  `clientappid` varchar(100) DEFAULT NULL COMMENT '客户小程序appid',
  `deadline` datetime DEFAULT NULL COMMENT '机制过期时间，过期后自动成为标准版（后台自动定期处理）',
  `covermap` varchar(255) DEFAULT NULL COMMENT '封面图',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司';

/*Data for the table `fixture_company` */

/*Table structure for table `fixture_company_mptemplate` */

DROP TABLE IF EXISTS `fixture_company_mptemplate`;

CREATE TABLE `fixture_company_mptemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `datatemplateid` int(11) DEFAULT NULL COMMENT '模板类型id,对应data_mptemplate表的id',
  `mptemplateid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信公众号号模板id',
  `status` tinyint(1) DEFAULT '1' COMMENT '是否禁用  1正常 0关闭',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='公司 - 设置的微信公众号服务通知模板';

/*Data for the table `fixture_company_mptemplate` */

/*Table structure for table `fixture_company_participant` */

DROP TABLE IF EXISTS `fixture_company_participant`;

CREATE TABLE `fixture_company_participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `positionid` int(11) DEFAULT NULL COMMENT '职位id',
  `name` varchar(255) DEFAULT NULL COMMENT '姓名，也就是对用户昵称的一个别名',
  `userid` int(11) DEFAULT NULL COMMENT '创建者id,对应用户表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='公司 - 成员';

/*Data for the table `fixture_company_participant` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司 - 自定义阶段模板名称';

/*Data for the table `fixture_company_stagetemplate` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司 - 自定义模板阶段';

/*Data for the table `fixture_company_stagetemplate_tag` */

/*Table structure for table `fixture_company_wxtemplet` */

DROP TABLE IF EXISTS `fixture_company_wxtemplet`;

CREATE TABLE `fixture_company_wxtemplet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '原始模板ID',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模板名称',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `templateid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模板id',
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模板内容',
  `type` tinyint(2) DEFAULT NULL COMMENT '1.客户预约通知',
  `created_at` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='公司 - 小程序服务通知（暂停)';

/*Data for the table `fixture_company_wxtemplet` */

/*Table structure for table `fixture_conf_pc` */

DROP TABLE IF EXISTS `fixture_conf_pc`;

CREATE TABLE `fixture_conf_pc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `content` longtext COMMENT '内容 json',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='配置 - B端PC';

/*Data for the table `fixture_conf_pc` */

insert  into `fixture_conf_pc`(`id`,`name`,`content`,`status`,`created_at`) values (1,'register_agree','<p>欢迎阅读云易装服务条款(下称“本条款”)。本条款阐述之条款和条件适用于您在云易装平台无偿或有偿使用云易装产品。</p>\r\n        <p> 云易装是西安灰熊家族网络科技有限公司（以下简称‘西安灰熊’）运营的网站，本条款所述的云易装产品为西安灰熊家族网络科技有限公司旗下产品。</p>\r\n        <p>1. 接受条款<br> 以任何方式使用云易装产品即表示您同意自己已经与西安灰熊就云易装平台服务事项（下称云易装服务）订立本条款，且您将受本条款的条件约束。您应在第一次登录后仔细阅读本条款，并有权选择停止或继续使用云易装服务； 一旦您继续使用云易装服务， 则表示您已接受本条款，当您与西安灰熊、云易装发生争议时， 应以本条款作为约束双方的条款。除另行明确声明外，任何使云易装服务范围扩大或功能增强的新内容均受本条款约束。 如不符合本项条件，请勿使用云易装服务。云易装服务不会提供给被暂时或永久中止资格的云易装会员。\r\n        </p>\r\n        <p>\r\n            2.谁可使用云易装平台<br> 云易装服务仅供能够根据相关法律订立具有法律约束力的合约的主体使用。如不符合本项条件，请勿使用云易装服务。云易装服务不会提供给被暂时或永久中止资格的云易装会员。\r\n        </p>\r\n        <p>\r\n            3. 收费<br> 西安灰熊保留在根据本条款第1条通知您后，收取云易装服务费用的权利。您因进行交易、向西安灰熊获取有偿服务或接触西安灰熊服务器而发生的所有应纳税赋， 以及相关硬件、软件、通讯、网络服务及其他方面的费用均由您自行承担。西安灰熊保留在无须发出书面通知，仅在云易装平台公示的情况下，暂时或永久地更改或停止部分或全部云易装服务的权利。\r\n        </p>\r\n        <p>\r\n            4. 您的资料<br> 您可能会提交资料以作与云易装服务有关的使用。除了西安灰熊授权给您使用的资料，西安灰熊不提出拥有对您所发布或者向西安灰熊提供（称为“提交”）的与云易装服务有关的资料的所有权。 但是，经您发布或以其他方式提交的资料，您授予西安灰熊免费许可： 做与服务有关的使用、复制、传播、显示、发表和修改； 在与您的提交有关时发布您的姓名或单位名称； 将这些许可授予其他人。 本节仅适用于法律所允许的内容并仅适用于在不违反法律的限度内使用和发布上述法律所允许的内容。 西安灰熊不会为您的提交向您支付费用。西安灰熊有权拒绝发布，并且有权随时从云易装服务中删除您的提交。您应当对您所做出的每一提交享有以实施本节所规定的授权行为所必要的完整权利。\r\n        </p>\r\n        <p>\r\n            5. 隐私<br> 为了协作和提供服务，西安灰熊会收集您的某些信息。此外，西安灰熊还可以访问或者透露关于您的信息，包括您通讯的内容，以：<br> (a) 遵守法律、响应司法要求或法律程序；<br> (b) 保护西安灰熊及其客户的权利、财产，包括协议的执行和遵守适用于服务的策略；<br> (c) 保护西安灰熊及其雇员、客户和公众的权利、财产或安全。 西安灰熊可采取技术或其他措施以保护云易装服务，保护西安灰熊的客户，或阻止您违反本合同。 这些措施可能包括，例如，通过过滤来阻止垃圾邮件或提高安全级别。这些措施可能阻止或中断您对服务的使用。\r\n            <br> 为了向您提供服务，西安灰熊可收集有关服务状况，您的机器和您对服务的使用的某些信息。西安灰熊有权从您的机器自动上传这些信息。这些数据不会构成对您私人身份的确认。\r\n        </p>\r\n        <p>\r\n            6. 终止或访问限制 <br> 在您未向云易装支付服务费用的情况下，西安灰熊可自行全权决定以任何理由 (包括但不限于西安灰熊认为您已违反本条款的字面意义和精神，或您以不符合本条款的字面意义和精神的方式行事，或您在超过30天的时间内未以您的帐号及密码登录云易装产品) 终止您对云易装服务的使用， 及可自行全权决定以任何理由 (包括但不限于西安灰熊认为您已违反本条款的字面意义和精神，或您以不符合本条款的字面意义和精神的方式行事，或您在超过60天的时间内未以您的帐号及密码登录云易装产品)\r\n            终止您的云易装服务密码、账户 (或其任何部份) 或并删除和丢弃您在使用云易装服务中提交的 “您的资料”。根据本条款的任何规定终止您使用云易装服务之措施可在不发出事先通知的情况下实施，并承认和同意， 西安灰熊可立即使您的账户无效，或撤销您的账户以及在您的账户内的所有相关资料和档案，和/或禁止您进一步接入该等档案或云易装服务。帐号终止后，西安灰熊没有义务为您保留原帐号中或与之相关的任何信息， 或转发任何未曾阅读或发送的信息给您或第三方。 此外，西安灰熊不会就终止您接入云易装服务而对您或任何第三者承担任何责任。第8、9和10各条应在本条款终止后继续有效。\r\n        </p>\r\n        <p>\r\n            7. 违反本服务条款的法律责任<br> （1）在不限制其他补救措施的前提下，发生下述任一情况，西安灰熊可立即发出警告，暂时中止、永久中止或终止您的会员资格，不退还已交付款项并删除您的任何现有产品信息，以及您在网站上展示的任何其他资料： (i) 您违反本条款；<br> (ii) 西安灰熊无法核实或鉴定您向西安灰熊提供的任何资料；<br> (iii) 西安灰熊相信您的行为可能会使您、西安灰熊用户或通过西安灰熊或西安灰熊产品提供服务的第三者服务供应商发生任何法律责任；<br> (iv)发表、传送、传播、储存个人网站类，在线音视频类，刷钻/刷QB/QQ业务/刷流量/taobao刷信誉类，色情/成人内容/低俗内容类，游戏类/代练/涉及交易的虚拟物品类，彩票预测/赌博类内容网站，\r\n            盗号/外挂/私服/辅助类，代办证/代考/代开发票类，黑客/网站挂马/放置病毒/收费下载/收费传授黑客技术类，虚假信息/诈骗信息类等， 不利国家与社会稳定和谐，违反国家相关法律与政策的内容，将配合有关部门追究责任。<br> （2）若您的网站被第三方攻击，给云易装或云易装其他用户造成影响的，西安灰熊有权选择以下任一方式处理：\r\n            <br> （i）西安灰熊通知您立即采取接入第三方防御服务的措施，若您于接到通知后三日内未处理，西安灰熊有权直接关停您的网站，且无需承担任何责任； <br> （ii）西安灰熊直接关闭您的网站，并向您退回剩余服务期限对应的服务费（购买时采用代金券的，西安灰熊将不予退款）。\r\n            <br> 本条所称的第三方攻击仅指您的网站内容未违反本服务条款的情况下所受的恶意攻击。因您的网站内容违反本服务条款而遭受的攻击，不属于本条所称的网站攻击范畴。\r\n        </p>\r\n        <p>\r\n            8. 服务“按现状”和“按可得到”的基础提供 <br> 西安灰熊会尽一切努力使您在使用云易装产品的过程中得到乐趣。遗憾的是， 西安灰熊不能随时预见到任何技术上的问题或其他困难。该等困难可能会导致数据损失或其他服务中断，或根据市场需求，适当变更服务内容的某种功能。 为此， 您明确理解和同意，您使用云易装服务的风险由您自行承担。云易装服务以“按现状”和“按可得到”的基础提供。 西安灰熊明确声明不作出任何种类的所有明示或暗示的保证，包括但不限于关于适销性、适用于某一特定用途和无侵权行为等方面的保证。\r\n            西安灰熊对下述内容不作保证：\r\n            <br> (i)云易装服务会符合您的要求；\r\n            <br> (ii)云易装服务不会中断，且适时、安全和不带任何错误；\r\n            <br> (iii)通过使用云易装服务而可能获取的结果将是准确或可信赖的；\r\n            <br>及 (iv) 您通过云易装服务而购买或获取的任何产品、服务、资料或其他材料的质量将符合您的预期。 <br> 通过使用云易装服务而下载或以其他形式获取任何材料是由您自行全权决定进行的，且与此有关的风险由您自行承担， 对于因您下载任何该等材料而发生的您的电脑系统的任何损毁或任何数据损失，您将自行承担责任。 您从云易装或通过或从云易装服务获取的任何口头或书面意见或资料，均不产生未在本条款内明确载明的任何保证。\r\n        </p>\r\n        <p>\r\n            9. 责任范围 <br> 您明确理解和同意，西安灰熊不对因下述任一情况而发生的任何损害赔偿承担责任，包括但不限于利润、商誉、使用、数据等方面的损失或其他无形损失的损害赔偿 (无论西安灰熊是否已被告知该等损害赔偿的可能性)：<br> (i) 使用或未能使用云易装服务；<br> (ii) 因通过或从云易装服务购买或获取任何货物、样品、数据、资料或服务，或通过或从云易装服务接收任何信息或缔结任何交易所产生的获取替代货物和服务的费用；<br> (iii) 未经批准接入或更改您的传输资料或数据；<br>            (iv) 任何第三者对云易装服务的声明或关于云易装服务的行为；或 (v) 因任何原因而引起的与云易装服务有关的任何其他事宜，包括疏忽。\r\n        </p>\r\n        <p>\r\n            10. 赔偿<br> 您同意，因您违反本条款或经在此提及而纳入本条款的其他文件，或因您违反了法律或侵害了第三方的权利， 而使第三方对西安灰熊及其子公司、分公司、董事、职员、代理人提出索赔要求（包括但不限于司法费用和其他专业人士的费用，含律师费等）， 您必须赔偿给西安灰熊及其分公司、董事、职员、代理人，使其等免遭损失。\r\n        </p>\r\n        <p>\r\n            11. 遵守法律<br> 您在云易装上不得发布各类违法或违规信息。您应遵守与您使用云易装服务，以及与您竞买、购买和销售任何物品以及提供商贸信息有关的所有相关的法律、法规、条例和规章。\r\n        </p>\r\n        <p>\r\n            12. 广告和金融服务<br> 您与在云易装服务上或通过云易装服务物色的刊登广告人士通讯或进行业务往来或参与其推广活动， 包括就相关货物或服务付款和交付相关货物或服务，以及与该等业务往来相关的任何其他条款、条件、保证或声明，仅限于在您和该刊登广告人士之间发生。 您同意，对于因任何该等业务往来或因在云易装服务上出现该等刊登广告人士而发生的任何种类的任何损失或损毁，西安灰熊无需负责或承担任何责任。 您如打算通过云易装服务创设或参与与任何公司、股票行情、投资或证券有关的任何服务，或通过云易装服务收取或要求与任何公司、股票行情、投资或证券有关的任何新闻信息、警戒性信息或其他资料，\r\n            敬请注意，西安灰熊不会就通过云易装服务传送的任何该等资料的准确性、有用性或可用性、可获利性负责或承担任何责任， \\且不会对根据该等资料而作出的任何交易或投资决策负责或承担任何责任。\r\n        </p>\r\n        <p>\r\n            13. 您对西安灰熊的通知<br> 您可以通过云易装平台公布的西安灰熊联系信息向西安灰熊发出书面通知。\r\n        </p>\r\n        <p>\r\n            14. 西安灰熊向您发出通知<br> 西安灰熊向您发出通知，同意使用电子信息。本合同系电子形式。 西安灰熊承诺向您发送与本服务有关的特定信息，并有权向您发送某些附加信息。西安灰熊可能还会向您发送法律要求发送的有关本服务的其他信息。西安灰熊可以电子形式向您发送这些信息。 您有权取消您的同意，但如果您取消，西安灰熊可取消对您的服务。 西安灰熊可以下列方式向您提供必需的信息： 通过您在注册云易装服务时所指明的电话向您发送短信； 在您能够访问和使用云易装服务期间，您拥有必要的软件和硬件以接受此类通知。如果您不同意以电子形式接受任何通知，那么您应当停止使用云易装服务。\r\n        </p>\r\n        <p>\r\n            15. 与第三方网站的链接<br> 提供与第三方网站的链接仅仅为了给您带来方便。如果您使用这些链接，将离开云易装站点。 西安灰熊没有审查过所有这些第三方站点，对任何这些站点及其内容或它们的保密政策不进行控制，也不负任何责任。 因此，西安灰熊对这些网站上的任何信息、软件以及其它产品或材料，或者通过使用它们可能获得的任何结果不予认可，也不作任何表述。如果您决定访问本站点链接的任何第三方站点，其风险完全由您自己承担。\r\n        </p>\r\n        <p>\r\n            16. 不可抗力<br> 由于自然灾害、罢工或骚乱、物质短缺或定量配给、暴动、战争行为、政府行为、通电信网络、供电单位采取的限电或断电措施、供电单位的电力设施故障、 通讯或其他设施故障或严重伤亡事故、黑客攻击、尚无有效防御措施的计算机病毒的发作及其他各方不能预见并且对其发生和后果不能防止并避免的不可抗力原因，致使西安灰熊延迟或未能履约的，西安灰熊不对您承担任何责任。\r\n        </p>\r\n        <p>\r\n            17. 关于网络<br> 您明白由于因特网上通路的阻塞或造成访问速度下降，均是正常，不属于西安灰熊违约，若遇电信运营商或国家政策等原因造成的网络中断，西安灰熊不承担相应责任。\r\n        </p>\r\n        <p>\r\n            18. 关于版权<br> 以任何方式使用云易装提供的服务，包括但不限于基于云易装搭建的小程序服务，所涉及的版权归西安灰熊或有权的第三方所有。 您在使用云易装提供的服务时，应当保证相关版权的完整性，特别地，对于云易装的模板图片，您不得恶意篡改、任意拆分、组合，涉及人物图片的，您不得将图片进行分割或与其他图像进行组合。 否则，西安灰熊有权终止为您提供云易装服务，并不予退还服务费。若因您的该些行为给西安灰熊造成损失的，您还应当承担赔偿责任。若造成图片肖像权人向西安灰熊主张权利的，西安灰熊有权向您追偿。\r\n        </p>\r\n        <p>\r\n            19. 适用法律和管辖<br> 本条款适用于中国法律并依照中国法律解释，不会造成任何法律的冲突。任何因有关使用云易装各产品而发生的诉讼均应提交西安仲裁委员会申请仲裁。 如果您还有疑问，您可以直接给西安灰熊客服中心留言。 以上声明，您可随时在云易装平台阅读、复制或下载。\r\n        </p>',1,NULL);

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
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `value` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL COMMENT '标准版value',
  `vipvalue` varchar(11) DEFAULT NULL COMMENT 'vip版value',
  `viptext` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL COMMENT '说明',
  `type` varchar(10) DEFAULT NULL COMMENT '类型 max has',
  `controller` varchar(100) DEFAULT NULL COMMENT '控制器',
  `mehod` varchar(255) DEFAULT NULL COMMENT '方法',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='配置 - 会员机制功能';

/*Data for the table `fixture_conf_vipfunctionpoint` */

insert  into `fixture_conf_vipfunctionpoint`(`id`,`name`,`value`,`text`,`vipvalue`,`viptext`,`content`,`type`,`controller`,`mehod`,`status`,`created_at`) values (1,'vip_max_site','2','2个','0','不限','创建工地个数','max',NULL,NULL,1,'2018-06-29 15:52:15'),(2,'vip_dynamic','2','图文+VR','2','图文+VR+小视频','发布工地动态','max',NULL,NULL,1,'2018-06-29 15:52:18'),(3,'vip_activity','2','每月2条','0','不限','发布促销活动','max',NULL,NULL,1,'2018-06-29 15:52:23'),(4,'vip_has_participatory','0','无','1','有','活动参与方式','has','ActivityController',NULL,1,'2018-06-29 15:52:25'),(5,'vip_appointment','1','每月一条','1','有','客户预约','max',NULL,NULL,1,'2018-06-29 15:52:27'),(6,'vip_has_luck','1','有','1','有','抽奖活动','has','ActivityLuckyController',NULL,1,'2018-06-29 15:52:30'),(7,'vip_has_freeoffer','1','有','1','有','免费报价','allow','ClientAppointmentController','Appointment',1,'2018-06-29 15:52:32'),(8,'vip_has_message','1','有','1','有','在线咨询','allow',NULL,NULL,1,'2018-06-29 15:52:35'),(9,'vip_has_consultation','1','有','1','有','消息提醒','allow',NULL,NULL,1,'2018-06-29 15:52:37'),(10,'vip_has_visit_site','1','有','1','有','预约参观','allow','ClientAppointmentController','Appointment',1,'2018-06-29 15:52:39'),(11,'vip_has_inviting_team_members','1','有','1','有','邀请团队成员','allow',NULL,NULL,1,'2018-06-29 15:52:41'),(12,'vip_has_bussiness_comment','1','有','1','有','业务评价','allow',NULL,NULL,1,'2018-06-29 15:52:43'),(13,'vip_has_share_more','1','有','1','有','多渠道分享','allow',NULL,NULL,1,'2018-06-29 15:52:46'),(14,'vip_has_add_store','1','有','1','有','新增门店','has','StoreController',NULL,1,'2018-06-29 15:52:48'),(15,'vip_has_add_admin','0','无','1','有','新增用户','has','AdminController',NULL,1,'2018-06-29 15:52:54'),(16,'vip_has_role','0','无','1','有','用户角色','has','RolesController',NULL,1,'2018-06-29 15:52:58'),(17,'vip_has_auth','0','无','1','有','角色操作权限','has','RolesController',NULL,1,'2018-06-29 15:53:00'),(18,'vip_has_look','0','无','1','有','角色视野权限','has','RolesController',NULL,1,'2018-06-29 15:53:02'),(19,'vip_has_charts','1','简单数据分析','2','活动效果分析、客户转化率分析、渠道分析等更详细的数据分析、主流业务增长','数据分析','max',NULL,NULL,1,'2018-06-29 15:53:04');

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
) ENGINE=InnoDB AUTO_INCREMENT=659001 DEFAULT CHARSET=utf8 COMMENT='数据源 - 城市';

/*Data for the table `fixture_data_city` */

insert  into `fixture_data_city`(`id`,`name`,`provinceid`,`status`,`created_at`) values (110100,'市辖区',110000,1,'2018-05-14 16:43:50'),(120100,'市辖区',120000,1,'2018-05-14 16:43:51'),(130100,'石家庄市',130000,1,'2018-05-14 16:43:51'),(130200,'唐山市',130000,1,'2018-05-14 16:43:51'),(130300,'秦皇岛市',130000,1,'2018-05-14 16:43:52'),(130400,'邯郸市',130000,1,'2018-05-14 16:43:52'),(130500,'邢台市',130000,1,'2018-05-14 16:43:52'),(130600,'保定市',130000,1,'2018-05-14 16:43:53'),(130700,'张家口市',130000,1,'2018-05-14 16:43:53'),(130800,'承德市',130000,1,'2018-05-14 16:43:53'),(130900,'沧州市',130000,1,'2018-05-14 16:43:53'),(131000,'廊坊市',130000,1,'2018-05-14 16:43:54'),(131100,'衡水市',130000,1,'2018-05-14 16:43:54'),(139000,'省直辖县级行政区划',130000,1,'2018-05-14 16:43:54'),(140100,'太原市',140000,1,'2018-05-14 16:43:54'),(140200,'大同市',140000,1,'2018-05-14 16:43:54'),(140300,'阳泉市',140000,1,'2018-05-14 16:43:54'),(140400,'长治市',140000,1,'2018-05-14 16:43:55'),(140500,'晋城市',140000,1,'2018-05-14 16:43:55'),(140600,'朔州市',140000,1,'2018-05-14 16:43:55'),(140700,'晋中市',140000,1,'2018-05-14 16:43:55'),(140800,'运城市',140000,1,'2018-05-14 16:43:55'),(140900,'忻州市',140000,1,'2018-05-14 16:43:55'),(141000,'临汾市',140000,1,'2018-05-14 16:43:56'),(141100,'吕梁市',140000,1,'2018-05-14 16:43:56'),(150100,'呼和浩特市',150000,1,'2018-05-14 16:43:56'),(150200,'包头市',150000,1,'2018-05-14 16:43:56'),(150300,'乌海市',150000,1,'2018-05-14 16:43:56'),(150400,'赤峰市',150000,1,'2018-05-14 16:43:57'),(150500,'通辽市',150000,1,'2018-05-14 16:43:57'),(150600,'鄂尔多斯市',150000,1,'2018-05-14 16:43:57'),(150700,'呼伦贝尔市',150000,1,'2018-05-14 16:43:57'),(150800,'巴彦淖尔市',150000,1,'2018-05-14 16:43:57'),(150900,'乌兰察布市',150000,1,'2018-05-14 16:43:58'),(152200,'兴安盟',150000,1,'2018-05-14 16:43:58'),(152500,'锡林郭勒盟',150000,1,'2018-05-14 16:43:58'),(152900,'阿拉善盟',150000,1,'2018-05-14 16:43:58'),(210100,'沈阳市',210000,1,'2018-05-14 16:43:58'),(210200,'大连市',210000,1,'2018-05-14 16:43:58'),(210300,'鞍山市',210000,1,'2018-05-14 16:43:59'),(210400,'抚顺市',210000,1,'2018-05-14 16:43:59'),(210500,'本溪市',210000,1,'2018-05-14 16:43:59'),(210600,'丹东市',210000,1,'2018-05-14 16:43:59'),(210700,'锦州市',210000,1,'2018-05-14 16:43:59'),(210800,'营口市',210000,1,'2018-05-14 16:43:59'),(210900,'阜新市',210000,1,'2018-05-14 16:43:59'),(211000,'辽阳市',210000,1,'2018-05-14 16:44:00'),(211100,'盘锦市',210000,1,'2018-05-14 16:44:00'),(211200,'铁岭市',210000,1,'2018-05-14 16:44:00'),(211300,'朝阳市',210000,1,'2018-05-14 16:44:00'),(211400,'葫芦岛市',210000,1,'2018-05-14 16:44:00'),(220100,'长春市',220000,1,'2018-05-14 16:44:00'),(220200,'吉林市',220000,1,'2018-05-14 16:44:00'),(220300,'四平市',220000,1,'2018-05-14 16:44:00'),(220400,'辽源市',220000,1,'2018-05-14 16:44:01'),(220500,'通化市',220000,1,'2018-05-14 16:44:01'),(220600,'白山市',220000,1,'2018-05-14 16:44:01'),(220700,'松原市',220000,1,'2018-05-14 16:44:01'),(220800,'白城市',220000,1,'2018-05-14 16:44:01'),(222400,'延边朝鲜族自治州',220000,1,'2018-05-14 16:44:01'),(230100,'哈尔滨市',230000,1,'2018-05-14 16:44:01'),(230200,'齐齐哈尔市',230000,1,'2018-05-14 16:44:02'),(230300,'鸡西市',230000,1,'2018-05-14 16:44:02'),(230400,'鹤岗市',230000,1,'2018-05-14 16:44:02'),(230500,'双鸭山市',230000,1,'2018-05-14 16:44:02'),(230600,'大庆市',230000,1,'2018-05-14 16:44:02'),(230700,'伊春市',230000,1,'2018-05-14 16:44:02'),(230800,'佳木斯市',230000,1,'2018-05-14 16:44:03'),(230900,'七台河市',230000,1,'2018-05-14 16:44:03'),(231000,'牡丹江市',230000,1,'2018-05-14 16:44:03'),(231100,'黑河市',230000,1,'2018-05-14 16:44:03'),(231200,'绥化市',230000,1,'2018-05-14 16:44:03'),(232700,'大兴安岭地区',230000,1,'2018-05-14 16:44:04'),(310100,'市辖区',310000,1,'2018-05-14 16:44:04'),(320100,'南京市',320000,1,'2018-05-14 16:44:04'),(320200,'无锡市',320000,1,'2018-05-14 16:44:04'),(320300,'徐州市',320000,1,'2018-05-14 16:44:04'),(320400,'常州市',320000,1,'2018-05-14 16:44:04'),(320500,'苏州市',320000,1,'2018-05-14 16:44:05'),(320600,'南通市',320000,1,'2018-05-14 16:44:05'),(320700,'连云港市',320000,1,'2018-05-14 16:44:05'),(320800,'淮安市',320000,1,'2018-05-14 16:44:05'),(320900,'盐城市',320000,1,'2018-05-14 16:44:05'),(321000,'扬州市',320000,1,'2018-05-14 16:44:05'),(321100,'镇江市',320000,1,'2018-05-14 16:44:05'),(321200,'泰州市',320000,1,'2018-05-14 16:44:05'),(321300,'宿迁市',320000,1,'2018-05-14 16:44:06'),(330100,'杭州市',330000,1,'2018-05-14 16:44:06'),(330200,'宁波市',330000,1,'2018-05-14 16:44:06'),(330300,'温州市',330000,1,'2018-05-14 16:44:06'),(330400,'嘉兴市',330000,1,'2018-05-14 16:44:06'),(330500,'湖州市',330000,1,'2018-05-14 16:44:06'),(330600,'绍兴市',330000,1,'2018-05-14 16:44:07'),(330700,'金华市',330000,1,'2018-05-14 16:44:07'),(330800,'衢州市',330000,1,'2018-05-14 16:44:07'),(330900,'舟山市',330000,1,'2018-05-14 16:44:07'),(331000,'台州市',330000,1,'2018-05-14 16:44:07'),(331100,'丽水市',330000,1,'2018-05-14 16:44:07'),(340100,'合肥市',340000,1,'2018-05-14 16:44:07'),(340200,'芜湖市',340000,1,'2018-05-14 16:44:08'),(340300,'蚌埠市',340000,1,'2018-05-14 16:44:08'),(340400,'淮南市',340000,1,'2018-05-14 16:44:08'),(340500,'马鞍山市',340000,1,'2018-05-14 16:44:08'),(340600,'淮北市',340000,1,'2018-05-14 16:44:08'),(340700,'铜陵市',340000,1,'2018-05-14 16:44:08'),(340800,'安庆市',340000,1,'2018-05-14 16:44:08'),(341000,'黄山市',340000,1,'2018-05-14 16:44:08'),(341100,'滁州市',340000,1,'2018-05-14 16:44:09'),(341200,'阜阳市',340000,1,'2018-05-14 16:44:09'),(341300,'宿州市',340000,1,'2018-05-14 16:44:09'),(341500,'六安市',340000,1,'2018-05-14 16:44:09'),(341600,'亳州市',340000,1,'2018-05-14 16:44:09'),(341700,'池州市',340000,1,'2018-05-14 16:44:09'),(341800,'宣城市',340000,1,'2018-05-14 16:44:09'),(350100,'福州市',350000,1,'2018-05-14 16:44:09'),(350200,'厦门市',350000,1,'2018-05-14 16:44:10'),(350300,'莆田市',350000,1,'2018-05-14 16:44:10'),(350400,'三明市',350000,1,'2018-05-14 16:44:10'),(350500,'泉州市',350000,1,'2018-05-14 16:44:10'),(350600,'漳州市',350000,1,'2018-05-14 16:44:10'),(350700,'南平市',350000,1,'2018-05-14 16:44:10'),(350800,'龙岩市',350000,1,'2018-05-14 16:44:11'),(350900,'宁德市',350000,1,'2018-05-14 16:44:11'),(360100,'南昌市',360000,1,'2018-05-14 16:44:11'),(360200,'景德镇市',360000,1,'2018-05-14 16:44:11'),(360300,'萍乡市',360000,1,'2018-05-14 16:44:11'),(360400,'九江市',360000,1,'2018-05-14 16:44:11'),(360500,'新余市',360000,1,'2018-05-14 16:44:12'),(360600,'鹰潭市',360000,1,'2018-05-14 16:44:12'),(360700,'赣州市',360000,1,'2018-05-14 16:44:12'),(360800,'吉安市',360000,1,'2018-05-14 16:44:12'),(360900,'宜春市',360000,1,'2018-05-14 16:44:12'),(361000,'抚州市',360000,1,'2018-05-14 16:44:12'),(361100,'上饶市',360000,1,'2018-05-14 16:44:13'),(370100,'济南市',370000,1,'2018-05-14 16:44:13'),(370200,'青岛市',370000,1,'2018-05-14 16:44:13'),(370300,'淄博市',370000,1,'2018-05-14 16:44:13'),(370400,'枣庄市',370000,1,'2018-05-14 16:44:13'),(370500,'东营市',370000,1,'2018-05-14 16:44:14'),(370600,'烟台市',370000,1,'2018-05-14 16:44:14'),(370700,'潍坊市',370000,1,'2018-05-14 16:44:14'),(370800,'济宁市',370000,1,'2018-05-14 16:44:14'),(370900,'泰安市',370000,1,'2018-05-14 16:44:14'),(371000,'威海市',370000,1,'2018-05-14 16:44:14'),(371100,'日照市',370000,1,'2018-05-14 16:44:15'),(371200,'莱芜市',370000,1,'2018-05-14 16:44:15'),(371300,'临沂市',370000,1,'2018-05-14 16:44:15'),(371400,'德州市',370000,1,'2018-05-14 16:44:15'),(371500,'聊城市',370000,1,'2018-05-14 16:44:15'),(371600,'滨州市',370000,1,'2018-05-14 16:44:15'),(371700,'菏泽市',370000,1,'2018-05-14 16:44:15'),(410100,'郑州市',410000,1,'2018-05-14 16:44:16'),(410200,'开封市',410000,1,'2018-05-14 16:44:16'),(410300,'洛阳市',410000,1,'2018-05-14 16:44:16'),(410400,'平顶山市',410000,1,'2018-05-14 16:44:16'),(410500,'安阳市',410000,1,'2018-05-14 16:44:17'),(410600,'鹤壁市',410000,1,'2018-05-14 16:44:17'),(410700,'新乡市',410000,1,'2018-05-14 16:44:17'),(410800,'焦作市',410000,1,'2018-05-14 16:44:17'),(410900,'濮阳市',410000,1,'2018-05-14 16:44:17'),(411000,'许昌市',410000,1,'2018-05-14 16:44:17'),(411100,'漯河市',410000,1,'2018-05-14 16:44:17'),(411200,'三门峡市',410000,1,'2018-05-14 16:44:18'),(411300,'南阳市',410000,1,'2018-05-14 16:44:18'),(411400,'商丘市',410000,1,'2018-05-14 16:44:18'),(411500,'信阳市',410000,1,'2018-05-14 16:44:18'),(411600,'周口市',410000,1,'2018-05-14 16:44:18'),(411700,'驻马店市',410000,1,'2018-05-14 16:44:18'),(419000,'省直辖县级行政区划',410000,1,'2018-05-14 16:44:19'),(420100,'武汉市',420000,1,'2018-05-14 16:44:19'),(420200,'黄石市',420000,1,'2018-05-14 16:44:19'),(420300,'十堰市',420000,1,'2018-05-14 16:44:19'),(420500,'宜昌市',420000,1,'2018-05-14 16:44:19'),(420600,'襄阳市',420000,1,'2018-05-14 16:44:19'),(420700,'鄂州市',420000,1,'2018-05-14 16:44:20'),(420800,'荆门市',420000,1,'2018-05-14 16:44:20'),(420900,'孝感市',420000,1,'2018-05-14 16:44:20'),(421000,'荆州市',420000,1,'2018-05-14 16:44:20'),(421100,'黄冈市',420000,1,'2018-05-14 16:44:20'),(421200,'咸宁市',420000,1,'2018-05-14 16:44:20'),(421300,'随州市',420000,1,'2018-05-14 16:44:20'),(422800,'恩施土家族苗族自治州',420000,1,'2018-05-14 16:44:20'),(429000,'省直辖县级行政区划',420000,1,'2018-05-14 16:44:21'),(430100,'长沙市',430000,1,'2018-05-14 16:44:21'),(430200,'株洲市',430000,1,'2018-05-14 16:44:21'),(430300,'湘潭市',430000,1,'2018-05-14 16:44:21'),(430400,'衡阳市',430000,1,'2018-05-14 16:44:21'),(430500,'邵阳市',430000,1,'2018-05-14 16:44:21'),(430600,'岳阳市',430000,1,'2018-05-14 16:44:22'),(430700,'常德市',430000,1,'2018-05-14 16:44:22'),(430800,'张家界市',430000,1,'2018-05-14 16:44:22'),(430900,'益阳市',430000,1,'2018-05-14 16:44:22'),(431000,'郴州市',430000,1,'2018-05-14 16:44:22'),(431100,'永州市',430000,1,'2018-05-14 16:44:22'),(431200,'怀化市',430000,1,'2018-05-14 16:44:23'),(431300,'娄底市',430000,1,'2018-05-14 16:44:23'),(433100,'湘西土家族苗族自治州',430000,1,'2018-05-14 16:44:23'),(440100,'广州市',440000,1,'2018-05-14 16:44:23'),(440200,'韶关市',440000,1,'2018-05-14 16:44:23'),(440300,'深圳市',440000,1,'2018-05-14 16:44:23'),(440400,'珠海市',440000,1,'2018-05-14 16:44:24'),(440500,'汕头市',440000,1,'2018-05-14 16:44:24'),(440600,'佛山市',440000,1,'2018-05-14 16:44:24'),(440700,'江门市',440000,1,'2018-05-14 16:44:24'),(440800,'湛江市',440000,1,'2018-05-14 16:44:24'),(440900,'茂名市',440000,1,'2018-05-14 16:44:24'),(441200,'肇庆市',440000,1,'2018-05-14 16:44:24'),(441300,'惠州市',440000,1,'2018-05-14 16:44:24'),(441400,'梅州市',440000,1,'2018-05-14 16:44:25'),(441500,'汕尾市',440000,1,'2018-05-14 16:44:25'),(441600,'河源市',440000,1,'2018-05-14 16:44:25'),(441700,'阳江市',440000,1,'2018-05-14 16:44:25'),(441800,'清远市',440000,1,'2018-05-14 16:44:25'),(441900,'东莞市',440000,1,'2018-05-14 16:44:25'),(442000,'中山市',440000,1,'2018-05-14 16:44:25'),(445100,'潮州市',440000,1,'2018-05-14 16:44:25'),(445200,'揭阳市',440000,1,'2018-05-14 16:44:25'),(445300,'云浮市',440000,1,'2018-05-14 16:44:25'),(450100,'南宁市',450000,1,'2018-05-14 16:44:26'),(450200,'柳州市',450000,1,'2018-05-14 16:44:26'),(450300,'桂林市',450000,1,'2018-05-14 16:44:26'),(450400,'梧州市',450000,1,'2018-05-14 16:44:26'),(450500,'北海市',450000,1,'2018-05-14 16:44:26'),(450600,'防城港市',450000,1,'2018-05-14 16:44:26'),(450700,'钦州市',450000,1,'2018-05-14 16:44:27'),(450800,'贵港市',450000,1,'2018-05-14 16:44:27'),(450900,'玉林市',450000,1,'2018-05-14 16:44:27'),(451000,'百色市',450000,1,'2018-05-14 16:44:27'),(451100,'贺州市',450000,1,'2018-05-14 16:44:27'),(451200,'河池市',450000,1,'2018-05-14 16:44:27'),(451300,'来宾市',450000,1,'2018-05-14 16:44:27'),(451400,'崇左市',450000,1,'2018-05-14 16:44:27'),(460100,'海口市',460000,1,'2018-05-14 16:44:28'),(460200,'三亚市',460000,1,'2018-05-14 16:44:28'),(460300,'三沙市',460000,1,'2018-05-14 16:44:28'),(460400,'儋州市',460000,1,'2018-05-14 16:44:28'),(469000,'省直辖县级行政区划',460000,1,'2018-05-14 16:44:28'),(500100,'市辖区',500000,1,'2018-05-14 16:44:28'),(500200,'县',500000,1,'2018-05-14 16:44:28'),(510100,'成都市',510000,1,'2018-05-14 16:44:29'),(510300,'自贡市',510000,1,'2018-05-14 16:44:29'),(510400,'攀枝花市',510000,1,'2018-05-14 16:44:29'),(510500,'泸州市',510000,1,'2018-05-14 16:44:29'),(510600,'德阳市',510000,1,'2018-05-14 16:44:29'),(510700,'绵阳市',510000,1,'2018-05-14 16:44:29'),(510800,'广元市',510000,1,'2018-05-14 16:44:30'),(510900,'遂宁市',510000,1,'2018-05-14 16:44:30'),(511000,'内江市',510000,1,'2018-05-14 16:44:30'),(511100,'乐山市',510000,1,'2018-05-14 16:44:30'),(511300,'南充市',510000,1,'2018-05-14 16:44:30'),(511400,'眉山市',510000,1,'2018-05-14 16:44:30'),(511500,'宜宾市',510000,1,'2018-05-14 16:44:30'),(511600,'广安市',510000,1,'2018-05-14 16:44:31'),(511700,'达州市',510000,1,'2018-05-14 16:44:31'),(511800,'雅安市',510000,1,'2018-05-14 16:44:31'),(511900,'巴中市',510000,1,'2018-05-14 16:44:31'),(512000,'资阳市',510000,1,'2018-05-14 16:44:31'),(513200,'阿坝藏族羌族自治州',510000,1,'2018-05-14 16:44:31'),(513300,'甘孜藏族自治州',510000,1,'2018-05-14 16:44:31'),(513400,'凉山彝族自治州',510000,1,'2018-05-14 16:44:32'),(520100,'贵阳市',520000,1,'2018-05-14 16:44:32'),(520200,'六盘水市',520000,1,'2018-05-14 16:44:32'),(520300,'遵义市',520000,1,'2018-05-14 16:44:32'),(520400,'安顺市',520000,1,'2018-05-14 16:44:33'),(520500,'毕节市',520000,1,'2018-05-14 16:44:33'),(520600,'铜仁市',520000,1,'2018-05-14 16:44:33'),(522300,'黔西南布依族苗族自治州',520000,1,'2018-05-14 16:44:33'),(522600,'黔东南苗族侗族自治州',520000,1,'2018-05-14 16:44:33'),(522700,'黔南布依族苗族自治州',520000,1,'2018-05-14 16:44:33'),(530100,'昆明市',530000,1,'2018-05-14 16:44:34'),(530300,'曲靖市',530000,1,'2018-05-14 16:44:34'),(530400,'玉溪市',530000,1,'2018-05-14 16:44:34'),(530500,'保山市',530000,1,'2018-05-14 16:44:34'),(530600,'昭通市',530000,1,'2018-05-14 16:44:34'),(530700,'丽江市',530000,1,'2018-05-14 16:44:34'),(530800,'普洱市',530000,1,'2018-05-14 16:44:34'),(530900,'临沧市',530000,1,'2018-05-14 16:44:35'),(532300,'楚雄彝族自治州',530000,1,'2018-05-14 16:44:35'),(532500,'红河哈尼族彝族自治州',530000,1,'2018-05-14 16:44:35'),(532600,'文山壮族苗族自治州',530000,1,'2018-05-14 16:44:35'),(532800,'西双版纳傣族自治州',530000,1,'2018-05-14 16:44:35'),(532900,'大理白族自治州',530000,1,'2018-05-14 16:44:35'),(533100,'德宏傣族景颇族自治州',530000,1,'2018-05-14 16:44:36'),(533300,'怒江傈僳族自治州',530000,1,'2018-05-14 16:44:36'),(533400,'迪庆藏族自治州',530000,1,'2018-05-14 16:44:36'),(540100,'拉萨市',540000,1,'2018-05-14 16:44:36'),(540200,'日喀则市',540000,1,'2018-05-14 16:44:36'),(540300,'昌都市',540000,1,'2018-05-14 16:44:36'),(540400,'林芝市',540000,1,'2018-05-14 16:44:37'),(540500,'山南市',540000,1,'2018-05-14 16:44:37'),(542400,'那曲地区',540000,1,'2018-05-14 16:44:37'),(542500,'阿里地区',540000,1,'2018-05-14 16:44:37'),(610100,'西安市',610000,1,'2018-05-14 16:44:37'),(610200,'铜川市',610000,1,'2018-05-14 16:44:37'),(610300,'宝鸡市',610000,1,'2018-05-14 16:44:37'),(610400,'咸阳市',610000,1,'2018-05-14 16:44:38'),(610500,'渭南市',610000,1,'2018-05-14 16:44:38'),(610600,'延安市',610000,1,'2018-05-14 16:44:38'),(610700,'汉中市',610000,1,'2018-05-14 16:44:38'),(610800,'榆林市',610000,1,'2018-05-14 16:44:39'),(610900,'安康市',610000,1,'2018-05-14 16:44:39'),(611000,'商洛市',610000,1,'2018-05-14 16:44:39'),(620100,'兰州市',620000,1,'2018-05-14 16:44:39'),(620200,'嘉峪关市',620000,1,'2018-05-14 16:44:39'),(620300,'金昌市',620000,1,'2018-05-14 16:44:39'),(620400,'白银市',620000,1,'2018-05-14 16:44:39'),(620500,'天水市',620000,1,'2018-05-14 16:44:39'),(620600,'武威市',620000,1,'2018-05-14 16:44:40'),(620700,'张掖市',620000,1,'2018-05-14 16:44:40'),(620800,'平凉市',620000,1,'2018-05-14 16:44:40'),(620900,'酒泉市',620000,1,'2018-05-14 16:44:40'),(621000,'庆阳市',620000,1,'2018-05-14 16:44:40'),(621100,'定西市',620000,1,'2018-05-14 16:44:40'),(621200,'陇南市',620000,1,'2018-05-14 16:44:40'),(622900,'临夏回族自治州',620000,1,'2018-05-14 16:44:40'),(623000,'甘南藏族自治州',620000,1,'2018-05-14 16:44:41'),(630100,'西宁市',630000,1,'2018-05-14 16:44:41'),(630200,'海东市',630000,1,'2018-05-14 16:44:41'),(632200,'海北藏族自治州',630000,1,'2018-05-14 16:44:41'),(632300,'黄南藏族自治州',630000,1,'2018-05-14 16:44:41'),(632500,'海南藏族自治州',630000,1,'2018-05-14 16:44:41'),(632600,'果洛藏族自治州',630000,1,'2018-05-14 16:44:41'),(632700,'玉树藏族自治州',630000,1,'2018-05-14 16:44:41'),(632800,'海西蒙古族藏族自治州',630000,1,'2018-05-14 16:44:41'),(640100,'银川市',640000,1,'2018-05-14 16:44:42'),(640200,'石嘴山市',640000,1,'2018-05-14 16:44:42'),(640300,'吴忠市',640000,1,'2018-05-14 16:44:42'),(640400,'固原市',640000,1,'2018-05-14 16:44:42'),(640500,'中卫市',640000,1,'2018-05-14 16:44:42'),(650100,'乌鲁木齐市',650000,1,'2018-05-14 16:44:42'),(650200,'克拉玛依市',650000,1,'2018-05-14 16:44:42'),(650400,'吐鲁番市',650000,1,'2018-05-14 16:44:42'),(650500,'哈密市',650000,1,'2018-05-14 16:44:42'),(652300,'昌吉回族自治州',650000,1,'2018-05-14 16:44:42'),(652700,'博尔塔拉蒙古自治州',650000,1,'2018-05-14 16:44:42'),(652800,'巴音郭楞蒙古自治州',650000,1,'2018-05-14 16:44:42'),(652900,'阿克苏地区',650000,1,'2018-05-14 16:44:43'),(653000,'克孜勒苏柯尔克孜自治州',650000,1,'2018-05-14 16:44:43'),(653100,'喀什地区',650000,1,'2018-05-14 16:44:43'),(653200,'和田地区',650000,1,'2018-05-14 16:44:43'),(654000,'伊犁哈萨克自治州',650000,1,'2018-05-14 16:44:43'),(654200,'塔城地区',650000,1,'2018-05-14 16:44:43'),(654300,'阿勒泰地区',650000,1,'2018-05-14 16:44:44'),(659000,'自治区直辖县级行政区划',650000,1,'2018-05-14 16:44:44');

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
) ENGINE=InnoDB AUTO_INCREMENT=659007 DEFAULT CHARSET=utf8 COMMENT='数据源 - 区';

/*Data for the table `fixture_data_country` */

insert  into `fixture_data_country`(`id`,`name`,`cityid`,`status`,`created_at`) values (110101,'东城区',110100,1,'2018-05-14 16:43:50'),(110102,'西城区',110100,1,'2018-05-14 16:43:50'),(110105,'朝阳区',110100,1,'2018-05-14 16:43:50'),(110106,'丰台区',110100,1,'2018-05-14 16:43:51'),(110107,'石景山区',110100,1,'2018-05-14 16:43:51'),(110108,'海淀区',110100,1,'2018-05-14 16:43:51'),(110109,'门头沟区',110100,1,'2018-05-14 16:43:51'),(110111,'房山区',110100,1,'2018-05-14 16:43:51'),(110112,'通州区',110100,1,'2018-05-14 16:43:51'),(110113,'顺义区',110100,1,'2018-05-14 16:43:51'),(110114,'昌平区',110100,1,'2018-05-14 16:43:51'),(110115,'大兴区',110100,1,'2018-05-14 16:43:51'),(110116,'怀柔区',110100,1,'2018-05-14 16:43:51'),(110117,'平谷区',110100,1,'2018-05-14 16:43:51'),(110118,'密云区',110100,1,'2018-05-14 16:43:51'),(110119,'延庆区',110100,1,'2018-05-14 16:43:51'),(120101,'和平区',120100,1,'2018-05-14 16:43:51'),(120102,'河东区',120100,1,'2018-05-14 16:43:51'),(120103,'河西区',120100,1,'2018-05-14 16:43:51'),(120104,'南开区',120100,1,'2018-05-14 16:43:51'),(120105,'河北区',120100,1,'2018-05-14 16:43:51'),(120106,'红桥区',120100,1,'2018-05-14 16:43:51'),(120110,'东丽区',120100,1,'2018-05-14 16:43:51'),(120111,'西青区',120100,1,'2018-05-14 16:43:51'),(120112,'津南区',120100,1,'2018-05-14 16:43:51'),(120113,'北辰区',120100,1,'2018-05-14 16:43:51'),(120114,'武清区',120100,1,'2018-05-14 16:43:51'),(120115,'宝坻区',120100,1,'2018-05-14 16:43:51'),(120116,'滨海新区',120100,1,'2018-05-14 16:43:51'),(120117,'宁河区',120100,1,'2018-05-14 16:43:51'),(120118,'静海区',120100,1,'2018-05-14 16:43:51'),(120119,'蓟州区',120100,1,'2018-05-14 16:43:51'),(130101,'市辖区',130100,1,'2018-05-14 16:43:51'),(130102,'长安区',130100,1,'2018-05-14 16:43:51'),(130104,'桥西区',130100,1,'2018-05-14 16:43:51'),(130105,'新华区',130100,1,'2018-05-14 16:43:51'),(130107,'井陉矿区',130100,1,'2018-05-14 16:43:51'),(130108,'裕华区',130100,1,'2018-05-14 16:43:51'),(130109,'藁城区',130100,1,'2018-05-14 16:43:51'),(130110,'鹿泉区',130100,1,'2018-05-14 16:43:51'),(130111,'栾城区',130100,1,'2018-05-14 16:43:51'),(130121,'井陉县',130100,1,'2018-05-14 16:43:51'),(130123,'正定县',130100,1,'2018-05-14 16:43:51'),(130125,'行唐县',130100,1,'2018-05-14 16:43:51'),(130126,'灵寿县',130100,1,'2018-05-14 16:43:51'),(130127,'高邑县',130100,1,'2018-05-14 16:43:51'),(130128,'深泽县',130100,1,'2018-05-14 16:43:51'),(130129,'赞皇县',130100,1,'2018-05-14 16:43:51'),(130130,'无极县',130100,1,'2018-05-14 16:43:51'),(130131,'平山县',130100,1,'2018-05-14 16:43:51'),(130132,'元氏县',130100,1,'2018-05-14 16:43:51'),(130133,'赵县',130100,1,'2018-05-14 16:43:51'),(130183,'晋州市',130100,1,'2018-05-14 16:43:51'),(130184,'新乐市',130100,1,'2018-05-14 16:43:51'),(130201,'市辖区',130200,1,'2018-05-14 16:43:51'),(130202,'路南区',130200,1,'2018-05-14 16:43:51'),(130203,'路北区',130200,1,'2018-05-14 16:43:51'),(130204,'古冶区',130200,1,'2018-05-14 16:43:51'),(130205,'开平区',130200,1,'2018-05-14 16:43:52'),(130207,'丰南区',130200,1,'2018-05-14 16:43:52'),(130208,'丰润区',130200,1,'2018-05-14 16:43:52'),(130209,'曹妃甸区',130200,1,'2018-05-14 16:43:52'),(130223,'滦县',130200,1,'2018-05-14 16:43:52'),(130224,'滦南县',130200,1,'2018-05-14 16:43:52'),(130225,'乐亭县',130200,1,'2018-05-14 16:43:52'),(130227,'迁西县',130200,1,'2018-05-14 16:43:52'),(130229,'玉田县',130200,1,'2018-05-14 16:43:52'),(130281,'遵化市',130200,1,'2018-05-14 16:43:52'),(130283,'迁安市',130200,1,'2018-05-14 16:43:52'),(130301,'市辖区',130300,1,'2018-05-14 16:43:52'),(130302,'海港区',130300,1,'2018-05-14 16:43:52'),(130303,'山海关区',130300,1,'2018-05-14 16:43:52'),(130304,'北戴河区',130300,1,'2018-05-14 16:43:52'),(130306,'抚宁区',130300,1,'2018-05-14 16:43:52'),(130321,'青龙满族自治县',130300,1,'2018-05-14 16:43:52'),(130322,'昌黎县',130300,1,'2018-05-14 16:43:52'),(130324,'卢龙县',130300,1,'2018-05-14 16:43:52'),(130401,'市辖区',130400,1,'2018-05-14 16:43:52'),(130402,'邯山区',130400,1,'2018-05-14 16:43:52'),(130403,'丛台区',130400,1,'2018-05-14 16:43:52'),(130404,'复兴区',130400,1,'2018-05-14 16:43:52'),(130406,'峰峰矿区',130400,1,'2018-05-14 16:43:52'),(130421,'邯郸县',130400,1,'2018-05-14 16:43:52'),(130423,'临漳县',130400,1,'2018-05-14 16:43:52'),(130424,'成安县',130400,1,'2018-05-14 16:43:52'),(130425,'大名县',130400,1,'2018-05-14 16:43:52'),(130426,'涉县',130400,1,'2018-05-14 16:43:52'),(130427,'磁县',130400,1,'2018-05-14 16:43:52'),(130428,'肥乡县',130400,1,'2018-05-14 16:43:52'),(130429,'永年县',130400,1,'2018-05-14 16:43:52'),(130430,'邱县',130400,1,'2018-05-14 16:43:52'),(130431,'鸡泽县',130400,1,'2018-05-14 16:43:52'),(130432,'广平县',130400,1,'2018-05-14 16:43:52'),(130433,'馆陶县',130400,1,'2018-05-14 16:43:52'),(130434,'魏县',130400,1,'2018-05-14 16:43:52'),(130435,'曲周县',130400,1,'2018-05-14 16:43:52'),(130481,'武安市',130400,1,'2018-05-14 16:43:52'),(130501,'市辖区',130500,1,'2018-05-14 16:43:52'),(130502,'桥东区',130500,1,'2018-05-14 16:43:52'),(130503,'桥西区',130500,1,'2018-05-14 16:43:52'),(130521,'邢台县',130500,1,'2018-05-14 16:43:52'),(130522,'临城县',130500,1,'2018-05-14 16:43:52'),(130523,'内丘县',130500,1,'2018-05-14 16:43:52'),(130524,'柏乡县',130500,1,'2018-05-14 16:43:52'),(130525,'隆尧县',130500,1,'2018-05-14 16:43:52'),(130526,'任县',130500,1,'2018-05-14 16:43:52'),(130527,'南和县',130500,1,'2018-05-14 16:43:52'),(130528,'宁晋县',130500,1,'2018-05-14 16:43:52'),(130529,'巨鹿县',130500,1,'2018-05-14 16:43:52'),(130530,'新河县',130500,1,'2018-05-14 16:43:52'),(130531,'广宗县',130500,1,'2018-05-14 16:43:52'),(130532,'平乡县',130500,1,'2018-05-14 16:43:52'),(130533,'威县',130500,1,'2018-05-14 16:43:52'),(130534,'清河县',130500,1,'2018-05-14 16:43:53'),(130535,'临西县',130500,1,'2018-05-14 16:43:53'),(130581,'南宫市',130500,1,'2018-05-14 16:43:53'),(130582,'沙河市',130500,1,'2018-05-14 16:43:53'),(130601,'市辖区',130600,1,'2018-05-14 16:43:53'),(130602,'竞秀区',130600,1,'2018-05-14 16:43:53'),(130606,'莲池区',130600,1,'2018-05-14 16:43:53'),(130607,'满城区',130600,1,'2018-05-14 16:43:53'),(130608,'清苑区',130600,1,'2018-05-14 16:43:53'),(130609,'徐水区',130600,1,'2018-05-14 16:43:53'),(130623,'涞水县',130600,1,'2018-05-14 16:43:53'),(130624,'阜平县',130600,1,'2018-05-14 16:43:53'),(130626,'定兴县',130600,1,'2018-05-14 16:43:53'),(130627,'唐县',130600,1,'2018-05-14 16:43:53'),(130628,'高阳县',130600,1,'2018-05-14 16:43:53'),(130629,'容城县',130600,1,'2018-05-14 16:43:53'),(130630,'涞源县',130600,1,'2018-05-14 16:43:53'),(130631,'望都县',130600,1,'2018-05-14 16:43:53'),(130632,'安新县',130600,1,'2018-05-14 16:43:53'),(130633,'易县',130600,1,'2018-05-14 16:43:53'),(130634,'曲阳县',130600,1,'2018-05-14 16:43:53'),(130635,'蠡县',130600,1,'2018-05-14 16:43:53'),(130636,'顺平县',130600,1,'2018-05-14 16:43:53'),(130637,'博野县',130600,1,'2018-05-14 16:43:53'),(130638,'雄县',130600,1,'2018-05-14 16:43:53'),(130681,'涿州市',130600,1,'2018-05-14 16:43:53'),(130683,'安国市',130600,1,'2018-05-14 16:43:53'),(130684,'高碑店市',130600,1,'2018-05-14 16:43:53'),(130701,'市辖区',130700,1,'2018-05-14 16:43:53'),(130702,'桥东区',130700,1,'2018-05-14 16:43:53'),(130703,'桥西区',130700,1,'2018-05-14 16:43:53'),(130705,'宣化区',130700,1,'2018-05-14 16:43:53'),(130706,'下花园区',130700,1,'2018-05-14 16:43:53'),(130708,'万全区',130700,1,'2018-05-14 16:43:53'),(130709,'崇礼区',130700,1,'2018-05-14 16:43:53'),(130722,'张北县',130700,1,'2018-05-14 16:43:53'),(130723,'康保县',130700,1,'2018-05-14 16:43:53'),(130724,'沽源县',130700,1,'2018-05-14 16:43:53'),(130725,'尚义县',130700,1,'2018-05-14 16:43:53'),(130726,'蔚县',130700,1,'2018-05-14 16:43:53'),(130727,'阳原县',130700,1,'2018-05-14 16:43:53'),(130728,'怀安县',130700,1,'2018-05-14 16:43:53'),(130730,'怀来县',130700,1,'2018-05-14 16:43:53'),(130731,'涿鹿县',130700,1,'2018-05-14 16:43:53'),(130732,'赤城县',130700,1,'2018-05-14 16:43:53'),(130801,'市辖区',130800,1,'2018-05-14 16:43:53'),(130802,'双桥区',130800,1,'2018-05-14 16:43:53'),(130803,'双滦区',130800,1,'2018-05-14 16:43:53'),(130804,'鹰手营子矿区',130800,1,'2018-05-14 16:43:53'),(130821,'承德县',130800,1,'2018-05-14 16:43:53'),(130822,'兴隆县',130800,1,'2018-05-14 16:43:53'),(130823,'平泉县',130800,1,'2018-05-14 16:43:53'),(130824,'滦平县',130800,1,'2018-05-14 16:43:53'),(130825,'隆化县',130800,1,'2018-05-14 16:43:53'),(130826,'丰宁满族自治县',130800,1,'2018-05-14 16:43:53'),(130827,'宽城满族自治县',130800,1,'2018-05-14 16:43:53'),(130828,'围场满族蒙古族自治县',130800,1,'2018-05-14 16:43:53'),(130901,'市辖区',130900,1,'2018-05-14 16:43:53'),(130902,'新华区',130900,1,'2018-05-14 16:43:53'),(130903,'运河区',130900,1,'2018-05-14 16:43:53'),(130921,'沧县',130900,1,'2018-05-14 16:43:53'),(130922,'青县',130900,1,'2018-05-14 16:43:53'),(130923,'东光县',130900,1,'2018-05-14 16:43:53'),(130924,'海兴县',130900,1,'2018-05-14 16:43:54'),(130925,'盐山县',130900,1,'2018-05-14 16:43:54'),(130926,'肃宁县',130900,1,'2018-05-14 16:43:54'),(130927,'南皮县',130900,1,'2018-05-14 16:43:54'),(130928,'吴桥县',130900,1,'2018-05-14 16:43:54'),(130929,'献县',130900,1,'2018-05-14 16:43:54'),(130930,'孟村回族自治县',130900,1,'2018-05-14 16:43:54'),(130981,'泊头市',130900,1,'2018-05-14 16:43:54'),(130982,'任丘市',130900,1,'2018-05-14 16:43:54'),(130983,'黄骅市',130900,1,'2018-05-14 16:43:54'),(130984,'河间市',130900,1,'2018-05-14 16:43:54'),(131001,'市辖区',131000,1,'2018-05-14 16:43:54'),(131002,'安次区',131000,1,'2018-05-14 16:43:54'),(131003,'广阳区',131000,1,'2018-05-14 16:43:54'),(131022,'固安县',131000,1,'2018-05-14 16:43:54'),(131023,'永清县',131000,1,'2018-05-14 16:43:54'),(131024,'香河县',131000,1,'2018-05-14 16:43:54'),(131025,'大城县',131000,1,'2018-05-14 16:43:54'),(131026,'文安县',131000,1,'2018-05-14 16:43:54'),(131028,'大厂回族自治县',131000,1,'2018-05-14 16:43:54'),(131081,'霸州市',131000,1,'2018-05-14 16:43:54'),(131082,'三河市',131000,1,'2018-05-14 16:43:54'),(131101,'市辖区',131100,1,'2018-05-14 16:43:54'),(131102,'桃城区',131100,1,'2018-05-14 16:43:54'),(131103,'冀州区',131100,1,'2018-05-14 16:43:54'),(131121,'枣强县',131100,1,'2018-05-14 16:43:54'),(131122,'武邑县',131100,1,'2018-05-14 16:43:54'),(131123,'武强县',131100,1,'2018-05-14 16:43:54'),(131124,'饶阳县',131100,1,'2018-05-14 16:43:54'),(131125,'安平县',131100,1,'2018-05-14 16:43:54'),(131126,'故城县',131100,1,'2018-05-14 16:43:54'),(131127,'景县',131100,1,'2018-05-14 16:43:54'),(131128,'阜城县',131100,1,'2018-05-14 16:43:54'),(131182,'深州市',131100,1,'2018-05-14 16:43:54'),(139001,'定州市',139000,1,'2018-05-14 16:43:54'),(139002,'辛集市',139000,1,'2018-05-14 16:43:54'),(140101,'市辖区',140100,1,'2018-05-14 16:43:54'),(140105,'小店区',140100,1,'2018-05-14 16:43:54'),(140106,'迎泽区',140100,1,'2018-05-14 16:43:54'),(140107,'杏花岭区',140100,1,'2018-05-14 16:43:54'),(140108,'尖草坪区',140100,1,'2018-05-14 16:43:54'),(140109,'万柏林区',140100,1,'2018-05-14 16:43:54'),(140110,'晋源区',140100,1,'2018-05-14 16:43:54'),(140121,'清徐县',140100,1,'2018-05-14 16:43:54'),(140122,'阳曲县',140100,1,'2018-05-14 16:43:54'),(140123,'娄烦县',140100,1,'2018-05-14 16:43:54'),(140181,'古交市',140100,1,'2018-05-14 16:43:54'),(140201,'市辖区',140200,1,'2018-05-14 16:43:54'),(140202,'城区',140200,1,'2018-05-14 16:43:54'),(140203,'矿区',140200,1,'2018-05-14 16:43:54'),(140211,'南郊区',140200,1,'2018-05-14 16:43:54'),(140212,'新荣区',140200,1,'2018-05-14 16:43:54'),(140221,'阳高县',140200,1,'2018-05-14 16:43:54'),(140222,'天镇县',140200,1,'2018-05-14 16:43:54'),(140223,'广灵县',140200,1,'2018-05-14 16:43:54'),(140224,'灵丘县',140200,1,'2018-05-14 16:43:54'),(140225,'浑源县',140200,1,'2018-05-14 16:43:54'),(140226,'左云县',140200,1,'2018-05-14 16:43:54'),(140227,'大同县',140200,1,'2018-05-14 16:43:54'),(140301,'市辖区',140300,1,'2018-05-14 16:43:54'),(140302,'城区',140300,1,'2018-05-14 16:43:55'),(140303,'矿区',140300,1,'2018-05-14 16:43:55'),(140311,'郊区',140300,1,'2018-05-14 16:43:55'),(140321,'平定县',140300,1,'2018-05-14 16:43:55'),(140322,'盂县',140300,1,'2018-05-14 16:43:55'),(140401,'市辖区',140400,1,'2018-05-14 16:43:55'),(140402,'城区',140400,1,'2018-05-14 16:43:55'),(140411,'郊区',140400,1,'2018-05-14 16:43:55'),(140421,'长治县',140400,1,'2018-05-14 16:43:55'),(140423,'襄垣县',140400,1,'2018-05-14 16:43:55'),(140424,'屯留县',140400,1,'2018-05-14 16:43:55'),(140425,'平顺县',140400,1,'2018-05-14 16:43:55'),(140426,'黎城县',140400,1,'2018-05-14 16:43:55'),(140427,'壶关县',140400,1,'2018-05-14 16:43:55'),(140428,'长子县',140400,1,'2018-05-14 16:43:55'),(140429,'武乡县',140400,1,'2018-05-14 16:43:55'),(140430,'沁县',140400,1,'2018-05-14 16:43:55'),(140431,'沁源县',140400,1,'2018-05-14 16:43:55'),(140481,'潞城市',140400,1,'2018-05-14 16:43:55'),(140501,'市辖区',140500,1,'2018-05-14 16:43:55'),(140502,'城区',140500,1,'2018-05-14 16:43:55'),(140521,'沁水县',140500,1,'2018-05-14 16:43:55'),(140522,'阳城县',140500,1,'2018-05-14 16:43:55'),(140524,'陵川县',140500,1,'2018-05-14 16:43:55'),(140525,'泽州县',140500,1,'2018-05-14 16:43:55'),(140581,'高平市',140500,1,'2018-05-14 16:43:55'),(140601,'市辖区',140600,1,'2018-05-14 16:43:55'),(140602,'朔城区',140600,1,'2018-05-14 16:43:55'),(140603,'平鲁区',140600,1,'2018-05-14 16:43:55'),(140621,'山阴县',140600,1,'2018-05-14 16:43:55'),(140622,'应县',140600,1,'2018-05-14 16:43:55'),(140623,'右玉县',140600,1,'2018-05-14 16:43:55'),(140624,'怀仁县',140600,1,'2018-05-14 16:43:55'),(140701,'市辖区',140700,1,'2018-05-14 16:43:55'),(140702,'榆次区',140700,1,'2018-05-14 16:43:55'),(140721,'榆社县',140700,1,'2018-05-14 16:43:55'),(140722,'左权县',140700,1,'2018-05-14 16:43:55'),(140723,'和顺县',140700,1,'2018-05-14 16:43:55'),(140724,'昔阳县',140700,1,'2018-05-14 16:43:55'),(140725,'寿阳县',140700,1,'2018-05-14 16:43:55'),(140726,'太谷县',140700,1,'2018-05-14 16:43:55'),(140727,'祁县',140700,1,'2018-05-14 16:43:55'),(140728,'平遥县',140700,1,'2018-05-14 16:43:55'),(140729,'灵石县',140700,1,'2018-05-14 16:43:55'),(140781,'介休市',140700,1,'2018-05-14 16:43:55'),(140801,'市辖区',140800,1,'2018-05-14 16:43:55'),(140802,'盐湖区',140800,1,'2018-05-14 16:43:55'),(140821,'临猗县',140800,1,'2018-05-14 16:43:55'),(140822,'万荣县',140800,1,'2018-05-14 16:43:55'),(140823,'闻喜县',140800,1,'2018-05-14 16:43:55'),(140824,'稷山县',140800,1,'2018-05-14 16:43:55'),(140825,'新绛县',140800,1,'2018-05-14 16:43:55'),(140826,'绛县',140800,1,'2018-05-14 16:43:55'),(140827,'垣曲县',140800,1,'2018-05-14 16:43:55'),(140828,'夏县',140800,1,'2018-05-14 16:43:55'),(140829,'平陆县',140800,1,'2018-05-14 16:43:55'),(140830,'芮城县',140800,1,'2018-05-14 16:43:55'),(140881,'永济市',140800,1,'2018-05-14 16:43:55'),(140882,'河津市',140800,1,'2018-05-14 16:43:55'),(140901,'市辖区',140900,1,'2018-05-14 16:43:55'),(140902,'忻府区',140900,1,'2018-05-14 16:43:55'),(140921,'定襄县',140900,1,'2018-05-14 16:43:55'),(140922,'五台县',140900,1,'2018-05-14 16:43:55'),(140923,'代县',140900,1,'2018-05-14 16:43:55'),(140924,'繁峙县',140900,1,'2018-05-14 16:43:56'),(140925,'宁武县',140900,1,'2018-05-14 16:43:56'),(140926,'静乐县',140900,1,'2018-05-14 16:43:56'),(140927,'神池县',140900,1,'2018-05-14 16:43:56'),(140928,'五寨县',140900,1,'2018-05-14 16:43:56'),(140929,'岢岚县',140900,1,'2018-05-14 16:43:56'),(140930,'河曲县',140900,1,'2018-05-14 16:43:56'),(140931,'保德县',140900,1,'2018-05-14 16:43:56'),(140932,'偏关县',140900,1,'2018-05-14 16:43:56'),(140981,'原平市',140900,1,'2018-05-14 16:43:56'),(141001,'市辖区',141000,1,'2018-05-14 16:43:56'),(141002,'尧都区',141000,1,'2018-05-14 16:43:56'),(141021,'曲沃县',141000,1,'2018-05-14 16:43:56'),(141022,'翼城县',141000,1,'2018-05-14 16:43:56'),(141023,'襄汾县',141000,1,'2018-05-14 16:43:56'),(141024,'洪洞县',141000,1,'2018-05-14 16:43:56'),(141025,'古县',141000,1,'2018-05-14 16:43:56'),(141026,'安泽县',141000,1,'2018-05-14 16:43:56'),(141027,'浮山县',141000,1,'2018-05-14 16:43:56'),(141028,'吉县',141000,1,'2018-05-14 16:43:56'),(141029,'乡宁县',141000,1,'2018-05-14 16:43:56'),(141030,'大宁县',141000,1,'2018-05-14 16:43:56'),(141031,'隰县',141000,1,'2018-05-14 16:43:56'),(141032,'永和县',141000,1,'2018-05-14 16:43:56'),(141033,'蒲县',141000,1,'2018-05-14 16:43:56'),(141034,'汾西县',141000,1,'2018-05-14 16:43:56'),(141081,'侯马市',141000,1,'2018-05-14 16:43:56'),(141082,'霍州市',141000,1,'2018-05-14 16:43:56'),(141101,'市辖区',141100,1,'2018-05-14 16:43:56'),(141102,'离石区',141100,1,'2018-05-14 16:43:56'),(141121,'文水县',141100,1,'2018-05-14 16:43:56'),(141122,'交城县',141100,1,'2018-05-14 16:43:56'),(141123,'兴县',141100,1,'2018-05-14 16:43:56'),(141124,'临县',141100,1,'2018-05-14 16:43:56'),(141125,'柳林县',141100,1,'2018-05-14 16:43:56'),(141126,'石楼县',141100,1,'2018-05-14 16:43:56'),(141127,'岚县',141100,1,'2018-05-14 16:43:56'),(141128,'方山县',141100,1,'2018-05-14 16:43:56'),(141129,'中阳县',141100,1,'2018-05-14 16:43:56'),(141130,'交口县',141100,1,'2018-05-14 16:43:56'),(141181,'孝义市',141100,1,'2018-05-14 16:43:56'),(141182,'汾阳市',141100,1,'2018-05-14 16:43:56'),(150101,'市辖区',150100,1,'2018-05-14 16:43:56'),(150102,'新城区',150100,1,'2018-05-14 16:43:56'),(150103,'回民区',150100,1,'2018-05-14 16:43:56'),(150104,'玉泉区',150100,1,'2018-05-14 16:43:56'),(150105,'赛罕区',150100,1,'2018-05-14 16:43:56'),(150121,'土默特左旗',150100,1,'2018-05-14 16:43:56'),(150122,'托克托县',150100,1,'2018-05-14 16:43:56'),(150123,'和林格尔县',150100,1,'2018-05-14 16:43:56'),(150124,'清水河县',150100,1,'2018-05-14 16:43:56'),(150125,'武川县',150100,1,'2018-05-14 16:43:56'),(150201,'市辖区',150200,1,'2018-05-14 16:43:56'),(150202,'东河区',150200,1,'2018-05-14 16:43:56'),(150203,'昆都仑区',150200,1,'2018-05-14 16:43:56'),(150204,'青山区',150200,1,'2018-05-14 16:43:56'),(150205,'石拐区',150200,1,'2018-05-14 16:43:56'),(150206,'白云鄂博矿区',150200,1,'2018-05-14 16:43:56'),(150207,'九原区',150200,1,'2018-05-14 16:43:56'),(150221,'土默特右旗',150200,1,'2018-05-14 16:43:56'),(150222,'固阳县',150200,1,'2018-05-14 16:43:56'),(150223,'达尔罕茂明安联合旗',150200,1,'2018-05-14 16:43:56'),(150301,'市辖区',150300,1,'2018-05-14 16:43:57'),(150302,'海勃湾区',150300,1,'2018-05-14 16:43:57'),(150303,'海南区',150300,1,'2018-05-14 16:43:57'),(150304,'乌达区',150300,1,'2018-05-14 16:43:57'),(150401,'市辖区',150400,1,'2018-05-14 16:43:57'),(150402,'红山区',150400,1,'2018-05-14 16:43:57'),(150403,'元宝山区',150400,1,'2018-05-14 16:43:57'),(150404,'松山区',150400,1,'2018-05-14 16:43:57'),(150421,'阿鲁科尔沁旗',150400,1,'2018-05-14 16:43:57'),(150422,'巴林左旗',150400,1,'2018-05-14 16:43:57'),(150423,'巴林右旗',150400,1,'2018-05-14 16:43:57'),(150424,'林西县',150400,1,'2018-05-14 16:43:57'),(150425,'克什克腾旗',150400,1,'2018-05-14 16:43:57'),(150426,'翁牛特旗',150400,1,'2018-05-14 16:43:57'),(150428,'喀喇沁旗',150400,1,'2018-05-14 16:43:57'),(150429,'宁城县',150400,1,'2018-05-14 16:43:57'),(150430,'敖汉旗',150400,1,'2018-05-14 16:43:57'),(150501,'市辖区',150500,1,'2018-05-14 16:43:57'),(150502,'科尔沁区',150500,1,'2018-05-14 16:43:57'),(150521,'科尔沁左翼中旗',150500,1,'2018-05-14 16:43:57'),(150522,'科尔沁左翼后旗',150500,1,'2018-05-14 16:43:57'),(150523,'开鲁县',150500,1,'2018-05-14 16:43:57'),(150524,'库伦旗',150500,1,'2018-05-14 16:43:57'),(150525,'奈曼旗',150500,1,'2018-05-14 16:43:57'),(150526,'扎鲁特旗',150500,1,'2018-05-14 16:43:57'),(150581,'霍林郭勒市',150500,1,'2018-05-14 16:43:57'),(150601,'市辖区',150600,1,'2018-05-14 16:43:57'),(150602,'东胜区',150600,1,'2018-05-14 16:43:57'),(150603,'康巴什区',150600,1,'2018-05-14 16:43:57'),(150621,'达拉特旗',150600,1,'2018-05-14 16:43:57'),(150622,'准格尔旗',150600,1,'2018-05-14 16:43:57'),(150623,'鄂托克前旗',150600,1,'2018-05-14 16:43:57'),(150624,'鄂托克旗',150600,1,'2018-05-14 16:43:57'),(150625,'杭锦旗',150600,1,'2018-05-14 16:43:57'),(150626,'乌审旗',150600,1,'2018-05-14 16:43:57'),(150627,'伊金霍洛旗',150600,1,'2018-05-14 16:43:57'),(150701,'市辖区',150700,1,'2018-05-14 16:43:57'),(150702,'海拉尔区',150700,1,'2018-05-14 16:43:57'),(150703,'扎赉诺尔区',150700,1,'2018-05-14 16:43:57'),(150721,'阿荣旗',150700,1,'2018-05-14 16:43:57'),(150722,'莫力达瓦达斡尔族自治旗',150700,1,'2018-05-14 16:43:57'),(150723,'鄂伦春自治旗',150700,1,'2018-05-14 16:43:57'),(150724,'鄂温克族自治旗',150700,1,'2018-05-14 16:43:57'),(150725,'陈巴尔虎旗',150700,1,'2018-05-14 16:43:57'),(150726,'新巴尔虎左旗',150700,1,'2018-05-14 16:43:57'),(150727,'新巴尔虎右旗',150700,1,'2018-05-14 16:43:57'),(150781,'满洲里市',150700,1,'2018-05-14 16:43:57'),(150782,'牙克石市',150700,1,'2018-05-14 16:43:57'),(150783,'扎兰屯市',150700,1,'2018-05-14 16:43:57'),(150784,'额尔古纳市',150700,1,'2018-05-14 16:43:57'),(150785,'根河市',150700,1,'2018-05-14 16:43:57'),(150801,'市辖区',150800,1,'2018-05-14 16:43:57'),(150802,'临河区',150800,1,'2018-05-14 16:43:57'),(150821,'五原县',150800,1,'2018-05-14 16:43:57'),(150822,'磴口县',150800,1,'2018-05-14 16:43:58'),(150823,'乌拉特前旗',150800,1,'2018-05-14 16:43:58'),(150824,'乌拉特中旗',150800,1,'2018-05-14 16:43:58'),(150825,'乌拉特后旗',150800,1,'2018-05-14 16:43:58'),(150826,'杭锦后旗',150800,1,'2018-05-14 16:43:58'),(150901,'市辖区',150900,1,'2018-05-14 16:43:58'),(150902,'集宁区',150900,1,'2018-05-14 16:43:58'),(150921,'卓资县',150900,1,'2018-05-14 16:43:58'),(150922,'化德县',150900,1,'2018-05-14 16:43:58'),(150923,'商都县',150900,1,'2018-05-14 16:43:58'),(150924,'兴和县',150900,1,'2018-05-14 16:43:58'),(150925,'凉城县',150900,1,'2018-05-14 16:43:58'),(150926,'察哈尔右翼前旗',150900,1,'2018-05-14 16:43:58'),(150927,'察哈尔右翼中旗',150900,1,'2018-05-14 16:43:58'),(150928,'察哈尔右翼后旗',150900,1,'2018-05-14 16:43:58'),(150929,'四子王旗',150900,1,'2018-05-14 16:43:58'),(150981,'丰镇市',150900,1,'2018-05-14 16:43:58'),(152201,'乌兰浩特市',152200,1,'2018-05-14 16:43:58'),(152202,'阿尔山市',152200,1,'2018-05-14 16:43:58'),(152221,'科尔沁右翼前旗',152200,1,'2018-05-14 16:43:58'),(152222,'科尔沁右翼中旗',152200,1,'2018-05-14 16:43:58'),(152223,'扎赉特旗',152200,1,'2018-05-14 16:43:58'),(152224,'突泉县',152200,1,'2018-05-14 16:43:58'),(152501,'二连浩特市',152500,1,'2018-05-14 16:43:58'),(152502,'锡林浩特市',152500,1,'2018-05-14 16:43:58'),(152522,'阿巴嘎旗',152500,1,'2018-05-14 16:43:58'),(152523,'苏尼特左旗',152500,1,'2018-05-14 16:43:58'),(152524,'苏尼特右旗',152500,1,'2018-05-14 16:43:58'),(152525,'东乌珠穆沁旗',152500,1,'2018-05-14 16:43:58'),(152526,'西乌珠穆沁旗',152500,1,'2018-05-14 16:43:58'),(152527,'太仆寺旗',152500,1,'2018-05-14 16:43:58'),(152528,'镶黄旗',152500,1,'2018-05-14 16:43:58'),(152529,'正镶白旗',152500,1,'2018-05-14 16:43:58'),(152530,'正蓝旗',152500,1,'2018-05-14 16:43:58'),(152531,'多伦县',152500,1,'2018-05-14 16:43:58'),(152921,'阿拉善左旗',152900,1,'2018-05-14 16:43:58'),(152922,'阿拉善右旗',152900,1,'2018-05-14 16:43:58'),(152923,'额济纳旗',152900,1,'2018-05-14 16:43:58'),(210101,'市辖区',210100,1,'2018-05-14 16:43:58'),(210102,'和平区',210100,1,'2018-05-14 16:43:58'),(210103,'沈河区',210100,1,'2018-05-14 16:43:58'),(210104,'大东区',210100,1,'2018-05-14 16:43:58'),(210105,'皇姑区',210100,1,'2018-05-14 16:43:58'),(210106,'铁西区',210100,1,'2018-05-14 16:43:58'),(210111,'苏家屯区',210100,1,'2018-05-14 16:43:58'),(210112,'浑南区',210100,1,'2018-05-14 16:43:58'),(210113,'沈北新区',210100,1,'2018-05-14 16:43:58'),(210114,'于洪区',210100,1,'2018-05-14 16:43:58'),(210115,'辽中区',210100,1,'2018-05-14 16:43:58'),(210123,'康平县',210100,1,'2018-05-14 16:43:58'),(210124,'法库县',210100,1,'2018-05-14 16:43:58'),(210181,'新民市',210100,1,'2018-05-14 16:43:58'),(210201,'市辖区',210200,1,'2018-05-14 16:43:58'),(210202,'中山区',210200,1,'2018-05-14 16:43:58'),(210203,'西岗区',210200,1,'2018-05-14 16:43:58'),(210204,'沙河口区',210200,1,'2018-05-14 16:43:58'),(210211,'甘井子区',210200,1,'2018-05-14 16:43:58'),(210212,'旅顺口区',210200,1,'2018-05-14 16:43:58'),(210213,'金州区',210200,1,'2018-05-14 16:43:58'),(210214,'普兰店区',210200,1,'2018-05-14 16:43:58'),(210224,'长海县',210200,1,'2018-05-14 16:43:59'),(210281,'瓦房店市',210200,1,'2018-05-14 16:43:59'),(210283,'庄河市',210200,1,'2018-05-14 16:43:59'),(210301,'市辖区',210300,1,'2018-05-14 16:43:59'),(210302,'铁东区',210300,1,'2018-05-14 16:43:59'),(210303,'铁西区',210300,1,'2018-05-14 16:43:59'),(210304,'立山区',210300,1,'2018-05-14 16:43:59'),(210311,'千山区',210300,1,'2018-05-14 16:43:59'),(210321,'台安县',210300,1,'2018-05-14 16:43:59'),(210323,'岫岩满族自治县',210300,1,'2018-05-14 16:43:59'),(210381,'海城市',210300,1,'2018-05-14 16:43:59'),(210401,'市辖区',210400,1,'2018-05-14 16:43:59'),(210402,'新抚区',210400,1,'2018-05-14 16:43:59'),(210403,'东洲区',210400,1,'2018-05-14 16:43:59'),(210404,'望花区',210400,1,'2018-05-14 16:43:59'),(210411,'顺城区',210400,1,'2018-05-14 16:43:59'),(210421,'抚顺县',210400,1,'2018-05-14 16:43:59'),(210422,'新宾满族自治县',210400,1,'2018-05-14 16:43:59'),(210423,'清原满族自治县',210400,1,'2018-05-14 16:43:59'),(210501,'市辖区',210500,1,'2018-05-14 16:43:59'),(210502,'平山区',210500,1,'2018-05-14 16:43:59'),(210503,'溪湖区',210500,1,'2018-05-14 16:43:59'),(210504,'明山区',210500,1,'2018-05-14 16:43:59'),(210505,'南芬区',210500,1,'2018-05-14 16:43:59'),(210521,'本溪满族自治县',210500,1,'2018-05-14 16:43:59'),(210522,'桓仁满族自治县',210500,1,'2018-05-14 16:43:59'),(210601,'市辖区',210600,1,'2018-05-14 16:43:59'),(210602,'元宝区',210600,1,'2018-05-14 16:43:59'),(210603,'振兴区',210600,1,'2018-05-14 16:43:59'),(210604,'振安区',210600,1,'2018-05-14 16:43:59'),(210624,'宽甸满族自治县',210600,1,'2018-05-14 16:43:59'),(210681,'东港市',210600,1,'2018-05-14 16:43:59'),(210682,'凤城市',210600,1,'2018-05-14 16:43:59'),(210701,'市辖区',210700,1,'2018-05-14 16:43:59'),(210702,'古塔区',210700,1,'2018-05-14 16:43:59'),(210703,'凌河区',210700,1,'2018-05-14 16:43:59'),(210711,'太和区',210700,1,'2018-05-14 16:43:59'),(210726,'黑山县',210700,1,'2018-05-14 16:43:59'),(210727,'义县',210700,1,'2018-05-14 16:43:59'),(210781,'凌海市',210700,1,'2018-05-14 16:43:59'),(210782,'北镇市',210700,1,'2018-05-14 16:43:59'),(210801,'市辖区',210800,1,'2018-05-14 16:43:59'),(210802,'站前区',210800,1,'2018-05-14 16:43:59'),(210803,'西市区',210800,1,'2018-05-14 16:43:59'),(210804,'鲅鱼圈区',210800,1,'2018-05-14 16:43:59'),(210811,'老边区',210800,1,'2018-05-14 16:43:59'),(210881,'盖州市',210800,1,'2018-05-14 16:43:59'),(210882,'大石桥市',210800,1,'2018-05-14 16:43:59'),(210901,'市辖区',210900,1,'2018-05-14 16:43:59'),(210902,'海州区',210900,1,'2018-05-14 16:43:59'),(210903,'新邱区',210900,1,'2018-05-14 16:43:59'),(210904,'太平区',210900,1,'2018-05-14 16:43:59'),(210905,'清河门区',210900,1,'2018-05-14 16:43:59'),(210911,'细河区',210900,1,'2018-05-14 16:43:59'),(210921,'阜新蒙古族自治县',210900,1,'2018-05-14 16:44:00'),(210922,'彰武县',210900,1,'2018-05-14 16:44:00'),(211001,'市辖区',211000,1,'2018-05-14 16:44:00'),(211002,'白塔区',211000,1,'2018-05-14 16:44:00'),(211003,'文圣区',211000,1,'2018-05-14 16:44:00'),(211004,'宏伟区',211000,1,'2018-05-14 16:44:00'),(211005,'弓长岭区',211000,1,'2018-05-14 16:44:00'),(211011,'太子河区',211000,1,'2018-05-14 16:44:00'),(211021,'辽阳县',211000,1,'2018-05-14 16:44:00'),(211081,'灯塔市',211000,1,'2018-05-14 16:44:00'),(211101,'市辖区',211100,1,'2018-05-14 16:44:00'),(211102,'双台子区',211100,1,'2018-05-14 16:44:00'),(211103,'兴隆台区',211100,1,'2018-05-14 16:44:00'),(211104,'大洼区',211100,1,'2018-05-14 16:44:00'),(211122,'盘山县',211100,1,'2018-05-14 16:44:00'),(211201,'市辖区',211200,1,'2018-05-14 16:44:00'),(211202,'银州区',211200,1,'2018-05-14 16:44:00'),(211204,'清河区',211200,1,'2018-05-14 16:44:00'),(211221,'铁岭县',211200,1,'2018-05-14 16:44:00'),(211223,'西丰县',211200,1,'2018-05-14 16:44:00'),(211224,'昌图县',211200,1,'2018-05-14 16:44:00'),(211281,'调兵山市',211200,1,'2018-05-14 16:44:00'),(211282,'开原市',211200,1,'2018-05-14 16:44:00'),(211301,'市辖区',211300,1,'2018-05-14 16:44:00'),(211302,'双塔区',211300,1,'2018-05-14 16:44:00'),(211303,'龙城区',211300,1,'2018-05-14 16:44:00'),(211321,'朝阳县',211300,1,'2018-05-14 16:44:00'),(211322,'建平县',211300,1,'2018-05-14 16:44:00'),(211324,'喀喇沁左翼蒙古族自治县',211300,1,'2018-05-14 16:44:00'),(211381,'北票市',211300,1,'2018-05-14 16:44:00'),(211382,'凌源市',211300,1,'2018-05-14 16:44:00'),(211401,'市辖区',211400,1,'2018-05-14 16:44:00'),(211402,'连山区',211400,1,'2018-05-14 16:44:00'),(211403,'龙港区',211400,1,'2018-05-14 16:44:00'),(211404,'南票区',211400,1,'2018-05-14 16:44:00'),(211421,'绥中县',211400,1,'2018-05-14 16:44:00'),(211422,'建昌县',211400,1,'2018-05-14 16:44:00'),(211481,'兴城市',211400,1,'2018-05-14 16:44:00'),(220101,'市辖区',220100,1,'2018-05-14 16:44:00'),(220102,'南关区',220100,1,'2018-05-14 16:44:00'),(220103,'宽城区',220100,1,'2018-05-14 16:44:00'),(220104,'朝阳区',220100,1,'2018-05-14 16:44:00'),(220105,'二道区',220100,1,'2018-05-14 16:44:00'),(220106,'绿园区',220100,1,'2018-05-14 16:44:00'),(220112,'双阳区',220100,1,'2018-05-14 16:44:00'),(220113,'九台区',220100,1,'2018-05-14 16:44:00'),(220122,'农安县',220100,1,'2018-05-14 16:44:00'),(220182,'榆树市',220100,1,'2018-05-14 16:44:00'),(220183,'德惠市',220100,1,'2018-05-14 16:44:00'),(220201,'市辖区',220200,1,'2018-05-14 16:44:00'),(220202,'昌邑区',220200,1,'2018-05-14 16:44:00'),(220203,'龙潭区',220200,1,'2018-05-14 16:44:00'),(220204,'船营区',220200,1,'2018-05-14 16:44:00'),(220211,'丰满区',220200,1,'2018-05-14 16:44:00'),(220221,'永吉县',220200,1,'2018-05-14 16:44:00'),(220281,'蛟河市',220200,1,'2018-05-14 16:44:00'),(220282,'桦甸市',220200,1,'2018-05-14 16:44:00'),(220283,'舒兰市',220200,1,'2018-05-14 16:44:00'),(220284,'磐石市',220200,1,'2018-05-14 16:44:00'),(220301,'市辖区',220300,1,'2018-05-14 16:44:01'),(220302,'铁西区',220300,1,'2018-05-14 16:44:01'),(220303,'铁东区',220300,1,'2018-05-14 16:44:01'),(220322,'梨树县',220300,1,'2018-05-14 16:44:01'),(220323,'伊通满族自治县',220300,1,'2018-05-14 16:44:01'),(220381,'公主岭市',220300,1,'2018-05-14 16:44:01'),(220382,'双辽市',220300,1,'2018-05-14 16:44:01'),(220401,'市辖区',220400,1,'2018-05-14 16:44:01'),(220402,'龙山区',220400,1,'2018-05-14 16:44:01'),(220403,'西安区',220400,1,'2018-05-14 16:44:01'),(220421,'东丰县',220400,1,'2018-05-14 16:44:01'),(220422,'东辽县',220400,1,'2018-05-14 16:44:01'),(220501,'市辖区',220500,1,'2018-05-14 16:44:01'),(220502,'东昌区',220500,1,'2018-05-14 16:44:01'),(220503,'二道江区',220500,1,'2018-05-14 16:44:01'),(220521,'通化县',220500,1,'2018-05-14 16:44:01'),(220523,'辉南县',220500,1,'2018-05-14 16:44:01'),(220524,'柳河县',220500,1,'2018-05-14 16:44:01'),(220581,'梅河口市',220500,1,'2018-05-14 16:44:01'),(220582,'集安市',220500,1,'2018-05-14 16:44:01'),(220601,'市辖区',220600,1,'2018-05-14 16:44:01'),(220602,'浑江区',220600,1,'2018-05-14 16:44:01'),(220605,'江源区',220600,1,'2018-05-14 16:44:01'),(220621,'抚松县',220600,1,'2018-05-14 16:44:01'),(220622,'靖宇县',220600,1,'2018-05-14 16:44:01'),(220623,'长白朝鲜族自治县',220600,1,'2018-05-14 16:44:01'),(220681,'临江市',220600,1,'2018-05-14 16:44:01'),(220701,'市辖区',220700,1,'2018-05-14 16:44:01'),(220702,'宁江区',220700,1,'2018-05-14 16:44:01'),(220721,'前郭尔罗斯蒙古族自治县',220700,1,'2018-05-14 16:44:01'),(220722,'长岭县',220700,1,'2018-05-14 16:44:01'),(220723,'乾安县',220700,1,'2018-05-14 16:44:01'),(220781,'扶余市',220700,1,'2018-05-14 16:44:01'),(220801,'市辖区',220800,1,'2018-05-14 16:44:01'),(220802,'洮北区',220800,1,'2018-05-14 16:44:01'),(220821,'镇赉县',220800,1,'2018-05-14 16:44:01'),(220822,'通榆县',220800,1,'2018-05-14 16:44:01'),(220881,'洮南市',220800,1,'2018-05-14 16:44:01'),(220882,'大安市',220800,1,'2018-05-14 16:44:01'),(222401,'延吉市',222400,1,'2018-05-14 16:44:01'),(222402,'图们市',222400,1,'2018-05-14 16:44:01'),(222403,'敦化市',222400,1,'2018-05-14 16:44:01'),(222404,'珲春市',222400,1,'2018-05-14 16:44:01'),(222405,'龙井市',222400,1,'2018-05-14 16:44:01'),(222406,'和龙市',222400,1,'2018-05-14 16:44:01'),(222424,'汪清县',222400,1,'2018-05-14 16:44:01'),(222426,'安图县',222400,1,'2018-05-14 16:44:01'),(230101,'市辖区',230100,1,'2018-05-14 16:44:01'),(230102,'道里区',230100,1,'2018-05-14 16:44:01'),(230103,'南岗区',230100,1,'2018-05-14 16:44:01'),(230104,'道外区',230100,1,'2018-05-14 16:44:01'),(230108,'平房区',230100,1,'2018-05-14 16:44:01'),(230109,'松北区',230100,1,'2018-05-14 16:44:01'),(230110,'香坊区',230100,1,'2018-05-14 16:44:01'),(230111,'呼兰区',230100,1,'2018-05-14 16:44:01'),(230112,'阿城区',230100,1,'2018-05-14 16:44:01'),(230113,'双城区',230100,1,'2018-05-14 16:44:01'),(230123,'依兰县',230100,1,'2018-05-14 16:44:01'),(230124,'方正县',230100,1,'2018-05-14 16:44:01'),(230125,'宾县',230100,1,'2018-05-14 16:44:01'),(230126,'巴彦县',230100,1,'2018-05-14 16:44:01'),(230127,'木兰县',230100,1,'2018-05-14 16:44:01'),(230128,'通河县',230100,1,'2018-05-14 16:44:02'),(230129,'延寿县',230100,1,'2018-05-14 16:44:02'),(230183,'尚志市',230100,1,'2018-05-14 16:44:02'),(230184,'五常市',230100,1,'2018-05-14 16:44:02'),(230201,'市辖区',230200,1,'2018-05-14 16:44:02'),(230202,'龙沙区',230200,1,'2018-05-14 16:44:02'),(230203,'建华区',230200,1,'2018-05-14 16:44:02'),(230204,'铁锋区',230200,1,'2018-05-14 16:44:02'),(230205,'昂昂溪区',230200,1,'2018-05-14 16:44:02'),(230206,'富拉尔基区',230200,1,'2018-05-14 16:44:02'),(230207,'碾子山区',230200,1,'2018-05-14 16:44:02'),(230208,'梅里斯达斡尔族区',230200,1,'2018-05-14 16:44:02'),(230221,'龙江县',230200,1,'2018-05-14 16:44:02'),(230223,'依安县',230200,1,'2018-05-14 16:44:02'),(230224,'泰来县',230200,1,'2018-05-14 16:44:02'),(230225,'甘南县',230200,1,'2018-05-14 16:44:02'),(230227,'富裕县',230200,1,'2018-05-14 16:44:02'),(230229,'克山县',230200,1,'2018-05-14 16:44:02'),(230230,'克东县',230200,1,'2018-05-14 16:44:02'),(230231,'拜泉县',230200,1,'2018-05-14 16:44:02'),(230281,'讷河市',230200,1,'2018-05-14 16:44:02'),(230301,'市辖区',230300,1,'2018-05-14 16:44:02'),(230302,'鸡冠区',230300,1,'2018-05-14 16:44:02'),(230303,'恒山区',230300,1,'2018-05-14 16:44:02'),(230304,'滴道区',230300,1,'2018-05-14 16:44:02'),(230305,'梨树区',230300,1,'2018-05-14 16:44:02'),(230306,'城子河区',230300,1,'2018-05-14 16:44:02'),(230307,'麻山区',230300,1,'2018-05-14 16:44:02'),(230321,'鸡东县',230300,1,'2018-05-14 16:44:02'),(230381,'虎林市',230300,1,'2018-05-14 16:44:02'),(230382,'密山市',230300,1,'2018-05-14 16:44:02'),(230401,'市辖区',230400,1,'2018-05-14 16:44:02'),(230402,'向阳区',230400,1,'2018-05-14 16:44:02'),(230403,'工农区',230400,1,'2018-05-14 16:44:02'),(230404,'南山区',230400,1,'2018-05-14 16:44:02'),(230405,'兴安区',230400,1,'2018-05-14 16:44:02'),(230406,'东山区',230400,1,'2018-05-14 16:44:02'),(230407,'兴山区',230400,1,'2018-05-14 16:44:02'),(230421,'萝北县',230400,1,'2018-05-14 16:44:02'),(230422,'绥滨县',230400,1,'2018-05-14 16:44:02'),(230501,'市辖区',230500,1,'2018-05-14 16:44:02'),(230502,'尖山区',230500,1,'2018-05-14 16:44:02'),(230503,'岭东区',230500,1,'2018-05-14 16:44:02'),(230505,'四方台区',230500,1,'2018-05-14 16:44:02'),(230506,'宝山区',230500,1,'2018-05-14 16:44:02'),(230521,'集贤县',230500,1,'2018-05-14 16:44:02'),(230522,'友谊县',230500,1,'2018-05-14 16:44:02'),(230523,'宝清县',230500,1,'2018-05-14 16:44:02'),(230524,'饶河县',230500,1,'2018-05-14 16:44:02'),(230601,'市辖区',230600,1,'2018-05-14 16:44:02'),(230602,'萨尔图区',230600,1,'2018-05-14 16:44:02'),(230603,'龙凤区',230600,1,'2018-05-14 16:44:02'),(230604,'让胡路区',230600,1,'2018-05-14 16:44:02'),(230605,'红岗区',230600,1,'2018-05-14 16:44:02'),(230606,'大同区',230600,1,'2018-05-14 16:44:02'),(230621,'肇州县',230600,1,'2018-05-14 16:44:02'),(230622,'肇源县',230600,1,'2018-05-14 16:44:02'),(230623,'林甸县',230600,1,'2018-05-14 16:44:02'),(230624,'杜尔伯特蒙古族自治县',230600,1,'2018-05-14 16:44:02'),(230701,'市辖区',230700,1,'2018-05-14 16:44:02'),(230702,'伊春区',230700,1,'2018-05-14 16:44:03'),(230703,'南岔区',230700,1,'2018-05-14 16:44:03'),(230704,'友好区',230700,1,'2018-05-14 16:44:03'),(230705,'西林区',230700,1,'2018-05-14 16:44:03'),(230706,'翠峦区',230700,1,'2018-05-14 16:44:03'),(230707,'新青区',230700,1,'2018-05-14 16:44:03'),(230708,'美溪区',230700,1,'2018-05-14 16:44:03'),(230709,'金山屯区',230700,1,'2018-05-14 16:44:03'),(230710,'五营区',230700,1,'2018-05-14 16:44:03'),(230711,'乌马河区',230700,1,'2018-05-14 16:44:03'),(230712,'汤旺河区',230700,1,'2018-05-14 16:44:03'),(230713,'带岭区',230700,1,'2018-05-14 16:44:03'),(230714,'乌伊岭区',230700,1,'2018-05-14 16:44:03'),(230715,'红星区',230700,1,'2018-05-14 16:44:03'),(230716,'上甘岭区',230700,1,'2018-05-14 16:44:03'),(230722,'嘉荫县',230700,1,'2018-05-14 16:44:03'),(230781,'铁力市',230700,1,'2018-05-14 16:44:03'),(230801,'市辖区',230800,1,'2018-05-14 16:44:03'),(230803,'向阳区',230800,1,'2018-05-14 16:44:03'),(230804,'前进区',230800,1,'2018-05-14 16:44:03'),(230805,'东风区',230800,1,'2018-05-14 16:44:03'),(230811,'郊区',230800,1,'2018-05-14 16:44:03'),(230822,'桦南县',230800,1,'2018-05-14 16:44:03'),(230826,'桦川县',230800,1,'2018-05-14 16:44:03'),(230828,'汤原县',230800,1,'2018-05-14 16:44:03'),(230881,'同江市',230800,1,'2018-05-14 16:44:03'),(230882,'富锦市',230800,1,'2018-05-14 16:44:03'),(230883,'抚远市',230800,1,'2018-05-14 16:44:03'),(230901,'市辖区',230900,1,'2018-05-14 16:44:03'),(230902,'新兴区',230900,1,'2018-05-14 16:44:03'),(230903,'桃山区',230900,1,'2018-05-14 16:44:03'),(230904,'茄子河区',230900,1,'2018-05-14 16:44:03'),(230921,'勃利县',230900,1,'2018-05-14 16:44:03'),(231001,'市辖区',231000,1,'2018-05-14 16:44:03'),(231002,'东安区',231000,1,'2018-05-14 16:44:03'),(231003,'阳明区',231000,1,'2018-05-14 16:44:03'),(231004,'爱民区',231000,1,'2018-05-14 16:44:03'),(231005,'西安区',231000,1,'2018-05-14 16:44:03'),(231025,'林口县',231000,1,'2018-05-14 16:44:03'),(231081,'绥芬河市',231000,1,'2018-05-14 16:44:03'),(231083,'海林市',231000,1,'2018-05-14 16:44:03'),(231084,'宁安市',231000,1,'2018-05-14 16:44:03'),(231085,'穆棱市',231000,1,'2018-05-14 16:44:03'),(231086,'东宁市',231000,1,'2018-05-14 16:44:03'),(231101,'市辖区',231100,1,'2018-05-14 16:44:03'),(231102,'爱辉区',231100,1,'2018-05-14 16:44:03'),(231121,'嫩江县',231100,1,'2018-05-14 16:44:03'),(231123,'逊克县',231100,1,'2018-05-14 16:44:03'),(231124,'孙吴县',231100,1,'2018-05-14 16:44:03'),(231181,'北安市',231100,1,'2018-05-14 16:44:03'),(231182,'五大连池市',231100,1,'2018-05-14 16:44:03'),(231201,'市辖区',231200,1,'2018-05-14 16:44:03'),(231202,'北林区',231200,1,'2018-05-14 16:44:03'),(231221,'望奎县',231200,1,'2018-05-14 16:44:03'),(231222,'兰西县',231200,1,'2018-05-14 16:44:03'),(231223,'青冈县',231200,1,'2018-05-14 16:44:03'),(231224,'庆安县',231200,1,'2018-05-14 16:44:03'),(231225,'明水县',231200,1,'2018-05-14 16:44:03'),(231226,'绥棱县',231200,1,'2018-05-14 16:44:03'),(231281,'安达市',231200,1,'2018-05-14 16:44:03'),(231282,'肇东市',231200,1,'2018-05-14 16:44:04'),(231283,'海伦市',231200,1,'2018-05-14 16:44:04'),(232721,'呼玛县',232700,1,'2018-05-14 16:44:04'),(232722,'塔河县',232700,1,'2018-05-14 16:44:04'),(232723,'漠河县',232700,1,'2018-05-14 16:44:04'),(310101,'黄浦区',310100,1,'2018-05-14 16:44:04'),(310104,'徐汇区',310100,1,'2018-05-14 16:44:04'),(310105,'长宁区',310100,1,'2018-05-14 16:44:04'),(310106,'静安区',310100,1,'2018-05-14 16:44:04'),(310107,'普陀区',310100,1,'2018-05-14 16:44:04'),(310109,'虹口区',310100,1,'2018-05-14 16:44:04'),(310110,'杨浦区',310100,1,'2018-05-14 16:44:04'),(310112,'闵行区',310100,1,'2018-05-14 16:44:04'),(310113,'宝山区',310100,1,'2018-05-14 16:44:04'),(310114,'嘉定区',310100,1,'2018-05-14 16:44:04'),(310115,'浦东新区',310100,1,'2018-05-14 16:44:04'),(310116,'金山区',310100,1,'2018-05-14 16:44:04'),(310117,'松江区',310100,1,'2018-05-14 16:44:04'),(310118,'青浦区',310100,1,'2018-05-14 16:44:04'),(310120,'奉贤区',310100,1,'2018-05-14 16:44:04'),(310151,'崇明区',310100,1,'2018-05-14 16:44:04'),(320101,'市辖区',320100,1,'2018-05-14 16:44:04'),(320102,'玄武区',320100,1,'2018-05-14 16:44:04'),(320104,'秦淮区',320100,1,'2018-05-14 16:44:04'),(320105,'建邺区',320100,1,'2018-05-14 16:44:04'),(320106,'鼓楼区',320100,1,'2018-05-14 16:44:04'),(320111,'浦口区',320100,1,'2018-05-14 16:44:04'),(320113,'栖霞区',320100,1,'2018-05-14 16:44:04'),(320114,'雨花台区',320100,1,'2018-05-14 16:44:04'),(320115,'江宁区',320100,1,'2018-05-14 16:44:04'),(320116,'六合区',320100,1,'2018-05-14 16:44:04'),(320117,'溧水区',320100,1,'2018-05-14 16:44:04'),(320118,'高淳区',320100,1,'2018-05-14 16:44:04'),(320201,'市辖区',320200,1,'2018-05-14 16:44:04'),(320205,'锡山区',320200,1,'2018-05-14 16:44:04'),(320206,'惠山区',320200,1,'2018-05-14 16:44:04'),(320211,'滨湖区',320200,1,'2018-05-14 16:44:04'),(320213,'梁溪区',320200,1,'2018-05-14 16:44:04'),(320214,'新吴区',320200,1,'2018-05-14 16:44:04'),(320281,'江阴市',320200,1,'2018-05-14 16:44:04'),(320282,'宜兴市',320200,1,'2018-05-14 16:44:04'),(320301,'市辖区',320300,1,'2018-05-14 16:44:04'),(320302,'鼓楼区',320300,1,'2018-05-14 16:44:04'),(320303,'云龙区',320300,1,'2018-05-14 16:44:04'),(320305,'贾汪区',320300,1,'2018-05-14 16:44:04'),(320311,'泉山区',320300,1,'2018-05-14 16:44:04'),(320312,'铜山区',320300,1,'2018-05-14 16:44:04'),(320321,'丰县',320300,1,'2018-05-14 16:44:04'),(320322,'沛县',320300,1,'2018-05-14 16:44:04'),(320324,'睢宁县',320300,1,'2018-05-14 16:44:04'),(320381,'新沂市',320300,1,'2018-05-14 16:44:04'),(320382,'邳州市',320300,1,'2018-05-14 16:44:04'),(320401,'市辖区',320400,1,'2018-05-14 16:44:04'),(320402,'天宁区',320400,1,'2018-05-14 16:44:04'),(320404,'钟楼区',320400,1,'2018-05-14 16:44:04'),(320411,'新北区',320400,1,'2018-05-14 16:44:04'),(320412,'武进区',320400,1,'2018-05-14 16:44:04'),(320413,'金坛区',320400,1,'2018-05-14 16:44:05'),(320481,'溧阳市',320400,1,'2018-05-14 16:44:05'),(320501,'市辖区',320500,1,'2018-05-14 16:44:05'),(320505,'虎丘区',320500,1,'2018-05-14 16:44:05'),(320506,'吴中区',320500,1,'2018-05-14 16:44:05'),(320507,'相城区',320500,1,'2018-05-14 16:44:05'),(320508,'姑苏区',320500,1,'2018-05-14 16:44:05'),(320509,'吴江区',320500,1,'2018-05-14 16:44:05'),(320581,'常熟市',320500,1,'2018-05-14 16:44:05'),(320582,'张家港市',320500,1,'2018-05-14 16:44:05'),(320583,'昆山市',320500,1,'2018-05-14 16:44:05'),(320585,'太仓市',320500,1,'2018-05-14 16:44:05'),(320601,'市辖区',320600,1,'2018-05-14 16:44:05'),(320602,'崇川区',320600,1,'2018-05-14 16:44:05'),(320611,'港闸区',320600,1,'2018-05-14 16:44:05'),(320612,'通州区',320600,1,'2018-05-14 16:44:05'),(320621,'海安县',320600,1,'2018-05-14 16:44:05'),(320623,'如东县',320600,1,'2018-05-14 16:44:05'),(320681,'启东市',320600,1,'2018-05-14 16:44:05'),(320682,'如皋市',320600,1,'2018-05-14 16:44:05'),(320684,'海门市',320600,1,'2018-05-14 16:44:05'),(320701,'市辖区',320700,1,'2018-05-14 16:44:05'),(320703,'连云区',320700,1,'2018-05-14 16:44:05'),(320706,'海州区',320700,1,'2018-05-14 16:44:05'),(320707,'赣榆区',320700,1,'2018-05-14 16:44:05'),(320722,'东海县',320700,1,'2018-05-14 16:44:05'),(320723,'灌云县',320700,1,'2018-05-14 16:44:05'),(320724,'灌南县',320700,1,'2018-05-14 16:44:05'),(320801,'市辖区',320800,1,'2018-05-14 16:44:05'),(320803,'淮安区',320800,1,'2018-05-14 16:44:05'),(320804,'淮阴区',320800,1,'2018-05-14 16:44:05'),(320812,'清江浦区',320800,1,'2018-05-14 16:44:05'),(320813,'洪泽区',320800,1,'2018-05-14 16:44:05'),(320826,'涟水县',320800,1,'2018-05-14 16:44:05'),(320830,'盱眙县',320800,1,'2018-05-14 16:44:05'),(320831,'金湖县',320800,1,'2018-05-14 16:44:05'),(320901,'市辖区',320900,1,'2018-05-14 16:44:05'),(320902,'亭湖区',320900,1,'2018-05-14 16:44:05'),(320903,'盐都区',320900,1,'2018-05-14 16:44:05'),(320904,'大丰区',320900,1,'2018-05-14 16:44:05'),(320921,'响水县',320900,1,'2018-05-14 16:44:05'),(320922,'滨海县',320900,1,'2018-05-14 16:44:05'),(320923,'阜宁县',320900,1,'2018-05-14 16:44:05'),(320924,'射阳县',320900,1,'2018-05-14 16:44:05'),(320925,'建湖县',320900,1,'2018-05-14 16:44:05'),(320981,'东台市',320900,1,'2018-05-14 16:44:05'),(321001,'市辖区',321000,1,'2018-05-14 16:44:05'),(321002,'广陵区',321000,1,'2018-05-14 16:44:05'),(321003,'邗江区',321000,1,'2018-05-14 16:44:05'),(321012,'江都区',321000,1,'2018-05-14 16:44:05'),(321023,'宝应县',321000,1,'2018-05-14 16:44:05'),(321081,'仪征市',321000,1,'2018-05-14 16:44:05'),(321084,'高邮市',321000,1,'2018-05-14 16:44:05'),(321101,'市辖区',321100,1,'2018-05-14 16:44:05'),(321102,'京口区',321100,1,'2018-05-14 16:44:05'),(321111,'润州区',321100,1,'2018-05-14 16:44:05'),(321112,'丹徒区',321100,1,'2018-05-14 16:44:05'),(321181,'丹阳市',321100,1,'2018-05-14 16:44:05'),(321182,'扬中市',321100,1,'2018-05-14 16:44:05'),(321183,'句容市',321100,1,'2018-05-14 16:44:05'),(321201,'市辖区',321200,1,'2018-05-14 16:44:05'),(321202,'海陵区',321200,1,'2018-05-14 16:44:05'),(321203,'高港区',321200,1,'2018-05-14 16:44:05'),(321204,'姜堰区',321200,1,'2018-05-14 16:44:06'),(321281,'兴化市',321200,1,'2018-05-14 16:44:06'),(321282,'靖江市',321200,1,'2018-05-14 16:44:06'),(321283,'泰兴市',321200,1,'2018-05-14 16:44:06'),(321301,'市辖区',321300,1,'2018-05-14 16:44:06'),(321302,'宿城区',321300,1,'2018-05-14 16:44:06'),(321311,'宿豫区',321300,1,'2018-05-14 16:44:06'),(321322,'沭阳县',321300,1,'2018-05-14 16:44:06'),(321323,'泗阳县',321300,1,'2018-05-14 16:44:06'),(321324,'泗洪县',321300,1,'2018-05-14 16:44:06'),(330101,'市辖区',330100,1,'2018-05-14 16:44:06'),(330102,'上城区',330100,1,'2018-05-14 16:44:06'),(330103,'下城区',330100,1,'2018-05-14 16:44:06'),(330104,'江干区',330100,1,'2018-05-14 16:44:06'),(330105,'拱墅区',330100,1,'2018-05-14 16:44:06'),(330106,'西湖区',330100,1,'2018-05-14 16:44:06'),(330108,'滨江区',330100,1,'2018-05-14 16:44:06'),(330109,'萧山区',330100,1,'2018-05-14 16:44:06'),(330110,'余杭区',330100,1,'2018-05-14 16:44:06'),(330111,'富阳区',330100,1,'2018-05-14 16:44:06'),(330122,'桐庐县',330100,1,'2018-05-14 16:44:06'),(330127,'淳安县',330100,1,'2018-05-14 16:44:06'),(330182,'建德市',330100,1,'2018-05-14 16:44:06'),(330185,'临安市',330100,1,'2018-05-14 16:44:06'),(330201,'市辖区',330200,1,'2018-05-14 16:44:06'),(330203,'海曙区',330200,1,'2018-05-14 16:44:06'),(330204,'江东区',330200,1,'2018-05-14 16:44:06'),(330205,'江北区',330200,1,'2018-05-14 16:44:06'),(330206,'北仑区',330200,1,'2018-05-14 16:44:06'),(330211,'镇海区',330200,1,'2018-05-14 16:44:06'),(330212,'鄞州区',330200,1,'2018-05-14 16:44:06'),(330225,'象山县',330200,1,'2018-05-14 16:44:06'),(330226,'宁海县',330200,1,'2018-05-14 16:44:06'),(330281,'余姚市',330200,1,'2018-05-14 16:44:06'),(330282,'慈溪市',330200,1,'2018-05-14 16:44:06'),(330283,'奉化市',330200,1,'2018-05-14 16:44:06'),(330301,'市辖区',330300,1,'2018-05-14 16:44:06'),(330302,'鹿城区',330300,1,'2018-05-14 16:44:06'),(330303,'龙湾区',330300,1,'2018-05-14 16:44:06'),(330304,'瓯海区',330300,1,'2018-05-14 16:44:06'),(330305,'洞头区',330300,1,'2018-05-14 16:44:06'),(330324,'永嘉县',330300,1,'2018-05-14 16:44:06'),(330326,'平阳县',330300,1,'2018-05-14 16:44:06'),(330327,'苍南县',330300,1,'2018-05-14 16:44:06'),(330328,'文成县',330300,1,'2018-05-14 16:44:06'),(330329,'泰顺县',330300,1,'2018-05-14 16:44:06'),(330381,'瑞安市',330300,1,'2018-05-14 16:44:06'),(330382,'乐清市',330300,1,'2018-05-14 16:44:06'),(330401,'市辖区',330400,1,'2018-05-14 16:44:06'),(330402,'南湖区',330400,1,'2018-05-14 16:44:06'),(330411,'秀洲区',330400,1,'2018-05-14 16:44:06'),(330421,'嘉善县',330400,1,'2018-05-14 16:44:06'),(330424,'海盐县',330400,1,'2018-05-14 16:44:06'),(330481,'海宁市',330400,1,'2018-05-14 16:44:06'),(330482,'平湖市',330400,1,'2018-05-14 16:44:06'),(330483,'桐乡市',330400,1,'2018-05-14 16:44:06'),(330501,'市辖区',330500,1,'2018-05-14 16:44:06'),(330502,'吴兴区',330500,1,'2018-05-14 16:44:06'),(330503,'南浔区',330500,1,'2018-05-14 16:44:06'),(330521,'德清县',330500,1,'2018-05-14 16:44:07'),(330522,'长兴县',330500,1,'2018-05-14 16:44:07'),(330523,'安吉县',330500,1,'2018-05-14 16:44:07'),(330601,'市辖区',330600,1,'2018-05-14 16:44:07'),(330602,'越城区',330600,1,'2018-05-14 16:44:07'),(330603,'柯桥区',330600,1,'2018-05-14 16:44:07'),(330604,'上虞区',330600,1,'2018-05-14 16:44:07'),(330624,'新昌县',330600,1,'2018-05-14 16:44:07'),(330681,'诸暨市',330600,1,'2018-05-14 16:44:07'),(330683,'嵊州市',330600,1,'2018-05-14 16:44:07'),(330701,'市辖区',330700,1,'2018-05-14 16:44:07'),(330702,'婺城区',330700,1,'2018-05-14 16:44:07'),(330703,'金东区',330700,1,'2018-05-14 16:44:07'),(330723,'武义县',330700,1,'2018-05-14 16:44:07'),(330726,'浦江县',330700,1,'2018-05-14 16:44:07'),(330727,'磐安县',330700,1,'2018-05-14 16:44:07'),(330781,'兰溪市',330700,1,'2018-05-14 16:44:07'),(330782,'义乌市',330700,1,'2018-05-14 16:44:07'),(330783,'东阳市',330700,1,'2018-05-14 16:44:07'),(330784,'永康市',330700,1,'2018-05-14 16:44:07'),(330801,'市辖区',330800,1,'2018-05-14 16:44:07'),(330802,'柯城区',330800,1,'2018-05-14 16:44:07'),(330803,'衢江区',330800,1,'2018-05-14 16:44:07'),(330822,'常山县',330800,1,'2018-05-14 16:44:07'),(330824,'开化县',330800,1,'2018-05-14 16:44:07'),(330825,'龙游县',330800,1,'2018-05-14 16:44:07'),(330881,'江山市',330800,1,'2018-05-14 16:44:07'),(330901,'市辖区',330900,1,'2018-05-14 16:44:07'),(330902,'定海区',330900,1,'2018-05-14 16:44:07'),(330903,'普陀区',330900,1,'2018-05-14 16:44:07'),(330921,'岱山县',330900,1,'2018-05-14 16:44:07'),(330922,'嵊泗县',330900,1,'2018-05-14 16:44:07'),(331001,'市辖区',331000,1,'2018-05-14 16:44:07'),(331002,'椒江区',331000,1,'2018-05-14 16:44:07'),(331003,'黄岩区',331000,1,'2018-05-14 16:44:07'),(331004,'路桥区',331000,1,'2018-05-14 16:44:07'),(331021,'玉环县',331000,1,'2018-05-14 16:44:07'),(331022,'三门县',331000,1,'2018-05-14 16:44:07'),(331023,'天台县',331000,1,'2018-05-14 16:44:07'),(331024,'仙居县',331000,1,'2018-05-14 16:44:07'),(331081,'温岭市',331000,1,'2018-05-14 16:44:07'),(331082,'临海市',331000,1,'2018-05-14 16:44:07'),(331101,'市辖区',331100,1,'2018-05-14 16:44:07'),(331102,'莲都区',331100,1,'2018-05-14 16:44:07'),(331121,'青田县',331100,1,'2018-05-14 16:44:07'),(331122,'缙云县',331100,1,'2018-05-14 16:44:07'),(331123,'遂昌县',331100,1,'2018-05-14 16:44:07'),(331124,'松阳县',331100,1,'2018-05-14 16:44:07'),(331125,'云和县',331100,1,'2018-05-14 16:44:07'),(331126,'庆元县',331100,1,'2018-05-14 16:44:07'),(331127,'景宁畲族自治县',331100,1,'2018-05-14 16:44:07'),(331181,'龙泉市',331100,1,'2018-05-14 16:44:07'),(340101,'市辖区',340100,1,'2018-05-14 16:44:07'),(340102,'瑶海区',340100,1,'2018-05-14 16:44:07'),(340103,'庐阳区',340100,1,'2018-05-14 16:44:07'),(340104,'蜀山区',340100,1,'2018-05-14 16:44:07'),(340111,'包河区',340100,1,'2018-05-14 16:44:07'),(340121,'长丰县',340100,1,'2018-05-14 16:44:07'),(340122,'肥东县',340100,1,'2018-05-14 16:44:07'),(340123,'肥西县',340100,1,'2018-05-14 16:44:07'),(340124,'庐江县',340100,1,'2018-05-14 16:44:07'),(340181,'巢湖市',340100,1,'2018-05-14 16:44:08'),(340201,'市辖区',340200,1,'2018-05-14 16:44:08'),(340202,'镜湖区',340200,1,'2018-05-14 16:44:08'),(340203,'弋江区',340200,1,'2018-05-14 16:44:08'),(340207,'鸠江区',340200,1,'2018-05-14 16:44:08'),(340208,'三山区',340200,1,'2018-05-14 16:44:08'),(340221,'芜湖县',340200,1,'2018-05-14 16:44:08'),(340222,'繁昌县',340200,1,'2018-05-14 16:44:08'),(340223,'南陵县',340200,1,'2018-05-14 16:44:08'),(340225,'无为县',340200,1,'2018-05-14 16:44:08'),(340301,'市辖区',340300,1,'2018-05-14 16:44:08'),(340302,'龙子湖区',340300,1,'2018-05-14 16:44:08'),(340303,'蚌山区',340300,1,'2018-05-14 16:44:08'),(340304,'禹会区',340300,1,'2018-05-14 16:44:08'),(340311,'淮上区',340300,1,'2018-05-14 16:44:08'),(340321,'怀远县',340300,1,'2018-05-14 16:44:08'),(340322,'五河县',340300,1,'2018-05-14 16:44:08'),(340323,'固镇县',340300,1,'2018-05-14 16:44:08'),(340401,'市辖区',340400,1,'2018-05-14 16:44:08'),(340402,'大通区',340400,1,'2018-05-14 16:44:08'),(340403,'田家庵区',340400,1,'2018-05-14 16:44:08'),(340404,'谢家集区',340400,1,'2018-05-14 16:44:08'),(340405,'八公山区',340400,1,'2018-05-14 16:44:08'),(340406,'潘集区',340400,1,'2018-05-14 16:44:08'),(340421,'凤台县',340400,1,'2018-05-14 16:44:08'),(340422,'寿县',340400,1,'2018-05-14 16:44:08'),(340501,'市辖区',340500,1,'2018-05-14 16:44:08'),(340503,'花山区',340500,1,'2018-05-14 16:44:08'),(340504,'雨山区',340500,1,'2018-05-14 16:44:08'),(340506,'博望区',340500,1,'2018-05-14 16:44:08'),(340521,'当涂县',340500,1,'2018-05-14 16:44:08'),(340522,'含山县',340500,1,'2018-05-14 16:44:08'),(340523,'和县',340500,1,'2018-05-14 16:44:08'),(340601,'市辖区',340600,1,'2018-05-14 16:44:08'),(340602,'杜集区',340600,1,'2018-05-14 16:44:08'),(340603,'相山区',340600,1,'2018-05-14 16:44:08'),(340604,'烈山区',340600,1,'2018-05-14 16:44:08'),(340621,'濉溪县',340600,1,'2018-05-14 16:44:08'),(340701,'市辖区',340700,1,'2018-05-14 16:44:08'),(340705,'铜官区',340700,1,'2018-05-14 16:44:08'),(340706,'义安区',340700,1,'2018-05-14 16:44:08'),(340711,'郊区',340700,1,'2018-05-14 16:44:08'),(340722,'枞阳县',340700,1,'2018-05-14 16:44:08'),(340801,'市辖区',340800,1,'2018-05-14 16:44:08'),(340802,'迎江区',340800,1,'2018-05-14 16:44:08'),(340803,'大观区',340800,1,'2018-05-14 16:44:08'),(340811,'宜秀区',340800,1,'2018-05-14 16:44:08'),(340822,'怀宁县',340800,1,'2018-05-14 16:44:08'),(340824,'潜山县',340800,1,'2018-05-14 16:44:08'),(340825,'太湖县',340800,1,'2018-05-14 16:44:08'),(340826,'宿松县',340800,1,'2018-05-14 16:44:08'),(340827,'望江县',340800,1,'2018-05-14 16:44:08'),(340828,'岳西县',340800,1,'2018-05-14 16:44:08'),(340881,'桐城市',340800,1,'2018-05-14 16:44:08'),(341001,'市辖区',341000,1,'2018-05-14 16:44:08'),(341002,'屯溪区',341000,1,'2018-05-14 16:44:08'),(341003,'黄山区',341000,1,'2018-05-14 16:44:08'),(341004,'徽州区',341000,1,'2018-05-14 16:44:08'),(341021,'歙县',341000,1,'2018-05-14 16:44:08'),(341022,'休宁县',341000,1,'2018-05-14 16:44:08'),(341023,'黟县',341000,1,'2018-05-14 16:44:08'),(341024,'祁门县',341000,1,'2018-05-14 16:44:08'),(341101,'市辖区',341100,1,'2018-05-14 16:44:09'),(341102,'琅琊区',341100,1,'2018-05-14 16:44:09'),(341103,'南谯区',341100,1,'2018-05-14 16:44:09'),(341122,'来安县',341100,1,'2018-05-14 16:44:09'),(341124,'全椒县',341100,1,'2018-05-14 16:44:09'),(341125,'定远县',341100,1,'2018-05-14 16:44:09'),(341126,'凤阳县',341100,1,'2018-05-14 16:44:09'),(341181,'天长市',341100,1,'2018-05-14 16:44:09'),(341182,'明光市',341100,1,'2018-05-14 16:44:09'),(341201,'市辖区',341200,1,'2018-05-14 16:44:09'),(341202,'颍州区',341200,1,'2018-05-14 16:44:09'),(341203,'颍东区',341200,1,'2018-05-14 16:44:09'),(341204,'颍泉区',341200,1,'2018-05-14 16:44:09'),(341221,'临泉县',341200,1,'2018-05-14 16:44:09'),(341222,'太和县',341200,1,'2018-05-14 16:44:09'),(341225,'阜南县',341200,1,'2018-05-14 16:44:09'),(341226,'颍上县',341200,1,'2018-05-14 16:44:09'),(341282,'界首市',341200,1,'2018-05-14 16:44:09'),(341301,'市辖区',341300,1,'2018-05-14 16:44:09'),(341302,'埇桥区',341300,1,'2018-05-14 16:44:09'),(341321,'砀山县',341300,1,'2018-05-14 16:44:09'),(341322,'萧县',341300,1,'2018-05-14 16:44:09'),(341323,'灵璧县',341300,1,'2018-05-14 16:44:09'),(341324,'泗县',341300,1,'2018-05-14 16:44:09'),(341501,'市辖区',341500,1,'2018-05-14 16:44:09'),(341502,'金安区',341500,1,'2018-05-14 16:44:09'),(341503,'裕安区',341500,1,'2018-05-14 16:44:09'),(341504,'叶集区',341500,1,'2018-05-14 16:44:09'),(341522,'霍邱县',341500,1,'2018-05-14 16:44:09'),(341523,'舒城县',341500,1,'2018-05-14 16:44:09'),(341524,'金寨县',341500,1,'2018-05-14 16:44:09'),(341525,'霍山县',341500,1,'2018-05-14 16:44:09'),(341601,'市辖区',341600,1,'2018-05-14 16:44:09'),(341602,'谯城区',341600,1,'2018-05-14 16:44:09'),(341621,'涡阳县',341600,1,'2018-05-14 16:44:09'),(341622,'蒙城县',341600,1,'2018-05-14 16:44:09'),(341623,'利辛县',341600,1,'2018-05-14 16:44:09'),(341701,'市辖区',341700,1,'2018-05-14 16:44:09'),(341702,'贵池区',341700,1,'2018-05-14 16:44:09'),(341721,'东至县',341700,1,'2018-05-14 16:44:09'),(341722,'石台县',341700,1,'2018-05-14 16:44:09'),(341723,'青阳县',341700,1,'2018-05-14 16:44:09'),(341801,'市辖区',341800,1,'2018-05-14 16:44:09'),(341802,'宣州区',341800,1,'2018-05-14 16:44:09'),(341821,'郎溪县',341800,1,'2018-05-14 16:44:09'),(341822,'广德县',341800,1,'2018-05-14 16:44:09'),(341823,'泾县',341800,1,'2018-05-14 16:44:09'),(341824,'绩溪县',341800,1,'2018-05-14 16:44:09'),(341825,'旌德县',341800,1,'2018-05-14 16:44:09'),(341881,'宁国市',341800,1,'2018-05-14 16:44:09'),(350101,'市辖区',350100,1,'2018-05-14 16:44:09'),(350102,'鼓楼区',350100,1,'2018-05-14 16:44:09'),(350103,'台江区',350100,1,'2018-05-14 16:44:09'),(350104,'仓山区',350100,1,'2018-05-14 16:44:09'),(350105,'马尾区',350100,1,'2018-05-14 16:44:09'),(350111,'晋安区',350100,1,'2018-05-14 16:44:09'),(350121,'闽侯县',350100,1,'2018-05-14 16:44:09'),(350122,'连江县',350100,1,'2018-05-14 16:44:09'),(350123,'罗源县',350100,1,'2018-05-14 16:44:09'),(350124,'闽清县',350100,1,'2018-05-14 16:44:09'),(350125,'永泰县',350100,1,'2018-05-14 16:44:09'),(350128,'平潭县',350100,1,'2018-05-14 16:44:10'),(350181,'福清市',350100,1,'2018-05-14 16:44:10'),(350182,'长乐市',350100,1,'2018-05-14 16:44:10'),(350201,'市辖区',350200,1,'2018-05-14 16:44:10'),(350203,'思明区',350200,1,'2018-05-14 16:44:10'),(350205,'海沧区',350200,1,'2018-05-14 16:44:10'),(350206,'湖里区',350200,1,'2018-05-14 16:44:10'),(350211,'集美区',350200,1,'2018-05-14 16:44:10'),(350212,'同安区',350200,1,'2018-05-14 16:44:10'),(350213,'翔安区',350200,1,'2018-05-14 16:44:10'),(350301,'市辖区',350300,1,'2018-05-14 16:44:10'),(350302,'城厢区',350300,1,'2018-05-14 16:44:10'),(350303,'涵江区',350300,1,'2018-05-14 16:44:10'),(350304,'荔城区',350300,1,'2018-05-14 16:44:10'),(350305,'秀屿区',350300,1,'2018-05-14 16:44:10'),(350322,'仙游县',350300,1,'2018-05-14 16:44:10'),(350401,'市辖区',350400,1,'2018-05-14 16:44:10'),(350402,'梅列区',350400,1,'2018-05-14 16:44:10'),(350403,'三元区',350400,1,'2018-05-14 16:44:10'),(350421,'明溪县',350400,1,'2018-05-14 16:44:10'),(350423,'清流县',350400,1,'2018-05-14 16:44:10'),(350424,'宁化县',350400,1,'2018-05-14 16:44:10'),(350425,'大田县',350400,1,'2018-05-14 16:44:10'),(350426,'尤溪县',350400,1,'2018-05-14 16:44:10'),(350427,'沙县',350400,1,'2018-05-14 16:44:10'),(350428,'将乐县',350400,1,'2018-05-14 16:44:10'),(350429,'泰宁县',350400,1,'2018-05-14 16:44:10'),(350430,'建宁县',350400,1,'2018-05-14 16:44:10'),(350481,'永安市',350400,1,'2018-05-14 16:44:10'),(350501,'市辖区',350500,1,'2018-05-14 16:44:10'),(350502,'鲤城区',350500,1,'2018-05-14 16:44:10'),(350503,'丰泽区',350500,1,'2018-05-14 16:44:10'),(350504,'洛江区',350500,1,'2018-05-14 16:44:10'),(350505,'泉港区',350500,1,'2018-05-14 16:44:10'),(350521,'惠安县',350500,1,'2018-05-14 16:44:10'),(350524,'安溪县',350500,1,'2018-05-14 16:44:10'),(350525,'永春县',350500,1,'2018-05-14 16:44:10'),(350526,'德化县',350500,1,'2018-05-14 16:44:10'),(350527,'金门县',350500,1,'2018-05-14 16:44:10'),(350581,'石狮市',350500,1,'2018-05-14 16:44:10'),(350582,'晋江市',350500,1,'2018-05-14 16:44:10'),(350583,'南安市',350500,1,'2018-05-14 16:44:10'),(350601,'市辖区',350600,1,'2018-05-14 16:44:10'),(350602,'芗城区',350600,1,'2018-05-14 16:44:10'),(350603,'龙文区',350600,1,'2018-05-14 16:44:10'),(350622,'云霄县',350600,1,'2018-05-14 16:44:10'),(350623,'漳浦县',350600,1,'2018-05-14 16:44:10'),(350624,'诏安县',350600,1,'2018-05-14 16:44:10'),(350625,'长泰县',350600,1,'2018-05-14 16:44:10'),(350626,'东山县',350600,1,'2018-05-14 16:44:10'),(350627,'南靖县',350600,1,'2018-05-14 16:44:10'),(350628,'平和县',350600,1,'2018-05-14 16:44:10'),(350629,'华安县',350600,1,'2018-05-14 16:44:10'),(350681,'龙海市',350600,1,'2018-05-14 16:44:10'),(350701,'市辖区',350700,1,'2018-05-14 16:44:10'),(350702,'延平区',350700,1,'2018-05-14 16:44:10'),(350703,'建阳区',350700,1,'2018-05-14 16:44:10'),(350721,'顺昌县',350700,1,'2018-05-14 16:44:11'),(350722,'浦城县',350700,1,'2018-05-14 16:44:11'),(350723,'光泽县',350700,1,'2018-05-14 16:44:11'),(350724,'松溪县',350700,1,'2018-05-14 16:44:11'),(350725,'政和县',350700,1,'2018-05-14 16:44:11'),(350781,'邵武市',350700,1,'2018-05-14 16:44:11'),(350782,'武夷山市',350700,1,'2018-05-14 16:44:11'),(350783,'建瓯市',350700,1,'2018-05-14 16:44:11'),(350801,'市辖区',350800,1,'2018-05-14 16:44:11'),(350802,'新罗区',350800,1,'2018-05-14 16:44:11'),(350803,'永定区',350800,1,'2018-05-14 16:44:11'),(350821,'长汀县',350800,1,'2018-05-14 16:44:11'),(350823,'上杭县',350800,1,'2018-05-14 16:44:11'),(350824,'武平县',350800,1,'2018-05-14 16:44:11'),(350825,'连城县',350800,1,'2018-05-14 16:44:11'),(350881,'漳平市',350800,1,'2018-05-14 16:44:11'),(350901,'市辖区',350900,1,'2018-05-14 16:44:11'),(350902,'蕉城区',350900,1,'2018-05-14 16:44:11'),(350921,'霞浦县',350900,1,'2018-05-14 16:44:11'),(350922,'古田县',350900,1,'2018-05-14 16:44:11'),(350923,'屏南县',350900,1,'2018-05-14 16:44:11'),(350924,'寿宁县',350900,1,'2018-05-14 16:44:11'),(350925,'周宁县',350900,1,'2018-05-14 16:44:11'),(350926,'柘荣县',350900,1,'2018-05-14 16:44:11'),(350981,'福安市',350900,1,'2018-05-14 16:44:11'),(350982,'福鼎市',350900,1,'2018-05-14 16:44:11'),(360101,'市辖区',360100,1,'2018-05-14 16:44:11'),(360102,'东湖区',360100,1,'2018-05-14 16:44:11'),(360103,'西湖区',360100,1,'2018-05-14 16:44:11'),(360104,'青云谱区',360100,1,'2018-05-14 16:44:11'),(360105,'湾里区',360100,1,'2018-05-14 16:44:11'),(360111,'青山湖区',360100,1,'2018-05-14 16:44:11'),(360112,'新建区',360100,1,'2018-05-14 16:44:11'),(360121,'南昌县',360100,1,'2018-05-14 16:44:11'),(360123,'安义县',360100,1,'2018-05-14 16:44:11'),(360124,'进贤县',360100,1,'2018-05-14 16:44:11'),(360201,'市辖区',360200,1,'2018-05-14 16:44:11'),(360202,'昌江区',360200,1,'2018-05-14 16:44:11'),(360203,'珠山区',360200,1,'2018-05-14 16:44:11'),(360222,'浮梁县',360200,1,'2018-05-14 16:44:11'),(360281,'乐平市',360200,1,'2018-05-14 16:44:11'),(360301,'市辖区',360300,1,'2018-05-14 16:44:11'),(360302,'安源区',360300,1,'2018-05-14 16:44:11'),(360313,'湘东区',360300,1,'2018-05-14 16:44:11'),(360321,'莲花县',360300,1,'2018-05-14 16:44:11'),(360322,'上栗县',360300,1,'2018-05-14 16:44:11'),(360323,'芦溪县',360300,1,'2018-05-14 16:44:11'),(360401,'市辖区',360400,1,'2018-05-14 16:44:11'),(360402,'濂溪区',360400,1,'2018-05-14 16:44:11'),(360403,'浔阳区',360400,1,'2018-05-14 16:44:11'),(360421,'九江县',360400,1,'2018-05-14 16:44:11'),(360423,'武宁县',360400,1,'2018-05-14 16:44:11'),(360424,'修水县',360400,1,'2018-05-14 16:44:12'),(360425,'永修县',360400,1,'2018-05-14 16:44:12'),(360426,'德安县',360400,1,'2018-05-14 16:44:12'),(360428,'都昌县',360400,1,'2018-05-14 16:44:12'),(360429,'湖口县',360400,1,'2018-05-14 16:44:12'),(360430,'彭泽县',360400,1,'2018-05-14 16:44:12'),(360481,'瑞昌市',360400,1,'2018-05-14 16:44:12'),(360482,'共青城市',360400,1,'2018-05-14 16:44:12'),(360483,'庐山市',360400,1,'2018-05-14 16:44:12'),(360501,'市辖区',360500,1,'2018-05-14 16:44:12'),(360502,'渝水区',360500,1,'2018-05-14 16:44:12'),(360521,'分宜县',360500,1,'2018-05-14 16:44:12'),(360601,'市辖区',360600,1,'2018-05-14 16:44:12'),(360602,'月湖区',360600,1,'2018-05-14 16:44:12'),(360622,'余江县',360600,1,'2018-05-14 16:44:12'),(360681,'贵溪市',360600,1,'2018-05-14 16:44:12'),(360701,'市辖区',360700,1,'2018-05-14 16:44:12'),(360702,'章贡区',360700,1,'2018-05-14 16:44:12'),(360703,'南康区',360700,1,'2018-05-14 16:44:12'),(360721,'赣县',360700,1,'2018-05-14 16:44:12'),(360722,'信丰县',360700,1,'2018-05-14 16:44:12'),(360723,'大余县',360700,1,'2018-05-14 16:44:12'),(360724,'上犹县',360700,1,'2018-05-14 16:44:12'),(360725,'崇义县',360700,1,'2018-05-14 16:44:12'),(360726,'安远县',360700,1,'2018-05-14 16:44:12'),(360727,'龙南县',360700,1,'2018-05-14 16:44:12'),(360728,'定南县',360700,1,'2018-05-14 16:44:12'),(360729,'全南县',360700,1,'2018-05-14 16:44:12'),(360730,'宁都县',360700,1,'2018-05-14 16:44:12'),(360731,'于都县',360700,1,'2018-05-14 16:44:12'),(360732,'兴国县',360700,1,'2018-05-14 16:44:12'),(360733,'会昌县',360700,1,'2018-05-14 16:44:12'),(360734,'寻乌县',360700,1,'2018-05-14 16:44:12'),(360735,'石城县',360700,1,'2018-05-14 16:44:12'),(360781,'瑞金市',360700,1,'2018-05-14 16:44:12'),(360801,'市辖区',360800,1,'2018-05-14 16:44:12'),(360802,'吉州区',360800,1,'2018-05-14 16:44:12'),(360803,'青原区',360800,1,'2018-05-14 16:44:12'),(360821,'吉安县',360800,1,'2018-05-14 16:44:12'),(360822,'吉水县',360800,1,'2018-05-14 16:44:12'),(360823,'峡江县',360800,1,'2018-05-14 16:44:12'),(360824,'新干县',360800,1,'2018-05-14 16:44:12'),(360825,'永丰县',360800,1,'2018-05-14 16:44:12'),(360826,'泰和县',360800,1,'2018-05-14 16:44:12'),(360827,'遂川县',360800,1,'2018-05-14 16:44:12'),(360828,'万安县',360800,1,'2018-05-14 16:44:12'),(360829,'安福县',360800,1,'2018-05-14 16:44:12'),(360830,'永新县',360800,1,'2018-05-14 16:44:12'),(360881,'井冈山市',360800,1,'2018-05-14 16:44:12'),(360901,'市辖区',360900,1,'2018-05-14 16:44:12'),(360902,'袁州区',360900,1,'2018-05-14 16:44:12'),(360921,'奉新县',360900,1,'2018-05-14 16:44:12'),(360922,'万载县',360900,1,'2018-05-14 16:44:12'),(360923,'上高县',360900,1,'2018-05-14 16:44:12'),(360924,'宜丰县',360900,1,'2018-05-14 16:44:12'),(360925,'靖安县',360900,1,'2018-05-14 16:44:12'),(360926,'铜鼓县',360900,1,'2018-05-14 16:44:12'),(360981,'丰城市',360900,1,'2018-05-14 16:44:12'),(360982,'樟树市',360900,1,'2018-05-14 16:44:12'),(360983,'高安市',360900,1,'2018-05-14 16:44:12'),(361001,'市辖区',361000,1,'2018-05-14 16:44:12'),(361002,'临川区',361000,1,'2018-05-14 16:44:12'),(361021,'南城县',361000,1,'2018-05-14 16:44:13'),(361022,'黎川县',361000,1,'2018-05-14 16:44:13'),(361023,'南丰县',361000,1,'2018-05-14 16:44:13'),(361024,'崇仁县',361000,1,'2018-05-14 16:44:13'),(361025,'乐安县',361000,1,'2018-05-14 16:44:13'),(361026,'宜黄县',361000,1,'2018-05-14 16:44:13'),(361027,'金溪县',361000,1,'2018-05-14 16:44:13'),(361028,'资溪县',361000,1,'2018-05-14 16:44:13'),(361029,'东乡县',361000,1,'2018-05-14 16:44:13'),(361030,'广昌县',361000,1,'2018-05-14 16:44:13'),(361101,'市辖区',361100,1,'2018-05-14 16:44:13'),(361102,'信州区',361100,1,'2018-05-14 16:44:13'),(361103,'广丰区',361100,1,'2018-05-14 16:44:13'),(361121,'上饶县',361100,1,'2018-05-14 16:44:13'),(361123,'玉山县',361100,1,'2018-05-14 16:44:13'),(361124,'铅山县',361100,1,'2018-05-14 16:44:13'),(361125,'横峰县',361100,1,'2018-05-14 16:44:13'),(361126,'弋阳县',361100,1,'2018-05-14 16:44:13'),(361127,'余干县',361100,1,'2018-05-14 16:44:13'),(361128,'鄱阳县',361100,1,'2018-05-14 16:44:13'),(361129,'万年县',361100,1,'2018-05-14 16:44:13'),(361130,'婺源县',361100,1,'2018-05-14 16:44:13'),(361181,'德兴市',361100,1,'2018-05-14 16:44:13'),(370101,'市辖区',370100,1,'2018-05-14 16:44:13'),(370102,'历下区',370100,1,'2018-05-14 16:44:13'),(370103,'市中区',370100,1,'2018-05-14 16:44:13'),(370104,'槐荫区',370100,1,'2018-05-14 16:44:13'),(370105,'天桥区',370100,1,'2018-05-14 16:44:13'),(370112,'历城区',370100,1,'2018-05-14 16:44:13'),(370113,'长清区',370100,1,'2018-05-14 16:44:13'),(370124,'平阴县',370100,1,'2018-05-14 16:44:13'),(370125,'济阳县',370100,1,'2018-05-14 16:44:13'),(370126,'商河县',370100,1,'2018-05-14 16:44:13'),(370181,'章丘市',370100,1,'2018-05-14 16:44:13'),(370201,'市辖区',370200,1,'2018-05-14 16:44:13'),(370202,'市南区',370200,1,'2018-05-14 16:44:13'),(370203,'市北区',370200,1,'2018-05-14 16:44:13'),(370211,'黄岛区',370200,1,'2018-05-14 16:44:13'),(370212,'崂山区',370200,1,'2018-05-14 16:44:13'),(370213,'李沧区',370200,1,'2018-05-14 16:44:13'),(370214,'城阳区',370200,1,'2018-05-14 16:44:13'),(370281,'胶州市',370200,1,'2018-05-14 16:44:13'),(370282,'即墨市',370200,1,'2018-05-14 16:44:13'),(370283,'平度市',370200,1,'2018-05-14 16:44:13'),(370285,'莱西市',370200,1,'2018-05-14 16:44:13'),(370301,'市辖区',370300,1,'2018-05-14 16:44:13'),(370302,'淄川区',370300,1,'2018-05-14 16:44:13'),(370303,'张店区',370300,1,'2018-05-14 16:44:13'),(370304,'博山区',370300,1,'2018-05-14 16:44:13'),(370305,'临淄区',370300,1,'2018-05-14 16:44:13'),(370306,'周村区',370300,1,'2018-05-14 16:44:13'),(370321,'桓台县',370300,1,'2018-05-14 16:44:13'),(370322,'高青县',370300,1,'2018-05-14 16:44:13'),(370323,'沂源县',370300,1,'2018-05-14 16:44:13'),(370401,'市辖区',370400,1,'2018-05-14 16:44:13'),(370402,'市中区',370400,1,'2018-05-14 16:44:13'),(370403,'薛城区',370400,1,'2018-05-14 16:44:13'),(370404,'峄城区',370400,1,'2018-05-14 16:44:13'),(370405,'台儿庄区',370400,1,'2018-05-14 16:44:14'),(370406,'山亭区',370400,1,'2018-05-14 16:44:14'),(370481,'滕州市',370400,1,'2018-05-14 16:44:14'),(370501,'市辖区',370500,1,'2018-05-14 16:44:14'),(370502,'东营区',370500,1,'2018-05-14 16:44:14'),(370503,'河口区',370500,1,'2018-05-14 16:44:14'),(370505,'垦利区',370500,1,'2018-05-14 16:44:14'),(370522,'利津县',370500,1,'2018-05-14 16:44:14'),(370523,'广饶县',370500,1,'2018-05-14 16:44:14'),(370601,'市辖区',370600,1,'2018-05-14 16:44:14'),(370602,'芝罘区',370600,1,'2018-05-14 16:44:14'),(370611,'福山区',370600,1,'2018-05-14 16:44:14'),(370612,'牟平区',370600,1,'2018-05-14 16:44:14'),(370613,'莱山区',370600,1,'2018-05-14 16:44:14'),(370634,'长岛县',370600,1,'2018-05-14 16:44:14'),(370681,'龙口市',370600,1,'2018-05-14 16:44:14'),(370682,'莱阳市',370600,1,'2018-05-14 16:44:14'),(370683,'莱州市',370600,1,'2018-05-14 16:44:14'),(370684,'蓬莱市',370600,1,'2018-05-14 16:44:14'),(370685,'招远市',370600,1,'2018-05-14 16:44:14'),(370686,'栖霞市',370600,1,'2018-05-14 16:44:14'),(370687,'海阳市',370600,1,'2018-05-14 16:44:14'),(370701,'市辖区',370700,1,'2018-05-14 16:44:14'),(370702,'潍城区',370700,1,'2018-05-14 16:44:14'),(370703,'寒亭区',370700,1,'2018-05-14 16:44:14'),(370704,'坊子区',370700,1,'2018-05-14 16:44:14'),(370705,'奎文区',370700,1,'2018-05-14 16:44:14'),(370724,'临朐县',370700,1,'2018-05-14 16:44:14'),(370725,'昌乐县',370700,1,'2018-05-14 16:44:14'),(370781,'青州市',370700,1,'2018-05-14 16:44:14'),(370782,'诸城市',370700,1,'2018-05-14 16:44:14'),(370783,'寿光市',370700,1,'2018-05-14 16:44:14'),(370784,'安丘市',370700,1,'2018-05-14 16:44:14'),(370785,'高密市',370700,1,'2018-05-14 16:44:14'),(370786,'昌邑市',370700,1,'2018-05-14 16:44:14'),(370801,'市辖区',370800,1,'2018-05-14 16:44:14'),(370811,'任城区',370800,1,'2018-05-14 16:44:14'),(370812,'兖州区',370800,1,'2018-05-14 16:44:14'),(370826,'微山县',370800,1,'2018-05-14 16:44:14'),(370827,'鱼台县',370800,1,'2018-05-14 16:44:14'),(370828,'金乡县',370800,1,'2018-05-14 16:44:14'),(370829,'嘉祥县',370800,1,'2018-05-14 16:44:14'),(370830,'汶上县',370800,1,'2018-05-14 16:44:14'),(370831,'泗水县',370800,1,'2018-05-14 16:44:14'),(370832,'梁山县',370800,1,'2018-05-14 16:44:14'),(370881,'曲阜市',370800,1,'2018-05-14 16:44:14'),(370883,'邹城市',370800,1,'2018-05-14 16:44:14'),(370901,'市辖区',370900,1,'2018-05-14 16:44:14'),(370902,'泰山区',370900,1,'2018-05-14 16:44:14'),(370911,'岱岳区',370900,1,'2018-05-14 16:44:14'),(370921,'宁阳县',370900,1,'2018-05-14 16:44:14'),(370923,'东平县',370900,1,'2018-05-14 16:44:14'),(370982,'新泰市',370900,1,'2018-05-14 16:44:14'),(370983,'肥城市',370900,1,'2018-05-14 16:44:14'),(371001,'市辖区',371000,1,'2018-05-14 16:44:14'),(371002,'环翠区',371000,1,'2018-05-14 16:44:14'),(371003,'文登区',371000,1,'2018-05-14 16:44:14'),(371082,'荣成市',371000,1,'2018-05-14 16:44:14'),(371083,'乳山市',371000,1,'2018-05-14 16:44:14'),(371101,'市辖区',371100,1,'2018-05-14 16:44:15'),(371102,'东港区',371100,1,'2018-05-14 16:44:15'),(371103,'岚山区',371100,1,'2018-05-14 16:44:15'),(371121,'五莲县',371100,1,'2018-05-14 16:44:15'),(371122,'莒县',371100,1,'2018-05-14 16:44:15'),(371201,'市辖区',371200,1,'2018-05-14 16:44:15'),(371202,'莱城区',371200,1,'2018-05-14 16:44:15'),(371203,'钢城区',371200,1,'2018-05-14 16:44:15'),(371301,'市辖区',371300,1,'2018-05-14 16:44:15'),(371302,'兰山区',371300,1,'2018-05-14 16:44:15'),(371311,'罗庄区',371300,1,'2018-05-14 16:44:15'),(371312,'河东区',371300,1,'2018-05-14 16:44:15'),(371321,'沂南县',371300,1,'2018-05-14 16:44:15'),(371322,'郯城县',371300,1,'2018-05-14 16:44:15'),(371323,'沂水县',371300,1,'2018-05-14 16:44:15'),(371324,'兰陵县',371300,1,'2018-05-14 16:44:15'),(371325,'费县',371300,1,'2018-05-14 16:44:15'),(371326,'平邑县',371300,1,'2018-05-14 16:44:15'),(371327,'莒南县',371300,1,'2018-05-14 16:44:15'),(371328,'蒙阴县',371300,1,'2018-05-14 16:44:15'),(371329,'临沭县',371300,1,'2018-05-14 16:44:15'),(371401,'市辖区',371400,1,'2018-05-14 16:44:15'),(371402,'德城区',371400,1,'2018-05-14 16:44:15'),(371403,'陵城区',371400,1,'2018-05-14 16:44:15'),(371422,'宁津县',371400,1,'2018-05-14 16:44:15'),(371423,'庆云县',371400,1,'2018-05-14 16:44:15'),(371424,'临邑县',371400,1,'2018-05-14 16:44:15'),(371425,'齐河县',371400,1,'2018-05-14 16:44:15'),(371426,'平原县',371400,1,'2018-05-14 16:44:15'),(371427,'夏津县',371400,1,'2018-05-14 16:44:15'),(371428,'武城县',371400,1,'2018-05-14 16:44:15'),(371481,'乐陵市',371400,1,'2018-05-14 16:44:15'),(371482,'禹城市',371400,1,'2018-05-14 16:44:15'),(371501,'市辖区',371500,1,'2018-05-14 16:44:15'),(371502,'东昌府区',371500,1,'2018-05-14 16:44:15'),(371521,'阳谷县',371500,1,'2018-05-14 16:44:15'),(371522,'莘县',371500,1,'2018-05-14 16:44:15'),(371523,'茌平县',371500,1,'2018-05-14 16:44:15'),(371524,'东阿县',371500,1,'2018-05-14 16:44:15'),(371525,'冠县',371500,1,'2018-05-14 16:44:15'),(371526,'高唐县',371500,1,'2018-05-14 16:44:15'),(371581,'临清市',371500,1,'2018-05-14 16:44:15'),(371601,'市辖区',371600,1,'2018-05-14 16:44:15'),(371602,'滨城区',371600,1,'2018-05-14 16:44:15'),(371603,'沾化区',371600,1,'2018-05-14 16:44:15'),(371621,'惠民县',371600,1,'2018-05-14 16:44:15'),(371622,'阳信县',371600,1,'2018-05-14 16:44:15'),(371623,'无棣县',371600,1,'2018-05-14 16:44:15'),(371625,'博兴县',371600,1,'2018-05-14 16:44:15'),(371626,'邹平县',371600,1,'2018-05-14 16:44:15'),(371701,'市辖区',371700,1,'2018-05-14 16:44:15'),(371702,'牡丹区',371700,1,'2018-05-14 16:44:15'),(371703,'定陶区',371700,1,'2018-05-14 16:44:15'),(371721,'曹县',371700,1,'2018-05-14 16:44:15'),(371722,'单县',371700,1,'2018-05-14 16:44:15'),(371723,'成武县',371700,1,'2018-05-14 16:44:15'),(371724,'巨野县',371700,1,'2018-05-14 16:44:15'),(371725,'郓城县',371700,1,'2018-05-14 16:44:15'),(371726,'鄄城县',371700,1,'2018-05-14 16:44:15'),(371728,'东明县',371700,1,'2018-05-14 16:44:15'),(410101,'市辖区',410100,1,'2018-05-14 16:44:16'),(410102,'中原区',410100,1,'2018-05-14 16:44:16'),(410103,'二七区',410100,1,'2018-05-14 16:44:16'),(410104,'管城回族区',410100,1,'2018-05-14 16:44:16'),(410105,'金水区',410100,1,'2018-05-14 16:44:16'),(410106,'上街区',410100,1,'2018-05-14 16:44:16'),(410108,'惠济区',410100,1,'2018-05-14 16:44:16'),(410122,'中牟县',410100,1,'2018-05-14 16:44:16'),(410181,'巩义市',410100,1,'2018-05-14 16:44:16'),(410182,'荥阳市',410100,1,'2018-05-14 16:44:16'),(410183,'新密市',410100,1,'2018-05-14 16:44:16'),(410184,'新郑市',410100,1,'2018-05-14 16:44:16'),(410185,'登封市',410100,1,'2018-05-14 16:44:16'),(410201,'市辖区',410200,1,'2018-05-14 16:44:16'),(410202,'龙亭区',410200,1,'2018-05-14 16:44:16'),(410203,'顺河回族区',410200,1,'2018-05-14 16:44:16'),(410204,'鼓楼区',410200,1,'2018-05-14 16:44:16'),(410205,'禹王台区',410200,1,'2018-05-14 16:44:16'),(410211,'金明区',410200,1,'2018-05-14 16:44:16'),(410212,'祥符区',410200,1,'2018-05-14 16:44:16'),(410221,'杞县',410200,1,'2018-05-14 16:44:16'),(410222,'通许县',410200,1,'2018-05-14 16:44:16'),(410223,'尉氏县',410200,1,'2018-05-14 16:44:16'),(410225,'兰考县',410200,1,'2018-05-14 16:44:16'),(410301,'市辖区',410300,1,'2018-05-14 16:44:16'),(410302,'老城区',410300,1,'2018-05-14 16:44:16'),(410303,'西工区',410300,1,'2018-05-14 16:44:16'),(410304,'瀍河回族区',410300,1,'2018-05-14 16:44:16'),(410305,'涧西区',410300,1,'2018-05-14 16:44:16'),(410306,'吉利区',410300,1,'2018-05-14 16:44:16'),(410311,'洛龙区',410300,1,'2018-05-14 16:44:16'),(410322,'孟津县',410300,1,'2018-05-14 16:44:16'),(410323,'新安县',410300,1,'2018-05-14 16:44:16'),(410324,'栾川县',410300,1,'2018-05-14 16:44:16'),(410325,'嵩县',410300,1,'2018-05-14 16:44:16'),(410326,'汝阳县',410300,1,'2018-05-14 16:44:16'),(410327,'宜阳县',410300,1,'2018-05-14 16:44:16'),(410328,'洛宁县',410300,1,'2018-05-14 16:44:16'),(410329,'伊川县',410300,1,'2018-05-14 16:44:16'),(410381,'偃师市',410300,1,'2018-05-14 16:44:16'),(410401,'市辖区',410400,1,'2018-05-14 16:44:16'),(410402,'新华区',410400,1,'2018-05-14 16:44:16'),(410403,'卫东区',410400,1,'2018-05-14 16:44:16'),(410404,'石龙区',410400,1,'2018-05-14 16:44:16'),(410411,'湛河区',410400,1,'2018-05-14 16:44:16'),(410421,'宝丰县',410400,1,'2018-05-14 16:44:16'),(410422,'叶县',410400,1,'2018-05-14 16:44:16'),(410423,'鲁山县',410400,1,'2018-05-14 16:44:16'),(410425,'郏县',410400,1,'2018-05-14 16:44:16'),(410481,'舞钢市',410400,1,'2018-05-14 16:44:16'),(410482,'汝州市',410400,1,'2018-05-14 16:44:17'),(410501,'市辖区',410500,1,'2018-05-14 16:44:17'),(410502,'文峰区',410500,1,'2018-05-14 16:44:17'),(410503,'北关区',410500,1,'2018-05-14 16:44:17'),(410505,'殷都区',410500,1,'2018-05-14 16:44:17'),(410506,'龙安区',410500,1,'2018-05-14 16:44:17'),(410522,'安阳县',410500,1,'2018-05-14 16:44:17'),(410523,'汤阴县',410500,1,'2018-05-14 16:44:17'),(410526,'滑县',410500,1,'2018-05-14 16:44:17'),(410527,'内黄县',410500,1,'2018-05-14 16:44:17'),(410581,'林州市',410500,1,'2018-05-14 16:44:17'),(410601,'市辖区',410600,1,'2018-05-14 16:44:17'),(410602,'鹤山区',410600,1,'2018-05-14 16:44:17'),(410603,'山城区',410600,1,'2018-05-14 16:44:17'),(410611,'淇滨区',410600,1,'2018-05-14 16:44:17'),(410621,'浚县',410600,1,'2018-05-14 16:44:17'),(410622,'淇县',410600,1,'2018-05-14 16:44:17'),(410701,'市辖区',410700,1,'2018-05-14 16:44:17'),(410702,'红旗区',410700,1,'2018-05-14 16:44:17'),(410703,'卫滨区',410700,1,'2018-05-14 16:44:17'),(410704,'凤泉区',410700,1,'2018-05-14 16:44:17'),(410711,'牧野区',410700,1,'2018-05-14 16:44:17'),(410721,'新乡县',410700,1,'2018-05-14 16:44:17'),(410724,'获嘉县',410700,1,'2018-05-14 16:44:17'),(410725,'原阳县',410700,1,'2018-05-14 16:44:17'),(410726,'延津县',410700,1,'2018-05-14 16:44:17'),(410727,'封丘县',410700,1,'2018-05-14 16:44:17'),(410728,'长垣县',410700,1,'2018-05-14 16:44:17'),(410781,'卫辉市',410700,1,'2018-05-14 16:44:17'),(410782,'辉县市',410700,1,'2018-05-14 16:44:17'),(410801,'市辖区',410800,1,'2018-05-14 16:44:17'),(410802,'解放区',410800,1,'2018-05-14 16:44:17'),(410803,'中站区',410800,1,'2018-05-14 16:44:17'),(410804,'马村区',410800,1,'2018-05-14 16:44:17'),(410811,'山阳区',410800,1,'2018-05-14 16:44:17'),(410821,'修武县',410800,1,'2018-05-14 16:44:17'),(410822,'博爱县',410800,1,'2018-05-14 16:44:17'),(410823,'武陟县',410800,1,'2018-05-14 16:44:17'),(410825,'温县',410800,1,'2018-05-14 16:44:17'),(410882,'沁阳市',410800,1,'2018-05-14 16:44:17'),(410883,'孟州市',410800,1,'2018-05-14 16:44:17'),(410901,'市辖区',410900,1,'2018-05-14 16:44:17'),(410902,'华龙区',410900,1,'2018-05-14 16:44:17'),(410922,'清丰县',410900,1,'2018-05-14 16:44:17'),(410923,'南乐县',410900,1,'2018-05-14 16:44:17'),(410926,'范县',410900,1,'2018-05-14 16:44:17'),(410927,'台前县',410900,1,'2018-05-14 16:44:17'),(410928,'濮阳县',410900,1,'2018-05-14 16:44:17'),(411001,'市辖区',411000,1,'2018-05-14 16:44:17'),(411002,'魏都区',411000,1,'2018-05-14 16:44:17'),(411023,'许昌县',411000,1,'2018-05-14 16:44:17'),(411024,'鄢陵县',411000,1,'2018-05-14 16:44:17'),(411025,'襄城县',411000,1,'2018-05-14 16:44:17'),(411081,'禹州市',411000,1,'2018-05-14 16:44:17'),(411082,'长葛市',411000,1,'2018-05-14 16:44:17'),(411101,'市辖区',411100,1,'2018-05-14 16:44:17'),(411102,'源汇区',411100,1,'2018-05-14 16:44:17'),(411103,'郾城区',411100,1,'2018-05-14 16:44:18'),(411104,'召陵区',411100,1,'2018-05-14 16:44:18'),(411121,'舞阳县',411100,1,'2018-05-14 16:44:18'),(411122,'临颍县',411100,1,'2018-05-14 16:44:18'),(411201,'市辖区',411200,1,'2018-05-14 16:44:18'),(411202,'湖滨区',411200,1,'2018-05-14 16:44:18'),(411203,'陕州区',411200,1,'2018-05-14 16:44:18'),(411221,'渑池县',411200,1,'2018-05-14 16:44:18'),(411224,'卢氏县',411200,1,'2018-05-14 16:44:18'),(411281,'义马市',411200,1,'2018-05-14 16:44:18'),(411282,'灵宝市',411200,1,'2018-05-14 16:44:18'),(411301,'市辖区',411300,1,'2018-05-14 16:44:18'),(411302,'宛城区',411300,1,'2018-05-14 16:44:18'),(411303,'卧龙区',411300,1,'2018-05-14 16:44:18'),(411321,'南召县',411300,1,'2018-05-14 16:44:18'),(411322,'方城县',411300,1,'2018-05-14 16:44:18'),(411323,'西峡县',411300,1,'2018-05-14 16:44:18'),(411324,'镇平县',411300,1,'2018-05-14 16:44:18'),(411325,'内乡县',411300,1,'2018-05-14 16:44:18'),(411326,'淅川县',411300,1,'2018-05-14 16:44:18'),(411327,'社旗县',411300,1,'2018-05-14 16:44:18'),(411328,'唐河县',411300,1,'2018-05-14 16:44:18'),(411329,'新野县',411300,1,'2018-05-14 16:44:18'),(411330,'桐柏县',411300,1,'2018-05-14 16:44:18'),(411381,'邓州市',411300,1,'2018-05-14 16:44:18'),(411401,'市辖区',411400,1,'2018-05-14 16:44:18'),(411402,'梁园区',411400,1,'2018-05-14 16:44:18'),(411403,'睢阳区',411400,1,'2018-05-14 16:44:18'),(411421,'民权县',411400,1,'2018-05-14 16:44:18'),(411422,'睢县',411400,1,'2018-05-14 16:44:18'),(411423,'宁陵县',411400,1,'2018-05-14 16:44:18'),(411424,'柘城县',411400,1,'2018-05-14 16:44:18'),(411425,'虞城县',411400,1,'2018-05-14 16:44:18'),(411426,'夏邑县',411400,1,'2018-05-14 16:44:18'),(411481,'永城市',411400,1,'2018-05-14 16:44:18'),(411501,'市辖区',411500,1,'2018-05-14 16:44:18'),(411502,'浉河区',411500,1,'2018-05-14 16:44:18'),(411503,'平桥区',411500,1,'2018-05-14 16:44:18'),(411521,'罗山县',411500,1,'2018-05-14 16:44:18'),(411522,'光山县',411500,1,'2018-05-14 16:44:18'),(411523,'新县',411500,1,'2018-05-14 16:44:18'),(411524,'商城县',411500,1,'2018-05-14 16:44:18'),(411525,'固始县',411500,1,'2018-05-14 16:44:18'),(411526,'潢川县',411500,1,'2018-05-14 16:44:18'),(411527,'淮滨县',411500,1,'2018-05-14 16:44:18'),(411528,'息县',411500,1,'2018-05-14 16:44:18'),(411601,'市辖区',411600,1,'2018-05-14 16:44:18'),(411602,'川汇区',411600,1,'2018-05-14 16:44:18'),(411621,'扶沟县',411600,1,'2018-05-14 16:44:18'),(411622,'西华县',411600,1,'2018-05-14 16:44:18'),(411623,'商水县',411600,1,'2018-05-14 16:44:18'),(411624,'沈丘县',411600,1,'2018-05-14 16:44:18'),(411625,'郸城县',411600,1,'2018-05-14 16:44:18'),(411626,'淮阳县',411600,1,'2018-05-14 16:44:18'),(411627,'太康县',411600,1,'2018-05-14 16:44:18'),(411628,'鹿邑县',411600,1,'2018-05-14 16:44:18'),(411681,'项城市',411600,1,'2018-05-14 16:44:18'),(411701,'市辖区',411700,1,'2018-05-14 16:44:18'),(411702,'驿城区',411700,1,'2018-05-14 16:44:18'),(411721,'西平县',411700,1,'2018-05-14 16:44:19'),(411722,'上蔡县',411700,1,'2018-05-14 16:44:19'),(411723,'平舆县',411700,1,'2018-05-14 16:44:19'),(411724,'正阳县',411700,1,'2018-05-14 16:44:19'),(411725,'确山县',411700,1,'2018-05-14 16:44:19'),(411726,'泌阳县',411700,1,'2018-05-14 16:44:19'),(411727,'汝南县',411700,1,'2018-05-14 16:44:19'),(411728,'遂平县',411700,1,'2018-05-14 16:44:19'),(411729,'新蔡县',411700,1,'2018-05-14 16:44:19'),(419001,'济源市',419000,1,'2018-05-14 16:44:19'),(420101,'市辖区',420100,1,'2018-05-14 16:44:19'),(420102,'江岸区',420100,1,'2018-05-14 16:44:19'),(420103,'江汉区',420100,1,'2018-05-14 16:44:19'),(420104,'硚口区',420100,1,'2018-05-14 16:44:19'),(420105,'汉阳区',420100,1,'2018-05-14 16:44:19'),(420106,'武昌区',420100,1,'2018-05-14 16:44:19'),(420107,'青山区',420100,1,'2018-05-14 16:44:19'),(420111,'洪山区',420100,1,'2018-05-14 16:44:19'),(420112,'东西湖区',420100,1,'2018-05-14 16:44:19'),(420113,'汉南区',420100,1,'2018-05-14 16:44:19'),(420114,'蔡甸区',420100,1,'2018-05-14 16:44:19'),(420115,'江夏区',420100,1,'2018-05-14 16:44:19'),(420116,'黄陂区',420100,1,'2018-05-14 16:44:19'),(420117,'新洲区',420100,1,'2018-05-14 16:44:19'),(420201,'市辖区',420200,1,'2018-05-14 16:44:19'),(420202,'黄石港区',420200,1,'2018-05-14 16:44:19'),(420203,'西塞山区',420200,1,'2018-05-14 16:44:19'),(420204,'下陆区',420200,1,'2018-05-14 16:44:19'),(420205,'铁山区',420200,1,'2018-05-14 16:44:19'),(420222,'阳新县',420200,1,'2018-05-14 16:44:19'),(420281,'大冶市',420200,1,'2018-05-14 16:44:19'),(420301,'市辖区',420300,1,'2018-05-14 16:44:19'),(420302,'茅箭区',420300,1,'2018-05-14 16:44:19'),(420303,'张湾区',420300,1,'2018-05-14 16:44:19'),(420304,'郧阳区',420300,1,'2018-05-14 16:44:19'),(420322,'郧西县',420300,1,'2018-05-14 16:44:19'),(420323,'竹山县',420300,1,'2018-05-14 16:44:19'),(420324,'竹溪县',420300,1,'2018-05-14 16:44:19'),(420325,'房县',420300,1,'2018-05-14 16:44:19'),(420381,'丹江口市',420300,1,'2018-05-14 16:44:19'),(420501,'市辖区',420500,1,'2018-05-14 16:44:19'),(420502,'西陵区',420500,1,'2018-05-14 16:44:19'),(420503,'伍家岗区',420500,1,'2018-05-14 16:44:19'),(420504,'点军区',420500,1,'2018-05-14 16:44:19'),(420505,'猇亭区',420500,1,'2018-05-14 16:44:19'),(420506,'夷陵区',420500,1,'2018-05-14 16:44:19'),(420525,'远安县',420500,1,'2018-05-14 16:44:19'),(420526,'兴山县',420500,1,'2018-05-14 16:44:19'),(420527,'秭归县',420500,1,'2018-05-14 16:44:19'),(420528,'长阳土家族自治县',420500,1,'2018-05-14 16:44:19'),(420529,'五峰土家族自治县',420500,1,'2018-05-14 16:44:19'),(420581,'宜都市',420500,1,'2018-05-14 16:44:19'),(420582,'当阳市',420500,1,'2018-05-14 16:44:19'),(420583,'枝江市',420500,1,'2018-05-14 16:44:19'),(420601,'市辖区',420600,1,'2018-05-14 16:44:19'),(420602,'襄城区',420600,1,'2018-05-14 16:44:19'),(420606,'樊城区',420600,1,'2018-05-14 16:44:19'),(420607,'襄州区',420600,1,'2018-05-14 16:44:19'),(420624,'南漳县',420600,1,'2018-05-14 16:44:19'),(420625,'谷城县',420600,1,'2018-05-14 16:44:19'),(420626,'保康县',420600,1,'2018-05-14 16:44:19'),(420682,'老河口市',420600,1,'2018-05-14 16:44:20'),(420683,'枣阳市',420600,1,'2018-05-14 16:44:20'),(420684,'宜城市',420600,1,'2018-05-14 16:44:20'),(420701,'市辖区',420700,1,'2018-05-14 16:44:20'),(420702,'梁子湖区',420700,1,'2018-05-14 16:44:20'),(420703,'华容区',420700,1,'2018-05-14 16:44:20'),(420704,'鄂城区',420700,1,'2018-05-14 16:44:20'),(420801,'市辖区',420800,1,'2018-05-14 16:44:20'),(420802,'东宝区',420800,1,'2018-05-14 16:44:20'),(420804,'掇刀区',420800,1,'2018-05-14 16:44:20'),(420821,'京山县',420800,1,'2018-05-14 16:44:20'),(420822,'沙洋县',420800,1,'2018-05-14 16:44:20'),(420881,'钟祥市',420800,1,'2018-05-14 16:44:20'),(420901,'市辖区',420900,1,'2018-05-14 16:44:20'),(420902,'孝南区',420900,1,'2018-05-14 16:44:20'),(420921,'孝昌县',420900,1,'2018-05-14 16:44:20'),(420922,'大悟县',420900,1,'2018-05-14 16:44:20'),(420923,'云梦县',420900,1,'2018-05-14 16:44:20'),(420981,'应城市',420900,1,'2018-05-14 16:44:20'),(420982,'安陆市',420900,1,'2018-05-14 16:44:20'),(420984,'汉川市',420900,1,'2018-05-14 16:44:20'),(421001,'市辖区',421000,1,'2018-05-14 16:44:20'),(421002,'沙市区',421000,1,'2018-05-14 16:44:20'),(421003,'荆州区',421000,1,'2018-05-14 16:44:20'),(421022,'公安县',421000,1,'2018-05-14 16:44:20'),(421023,'监利县',421000,1,'2018-05-14 16:44:20'),(421024,'江陵县',421000,1,'2018-05-14 16:44:20'),(421081,'石首市',421000,1,'2018-05-14 16:44:20'),(421083,'洪湖市',421000,1,'2018-05-14 16:44:20'),(421087,'松滋市',421000,1,'2018-05-14 16:44:20'),(421101,'市辖区',421100,1,'2018-05-14 16:44:20'),(421102,'黄州区',421100,1,'2018-05-14 16:44:20'),(421121,'团风县',421100,1,'2018-05-14 16:44:20'),(421122,'红安县',421100,1,'2018-05-14 16:44:20'),(421123,'罗田县',421100,1,'2018-05-14 16:44:20'),(421124,'英山县',421100,1,'2018-05-14 16:44:20'),(421125,'浠水县',421100,1,'2018-05-14 16:44:20'),(421126,'蕲春县',421100,1,'2018-05-14 16:44:20'),(421127,'黄梅县',421100,1,'2018-05-14 16:44:20'),(421181,'麻城市',421100,1,'2018-05-14 16:44:20'),(421182,'武穴市',421100,1,'2018-05-14 16:44:20'),(421201,'市辖区',421200,1,'2018-05-14 16:44:20'),(421202,'咸安区',421200,1,'2018-05-14 16:44:20'),(421221,'嘉鱼县',421200,1,'2018-05-14 16:44:20'),(421222,'通城县',421200,1,'2018-05-14 16:44:20'),(421223,'崇阳县',421200,1,'2018-05-14 16:44:20'),(421224,'通山县',421200,1,'2018-05-14 16:44:20'),(421281,'赤壁市',421200,1,'2018-05-14 16:44:20'),(421301,'市辖区',421300,1,'2018-05-14 16:44:20'),(421303,'曾都区',421300,1,'2018-05-14 16:44:20'),(421321,'随县',421300,1,'2018-05-14 16:44:20'),(421381,'广水市',421300,1,'2018-05-14 16:44:20'),(422801,'恩施市',422800,1,'2018-05-14 16:44:20'),(422802,'利川市',422800,1,'2018-05-14 16:44:20'),(422822,'建始县',422800,1,'2018-05-14 16:44:20'),(422823,'巴东县',422800,1,'2018-05-14 16:44:20'),(422825,'宣恩县',422800,1,'2018-05-14 16:44:20'),(422826,'咸丰县',422800,1,'2018-05-14 16:44:20'),(422827,'来凤县',422800,1,'2018-05-14 16:44:20'),(422828,'鹤峰县',422800,1,'2018-05-14 16:44:21'),(429004,'仙桃市',429000,1,'2018-05-14 16:44:21'),(429005,'潜江市',429000,1,'2018-05-14 16:44:21'),(429006,'天门市',429000,1,'2018-05-14 16:44:21'),(429021,'神农架林区',429000,1,'2018-05-14 16:44:21'),(430101,'市辖区',430100,1,'2018-05-14 16:44:21'),(430102,'芙蓉区',430100,1,'2018-05-14 16:44:21'),(430103,'天心区',430100,1,'2018-05-14 16:44:21'),(430104,'岳麓区',430100,1,'2018-05-14 16:44:21'),(430105,'开福区',430100,1,'2018-05-14 16:44:21'),(430111,'雨花区',430100,1,'2018-05-14 16:44:21'),(430112,'望城区',430100,1,'2018-05-14 16:44:21'),(430121,'长沙县',430100,1,'2018-05-14 16:44:21'),(430124,'宁乡县',430100,1,'2018-05-14 16:44:21'),(430181,'浏阳市',430100,1,'2018-05-14 16:44:21'),(430201,'市辖区',430200,1,'2018-05-14 16:44:21'),(430202,'荷塘区',430200,1,'2018-05-14 16:44:21'),(430203,'芦淞区',430200,1,'2018-05-14 16:44:21'),(430204,'石峰区',430200,1,'2018-05-14 16:44:21'),(430211,'天元区',430200,1,'2018-05-14 16:44:21'),(430221,'株洲县',430200,1,'2018-05-14 16:44:21'),(430223,'攸县',430200,1,'2018-05-14 16:44:21'),(430224,'茶陵县',430200,1,'2018-05-14 16:44:21'),(430225,'炎陵县',430200,1,'2018-05-14 16:44:21'),(430281,'醴陵市',430200,1,'2018-05-14 16:44:21'),(430301,'市辖区',430300,1,'2018-05-14 16:44:21'),(430302,'雨湖区',430300,1,'2018-05-14 16:44:21'),(430304,'岳塘区',430300,1,'2018-05-14 16:44:21'),(430321,'湘潭县',430300,1,'2018-05-14 16:44:21'),(430381,'湘乡市',430300,1,'2018-05-14 16:44:21'),(430382,'韶山市',430300,1,'2018-05-14 16:44:21'),(430401,'市辖区',430400,1,'2018-05-14 16:44:21'),(430405,'珠晖区',430400,1,'2018-05-14 16:44:21'),(430406,'雁峰区',430400,1,'2018-05-14 16:44:21'),(430407,'石鼓区',430400,1,'2018-05-14 16:44:21'),(430408,'蒸湘区',430400,1,'2018-05-14 16:44:21'),(430412,'南岳区',430400,1,'2018-05-14 16:44:21'),(430421,'衡阳县',430400,1,'2018-05-14 16:44:21'),(430422,'衡南县',430400,1,'2018-05-14 16:44:21'),(430423,'衡山县',430400,1,'2018-05-14 16:44:21'),(430424,'衡东县',430400,1,'2018-05-14 16:44:21'),(430426,'祁东县',430400,1,'2018-05-14 16:44:21'),(430481,'耒阳市',430400,1,'2018-05-14 16:44:21'),(430482,'常宁市',430400,1,'2018-05-14 16:44:21'),(430501,'市辖区',430500,1,'2018-05-14 16:44:21'),(430502,'双清区',430500,1,'2018-05-14 16:44:21'),(430503,'大祥区',430500,1,'2018-05-14 16:44:21'),(430511,'北塔区',430500,1,'2018-05-14 16:44:21'),(430521,'邵东县',430500,1,'2018-05-14 16:44:21'),(430522,'新邵县',430500,1,'2018-05-14 16:44:21'),(430523,'邵阳县',430500,1,'2018-05-14 16:44:21'),(430524,'隆回县',430500,1,'2018-05-14 16:44:21'),(430525,'洞口县',430500,1,'2018-05-14 16:44:21'),(430527,'绥宁县',430500,1,'2018-05-14 16:44:21'),(430528,'新宁县',430500,1,'2018-05-14 16:44:22'),(430529,'城步苗族自治县',430500,1,'2018-05-14 16:44:22'),(430581,'武冈市',430500,1,'2018-05-14 16:44:22'),(430601,'市辖区',430600,1,'2018-05-14 16:44:22'),(430602,'岳阳楼区',430600,1,'2018-05-14 16:44:22'),(430603,'云溪区',430600,1,'2018-05-14 16:44:22'),(430611,'君山区',430600,1,'2018-05-14 16:44:22'),(430621,'岳阳县',430600,1,'2018-05-14 16:44:22'),(430623,'华容县',430600,1,'2018-05-14 16:44:22'),(430624,'湘阴县',430600,1,'2018-05-14 16:44:22'),(430626,'平江县',430600,1,'2018-05-14 16:44:22'),(430681,'汨罗市',430600,1,'2018-05-14 16:44:22'),(430682,'临湘市',430600,1,'2018-05-14 16:44:22'),(430701,'市辖区',430700,1,'2018-05-14 16:44:22'),(430702,'武陵区',430700,1,'2018-05-14 16:44:22'),(430703,'鼎城区',430700,1,'2018-05-14 16:44:22'),(430721,'安乡县',430700,1,'2018-05-14 16:44:22'),(430722,'汉寿县',430700,1,'2018-05-14 16:44:22'),(430723,'澧县',430700,1,'2018-05-14 16:44:22'),(430724,'临澧县',430700,1,'2018-05-14 16:44:22'),(430725,'桃源县',430700,1,'2018-05-14 16:44:22'),(430726,'石门县',430700,1,'2018-05-14 16:44:22'),(430781,'津市市',430700,1,'2018-05-14 16:44:22'),(430801,'市辖区',430800,1,'2018-05-14 16:44:22'),(430802,'永定区',430800,1,'2018-05-14 16:44:22'),(430811,'武陵源区',430800,1,'2018-05-14 16:44:22'),(430821,'慈利县',430800,1,'2018-05-14 16:44:22'),(430822,'桑植县',430800,1,'2018-05-14 16:44:22'),(430901,'市辖区',430900,1,'2018-05-14 16:44:22'),(430902,'资阳区',430900,1,'2018-05-14 16:44:22'),(430903,'赫山区',430900,1,'2018-05-14 16:44:22'),(430921,'南县',430900,1,'2018-05-14 16:44:22'),(430922,'桃江县',430900,1,'2018-05-14 16:44:22'),(430923,'安化县',430900,1,'2018-05-14 16:44:22'),(430981,'沅江市',430900,1,'2018-05-14 16:44:22'),(431001,'市辖区',431000,1,'2018-05-14 16:44:22'),(431002,'北湖区',431000,1,'2018-05-14 16:44:22'),(431003,'苏仙区',431000,1,'2018-05-14 16:44:22'),(431021,'桂阳县',431000,1,'2018-05-14 16:44:22'),(431022,'宜章县',431000,1,'2018-05-14 16:44:22'),(431023,'永兴县',431000,1,'2018-05-14 16:44:22'),(431024,'嘉禾县',431000,1,'2018-05-14 16:44:22'),(431025,'临武县',431000,1,'2018-05-14 16:44:22'),(431026,'汝城县',431000,1,'2018-05-14 16:44:22'),(431027,'桂东县',431000,1,'2018-05-14 16:44:22'),(431028,'安仁县',431000,1,'2018-05-14 16:44:22'),(431081,'资兴市',431000,1,'2018-05-14 16:44:22'),(431101,'市辖区',431100,1,'2018-05-14 16:44:22'),(431102,'零陵区',431100,1,'2018-05-14 16:44:22'),(431103,'冷水滩区',431100,1,'2018-05-14 16:44:22'),(431121,'祁阳县',431100,1,'2018-05-14 16:44:22'),(431122,'东安县',431100,1,'2018-05-14 16:44:22'),(431123,'双牌县',431100,1,'2018-05-14 16:44:22'),(431124,'道县',431100,1,'2018-05-14 16:44:22'),(431125,'江永县',431100,1,'2018-05-14 16:44:22'),(431126,'宁远县',431100,1,'2018-05-14 16:44:22'),(431127,'蓝山县',431100,1,'2018-05-14 16:44:22'),(431128,'新田县',431100,1,'2018-05-14 16:44:23'),(431129,'江华瑶族自治县',431100,1,'2018-05-14 16:44:23'),(431201,'市辖区',431200,1,'2018-05-14 16:44:23'),(431202,'鹤城区',431200,1,'2018-05-14 16:44:23'),(431221,'中方县',431200,1,'2018-05-14 16:44:23'),(431222,'沅陵县',431200,1,'2018-05-14 16:44:23'),(431223,'辰溪县',431200,1,'2018-05-14 16:44:23'),(431224,'溆浦县',431200,1,'2018-05-14 16:44:23'),(431225,'会同县',431200,1,'2018-05-14 16:44:23'),(431226,'麻阳苗族自治县',431200,1,'2018-05-14 16:44:23'),(431227,'新晃侗族自治县',431200,1,'2018-05-14 16:44:23'),(431228,'芷江侗族自治县',431200,1,'2018-05-14 16:44:23'),(431229,'靖州苗族侗族自治县',431200,1,'2018-05-14 16:44:23'),(431230,'通道侗族自治县',431200,1,'2018-05-14 16:44:23'),(431281,'洪江市',431200,1,'2018-05-14 16:44:23'),(431301,'市辖区',431300,1,'2018-05-14 16:44:23'),(431302,'娄星区',431300,1,'2018-05-14 16:44:23'),(431321,'双峰县',431300,1,'2018-05-14 16:44:23'),(431322,'新化县',431300,1,'2018-05-14 16:44:23'),(431381,'冷水江市',431300,1,'2018-05-14 16:44:23'),(431382,'涟源市',431300,1,'2018-05-14 16:44:23'),(433101,'吉首市',433100,1,'2018-05-14 16:44:23'),(433122,'泸溪县',433100,1,'2018-05-14 16:44:23'),(433123,'凤凰县',433100,1,'2018-05-14 16:44:23'),(433124,'花垣县',433100,1,'2018-05-14 16:44:23'),(433125,'保靖县',433100,1,'2018-05-14 16:44:23'),(433126,'古丈县',433100,1,'2018-05-14 16:44:23'),(433127,'永顺县',433100,1,'2018-05-14 16:44:23'),(433130,'龙山县',433100,1,'2018-05-14 16:44:23'),(440101,'市辖区',440100,1,'2018-05-14 16:44:23'),(440103,'荔湾区',440100,1,'2018-05-14 16:44:23'),(440104,'越秀区',440100,1,'2018-05-14 16:44:23'),(440105,'海珠区',440100,1,'2018-05-14 16:44:23'),(440106,'天河区',440100,1,'2018-05-14 16:44:23'),(440111,'白云区',440100,1,'2018-05-14 16:44:23'),(440112,'黄埔区',440100,1,'2018-05-14 16:44:23'),(440113,'番禺区',440100,1,'2018-05-14 16:44:23'),(440114,'花都区',440100,1,'2018-05-14 16:44:23'),(440115,'南沙区',440100,1,'2018-05-14 16:44:23'),(440117,'从化区',440100,1,'2018-05-14 16:44:23'),(440118,'增城区',440100,1,'2018-05-14 16:44:23'),(440201,'市辖区',440200,1,'2018-05-14 16:44:23'),(440203,'武江区',440200,1,'2018-05-14 16:44:23'),(440204,'浈江区',440200,1,'2018-05-14 16:44:23'),(440205,'曲江区',440200,1,'2018-05-14 16:44:23'),(440222,'始兴县',440200,1,'2018-05-14 16:44:23'),(440224,'仁化县',440200,1,'2018-05-14 16:44:23'),(440229,'翁源县',440200,1,'2018-05-14 16:44:23'),(440232,'乳源瑶族自治县',440200,1,'2018-05-14 16:44:23'),(440233,'新丰县',440200,1,'2018-05-14 16:44:23'),(440281,'乐昌市',440200,1,'2018-05-14 16:44:23'),(440282,'南雄市',440200,1,'2018-05-14 16:44:23'),(440301,'市辖区',440300,1,'2018-05-14 16:44:23'),(440303,'罗湖区',440300,1,'2018-05-14 16:44:23'),(440304,'福田区',440300,1,'2018-05-14 16:44:23'),(440305,'南山区',440300,1,'2018-05-14 16:44:23'),(440306,'宝安区',440300,1,'2018-05-14 16:44:23'),(440307,'龙岗区',440300,1,'2018-05-14 16:44:23'),(440308,'盐田区',440300,1,'2018-05-14 16:44:24'),(440401,'市辖区',440400,1,'2018-05-14 16:44:24'),(440402,'香洲区',440400,1,'2018-05-14 16:44:24'),(440403,'斗门区',440400,1,'2018-05-14 16:44:24'),(440404,'金湾区',440400,1,'2018-05-14 16:44:24'),(440501,'市辖区',440500,1,'2018-05-14 16:44:24'),(440507,'龙湖区',440500,1,'2018-05-14 16:44:24'),(440511,'金平区',440500,1,'2018-05-14 16:44:24'),(440512,'濠江区',440500,1,'2018-05-14 16:44:24'),(440513,'潮阳区',440500,1,'2018-05-14 16:44:24'),(440514,'潮南区',440500,1,'2018-05-14 16:44:24'),(440515,'澄海区',440500,1,'2018-05-14 16:44:24'),(440523,'南澳县',440500,1,'2018-05-14 16:44:24'),(440601,'市辖区',440600,1,'2018-05-14 16:44:24'),(440604,'禅城区',440600,1,'2018-05-14 16:44:24'),(440605,'南海区',440600,1,'2018-05-14 16:44:24'),(440606,'顺德区',440600,1,'2018-05-14 16:44:24'),(440607,'三水区',440600,1,'2018-05-14 16:44:24'),(440608,'高明区',440600,1,'2018-05-14 16:44:24'),(440701,'市辖区',440700,1,'2018-05-14 16:44:24'),(440703,'蓬江区',440700,1,'2018-05-14 16:44:24'),(440704,'江海区',440700,1,'2018-05-14 16:44:24'),(440705,'新会区',440700,1,'2018-05-14 16:44:24'),(440781,'台山市',440700,1,'2018-05-14 16:44:24'),(440783,'开平市',440700,1,'2018-05-14 16:44:24'),(440784,'鹤山市',440700,1,'2018-05-14 16:44:24'),(440785,'恩平市',440700,1,'2018-05-14 16:44:24'),(440801,'市辖区',440800,1,'2018-05-14 16:44:24'),(440802,'赤坎区',440800,1,'2018-05-14 16:44:24'),(440803,'霞山区',440800,1,'2018-05-14 16:44:24'),(440804,'坡头区',440800,1,'2018-05-14 16:44:24'),(440811,'麻章区',440800,1,'2018-05-14 16:44:24'),(440823,'遂溪县',440800,1,'2018-05-14 16:44:24'),(440825,'徐闻县',440800,1,'2018-05-14 16:44:24'),(440881,'廉江市',440800,1,'2018-05-14 16:44:24'),(440882,'雷州市',440800,1,'2018-05-14 16:44:24'),(440883,'吴川市',440800,1,'2018-05-14 16:44:24'),(440901,'市辖区',440900,1,'2018-05-14 16:44:24'),(440902,'茂南区',440900,1,'2018-05-14 16:44:24'),(440904,'电白区',440900,1,'2018-05-14 16:44:24'),(440981,'高州市',440900,1,'2018-05-14 16:44:24'),(440982,'化州市',440900,1,'2018-05-14 16:44:24'),(440983,'信宜市',440900,1,'2018-05-14 16:44:24'),(441201,'市辖区',441200,1,'2018-05-14 16:44:24'),(441202,'端州区',441200,1,'2018-05-14 16:44:24'),(441203,'鼎湖区',441200,1,'2018-05-14 16:44:24'),(441204,'高要区',441200,1,'2018-05-14 16:44:24'),(441223,'广宁县',441200,1,'2018-05-14 16:44:24'),(441224,'怀集县',441200,1,'2018-05-14 16:44:24'),(441225,'封开县',441200,1,'2018-05-14 16:44:24'),(441226,'德庆县',441200,1,'2018-05-14 16:44:24'),(441284,'四会市',441200,1,'2018-05-14 16:44:24'),(441301,'市辖区',441300,1,'2018-05-14 16:44:24'),(441302,'惠城区',441300,1,'2018-05-14 16:44:25'),(441303,'惠阳区',441300,1,'2018-05-14 16:44:25'),(441322,'博罗县',441300,1,'2018-05-14 16:44:25'),(441323,'惠东县',441300,1,'2018-05-14 16:44:25'),(441324,'龙门县',441300,1,'2018-05-14 16:44:25'),(441401,'市辖区',441400,1,'2018-05-14 16:44:25'),(441402,'梅江区',441400,1,'2018-05-14 16:44:25'),(441403,'梅县区',441400,1,'2018-05-14 16:44:25'),(441422,'大埔县',441400,1,'2018-05-14 16:44:25'),(441423,'丰顺县',441400,1,'2018-05-14 16:44:25'),(441424,'五华县',441400,1,'2018-05-14 16:44:25'),(441426,'平远县',441400,1,'2018-05-14 16:44:25'),(441427,'蕉岭县',441400,1,'2018-05-14 16:44:25'),(441481,'兴宁市',441400,1,'2018-05-14 16:44:25'),(441501,'市辖区',441500,1,'2018-05-14 16:44:25'),(441502,'城区',441500,1,'2018-05-14 16:44:25'),(441521,'海丰县',441500,1,'2018-05-14 16:44:25'),(441523,'陆河县',441500,1,'2018-05-14 16:44:25'),(441581,'陆丰市',441500,1,'2018-05-14 16:44:25'),(441601,'市辖区',441600,1,'2018-05-14 16:44:25'),(441602,'源城区',441600,1,'2018-05-14 16:44:25'),(441621,'紫金县',441600,1,'2018-05-14 16:44:25'),(441622,'龙川县',441600,1,'2018-05-14 16:44:25'),(441623,'连平县',441600,1,'2018-05-14 16:44:25'),(441624,'和平县',441600,1,'2018-05-14 16:44:25'),(441625,'东源县',441600,1,'2018-05-14 16:44:25'),(441701,'市辖区',441700,1,'2018-05-14 16:44:25'),(441702,'江城区',441700,1,'2018-05-14 16:44:25'),(441704,'阳东区',441700,1,'2018-05-14 16:44:25'),(441721,'阳西县',441700,1,'2018-05-14 16:44:25'),(441781,'阳春市',441700,1,'2018-05-14 16:44:25'),(441801,'市辖区',441800,1,'2018-05-14 16:44:25'),(441802,'清城区',441800,1,'2018-05-14 16:44:25'),(441803,'清新区',441800,1,'2018-05-14 16:44:25'),(441821,'佛冈县',441800,1,'2018-05-14 16:44:25'),(441823,'阳山县',441800,1,'2018-05-14 16:44:25'),(441825,'连山壮族瑶族自治县',441800,1,'2018-05-14 16:44:25'),(441826,'连南瑶族自治县',441800,1,'2018-05-14 16:44:25'),(441881,'英德市',441800,1,'2018-05-14 16:44:25'),(441882,'连州市',441800,1,'2018-05-14 16:44:25'),(445101,'市辖区',445100,1,'2018-05-14 16:44:25'),(445102,'湘桥区',445100,1,'2018-05-14 16:44:25'),(445103,'潮安区',445100,1,'2018-05-14 16:44:25'),(445122,'饶平县',445100,1,'2018-05-14 16:44:25'),(445201,'市辖区',445200,1,'2018-05-14 16:44:25'),(445202,'榕城区',445200,1,'2018-05-14 16:44:25'),(445203,'揭东区',445200,1,'2018-05-14 16:44:25'),(445222,'揭西县',445200,1,'2018-05-14 16:44:25'),(445224,'惠来县',445200,1,'2018-05-14 16:44:25'),(445281,'普宁市',445200,1,'2018-05-14 16:44:25'),(445301,'市辖区',445300,1,'2018-05-14 16:44:25'),(445302,'云城区',445300,1,'2018-05-14 16:44:25'),(445303,'云安区',445300,1,'2018-05-14 16:44:25'),(445321,'新兴县',445300,1,'2018-05-14 16:44:25'),(445322,'郁南县',445300,1,'2018-05-14 16:44:25'),(445381,'罗定市',445300,1,'2018-05-14 16:44:26'),(450101,'市辖区',450100,1,'2018-05-14 16:44:26'),(450102,'兴宁区',450100,1,'2018-05-14 16:44:26'),(450103,'青秀区',450100,1,'2018-05-14 16:44:26'),(450105,'江南区',450100,1,'2018-05-14 16:44:26'),(450107,'西乡塘区',450100,1,'2018-05-14 16:44:26'),(450108,'良庆区',450100,1,'2018-05-14 16:44:26'),(450109,'邕宁区',450100,1,'2018-05-14 16:44:26'),(450110,'武鸣区',450100,1,'2018-05-14 16:44:26'),(450123,'隆安县',450100,1,'2018-05-14 16:44:26'),(450124,'马山县',450100,1,'2018-05-14 16:44:26'),(450125,'上林县',450100,1,'2018-05-14 16:44:26'),(450126,'宾阳县',450100,1,'2018-05-14 16:44:26'),(450127,'横县',450100,1,'2018-05-14 16:44:26'),(450201,'市辖区',450200,1,'2018-05-14 16:44:26'),(450202,'城中区',450200,1,'2018-05-14 16:44:26'),(450203,'鱼峰区',450200,1,'2018-05-14 16:44:26'),(450204,'柳南区',450200,1,'2018-05-14 16:44:26'),(450205,'柳北区',450200,1,'2018-05-14 16:44:26'),(450206,'柳江区',450200,1,'2018-05-14 16:44:26'),(450222,'柳城县',450200,1,'2018-05-14 16:44:26'),(450223,'鹿寨县',450200,1,'2018-05-14 16:44:26'),(450224,'融安县',450200,1,'2018-05-14 16:44:26'),(450225,'融水苗族自治县',450200,1,'2018-05-14 16:44:26'),(450226,'三江侗族自治县',450200,1,'2018-05-14 16:44:26'),(450301,'市辖区',450300,1,'2018-05-14 16:44:26'),(450302,'秀峰区',450300,1,'2018-05-14 16:44:26'),(450303,'叠彩区',450300,1,'2018-05-14 16:44:26'),(450304,'象山区',450300,1,'2018-05-14 16:44:26'),(450305,'七星区',450300,1,'2018-05-14 16:44:26'),(450311,'雁山区',450300,1,'2018-05-14 16:44:26'),(450312,'临桂区',450300,1,'2018-05-14 16:44:26'),(450321,'阳朔县',450300,1,'2018-05-14 16:44:26'),(450323,'灵川县',450300,1,'2018-05-14 16:44:26'),(450324,'全州县',450300,1,'2018-05-14 16:44:26'),(450325,'兴安县',450300,1,'2018-05-14 16:44:26'),(450326,'永福县',450300,1,'2018-05-14 16:44:26'),(450327,'灌阳县',450300,1,'2018-05-14 16:44:26'),(450328,'龙胜各族自治县',450300,1,'2018-05-14 16:44:26'),(450329,'资源县',450300,1,'2018-05-14 16:44:26'),(450330,'平乐县',450300,1,'2018-05-14 16:44:26'),(450331,'荔浦县',450300,1,'2018-05-14 16:44:26'),(450332,'恭城瑶族自治县',450300,1,'2018-05-14 16:44:26'),(450401,'市辖区',450400,1,'2018-05-14 16:44:26'),(450403,'万秀区',450400,1,'2018-05-14 16:44:26'),(450405,'长洲区',450400,1,'2018-05-14 16:44:26'),(450406,'龙圩区',450400,1,'2018-05-14 16:44:26'),(450421,'苍梧县',450400,1,'2018-05-14 16:44:26'),(450422,'藤县',450400,1,'2018-05-14 16:44:26'),(450423,'蒙山县',450400,1,'2018-05-14 16:44:26'),(450481,'岑溪市',450400,1,'2018-05-14 16:44:26'),(450501,'市辖区',450500,1,'2018-05-14 16:44:26'),(450502,'海城区',450500,1,'2018-05-14 16:44:26'),(450503,'银海区',450500,1,'2018-05-14 16:44:26'),(450512,'铁山港区',450500,1,'2018-05-14 16:44:26'),(450521,'合浦县',450500,1,'2018-05-14 16:44:26'),(450601,'市辖区',450600,1,'2018-05-14 16:44:26'),(450602,'港口区',450600,1,'2018-05-14 16:44:26'),(450603,'防城区',450600,1,'2018-05-14 16:44:26'),(450621,'上思县',450600,1,'2018-05-14 16:44:26'),(450681,'东兴市',450600,1,'2018-05-14 16:44:26'),(450701,'市辖区',450700,1,'2018-05-14 16:44:27'),(450702,'钦南区',450700,1,'2018-05-14 16:44:27'),(450703,'钦北区',450700,1,'2018-05-14 16:44:27'),(450721,'灵山县',450700,1,'2018-05-14 16:44:27'),(450722,'浦北县',450700,1,'2018-05-14 16:44:27'),(450801,'市辖区',450800,1,'2018-05-14 16:44:27'),(450802,'港北区',450800,1,'2018-05-14 16:44:27'),(450803,'港南区',450800,1,'2018-05-14 16:44:27'),(450804,'覃塘区',450800,1,'2018-05-14 16:44:27'),(450821,'平南县',450800,1,'2018-05-14 16:44:27'),(450881,'桂平市',450800,1,'2018-05-14 16:44:27'),(450901,'市辖区',450900,1,'2018-05-14 16:44:27'),(450902,'玉州区',450900,1,'2018-05-14 16:44:27'),(450903,'福绵区',450900,1,'2018-05-14 16:44:27'),(450921,'容县',450900,1,'2018-05-14 16:44:27'),(450922,'陆川县',450900,1,'2018-05-14 16:44:27'),(450923,'博白县',450900,1,'2018-05-14 16:44:27'),(450924,'兴业县',450900,1,'2018-05-14 16:44:27'),(450981,'北流市',450900,1,'2018-05-14 16:44:27'),(451001,'市辖区',451000,1,'2018-05-14 16:44:27'),(451002,'右江区',451000,1,'2018-05-14 16:44:27'),(451021,'田阳县',451000,1,'2018-05-14 16:44:27'),(451022,'田东县',451000,1,'2018-05-14 16:44:27'),(451023,'平果县',451000,1,'2018-05-14 16:44:27'),(451024,'德保县',451000,1,'2018-05-14 16:44:27'),(451026,'那坡县',451000,1,'2018-05-14 16:44:27'),(451027,'凌云县',451000,1,'2018-05-14 16:44:27'),(451028,'乐业县',451000,1,'2018-05-14 16:44:27'),(451029,'田林县',451000,1,'2018-05-14 16:44:27'),(451030,'西林县',451000,1,'2018-05-14 16:44:27'),(451031,'隆林各族自治县',451000,1,'2018-05-14 16:44:27'),(451081,'靖西市',451000,1,'2018-05-14 16:44:27'),(451101,'市辖区',451100,1,'2018-05-14 16:44:27'),(451102,'八步区',451100,1,'2018-05-14 16:44:27'),(451103,'平桂区',451100,1,'2018-05-14 16:44:27'),(451121,'昭平县',451100,1,'2018-05-14 16:44:27'),(451122,'钟山县',451100,1,'2018-05-14 16:44:27'),(451123,'富川瑶族自治县',451100,1,'2018-05-14 16:44:27'),(451201,'市辖区',451200,1,'2018-05-14 16:44:27'),(451202,'金城江区',451200,1,'2018-05-14 16:44:27'),(451221,'南丹县',451200,1,'2018-05-14 16:44:27'),(451222,'天峨县',451200,1,'2018-05-14 16:44:27'),(451223,'凤山县',451200,1,'2018-05-14 16:44:27'),(451224,'东兰县',451200,1,'2018-05-14 16:44:27'),(451225,'罗城仫佬族自治县',451200,1,'2018-05-14 16:44:27'),(451226,'环江毛南族自治县',451200,1,'2018-05-14 16:44:27'),(451227,'巴马瑶族自治县',451200,1,'2018-05-14 16:44:27'),(451228,'都安瑶族自治县',451200,1,'2018-05-14 16:44:27'),(451229,'大化瑶族自治县',451200,1,'2018-05-14 16:44:27'),(451281,'宜州市',451200,1,'2018-05-14 16:44:27'),(451301,'市辖区',451300,1,'2018-05-14 16:44:27'),(451302,'兴宾区',451300,1,'2018-05-14 16:44:27'),(451321,'忻城县',451300,1,'2018-05-14 16:44:27'),(451322,'象州县',451300,1,'2018-05-14 16:44:27'),(451323,'武宣县',451300,1,'2018-05-14 16:44:27'),(451324,'金秀瑶族自治县',451300,1,'2018-05-14 16:44:27'),(451381,'合山市',451300,1,'2018-05-14 16:44:27'),(451401,'市辖区',451400,1,'2018-05-14 16:44:27'),(451402,'江州区',451400,1,'2018-05-14 16:44:27'),(451421,'扶绥县',451400,1,'2018-05-14 16:44:27'),(451422,'宁明县',451400,1,'2018-05-14 16:44:27'),(451423,'龙州县',451400,1,'2018-05-14 16:44:27'),(451424,'大新县',451400,1,'2018-05-14 16:44:27'),(451425,'天等县',451400,1,'2018-05-14 16:44:28'),(451481,'凭祥市',451400,1,'2018-05-14 16:44:28'),(460101,'市辖区',460100,1,'2018-05-14 16:44:28'),(460105,'秀英区',460100,1,'2018-05-14 16:44:28'),(460106,'龙华区',460100,1,'2018-05-14 16:44:28'),(460107,'琼山区',460100,1,'2018-05-14 16:44:28'),(460108,'美兰区',460100,1,'2018-05-14 16:44:28'),(460201,'市辖区',460200,1,'2018-05-14 16:44:28'),(460202,'海棠区',460200,1,'2018-05-14 16:44:28'),(460203,'吉阳区',460200,1,'2018-05-14 16:44:28'),(460204,'天涯区',460200,1,'2018-05-14 16:44:28'),(460205,'崖州区',460200,1,'2018-05-14 16:44:28'),(469001,'五指山市',469000,1,'2018-05-14 16:44:28'),(469002,'琼海市',469000,1,'2018-05-14 16:44:28'),(469005,'文昌市',469000,1,'2018-05-14 16:44:28'),(469006,'万宁市',469000,1,'2018-05-14 16:44:28'),(469007,'东方市',469000,1,'2018-05-14 16:44:28'),(469021,'定安县',469000,1,'2018-05-14 16:44:28'),(469022,'屯昌县',469000,1,'2018-05-14 16:44:28'),(469023,'澄迈县',469000,1,'2018-05-14 16:44:28'),(469024,'临高县',469000,1,'2018-05-14 16:44:28'),(469025,'白沙黎族自治县',469000,1,'2018-05-14 16:44:28'),(469026,'昌江黎族自治县',469000,1,'2018-05-14 16:44:28'),(469027,'乐东黎族自治县',469000,1,'2018-05-14 16:44:28'),(469028,'陵水黎族自治县',469000,1,'2018-05-14 16:44:28'),(469029,'保亭黎族苗族自治县',469000,1,'2018-05-14 16:44:28'),(469030,'琼中黎族苗族自治县',469000,1,'2018-05-14 16:44:28'),(500101,'万州区',500100,1,'2018-05-14 16:44:28'),(500102,'涪陵区',500100,1,'2018-05-14 16:44:28'),(500103,'渝中区',500100,1,'2018-05-14 16:44:28'),(500104,'大渡口区',500100,1,'2018-05-14 16:44:28'),(500105,'江北区',500100,1,'2018-05-14 16:44:28'),(500106,'沙坪坝区',500100,1,'2018-05-14 16:44:28'),(500107,'九龙坡区',500100,1,'2018-05-14 16:44:28'),(500108,'南岸区',500100,1,'2018-05-14 16:44:28'),(500109,'北碚区',500100,1,'2018-05-14 16:44:28'),(500110,'綦江区',500100,1,'2018-05-14 16:44:28'),(500111,'大足区',500100,1,'2018-05-14 16:44:28'),(500112,'渝北区',500100,1,'2018-05-14 16:44:28'),(500113,'巴南区',500100,1,'2018-05-14 16:44:28'),(500114,'黔江区',500100,1,'2018-05-14 16:44:28'),(500115,'长寿区',500100,1,'2018-05-14 16:44:28'),(500116,'江津区',500100,1,'2018-05-14 16:44:28'),(500117,'合川区',500100,1,'2018-05-14 16:44:28'),(500118,'永川区',500100,1,'2018-05-14 16:44:28'),(500119,'南川区',500100,1,'2018-05-14 16:44:28'),(500120,'璧山区',500100,1,'2018-05-14 16:44:28'),(500151,'铜梁区',500100,1,'2018-05-14 16:44:28'),(500152,'潼南区',500100,1,'2018-05-14 16:44:28'),(500153,'荣昌区',500100,1,'2018-05-14 16:44:28'),(500154,'开州区',500100,1,'2018-05-14 16:44:28'),(500228,'梁平县',500200,1,'2018-05-14 16:44:28'),(500229,'城口县',500200,1,'2018-05-14 16:44:28'),(500230,'丰都县',500200,1,'2018-05-14 16:44:28'),(500231,'垫江县',500200,1,'2018-05-14 16:44:28'),(500232,'武隆县',500200,1,'2018-05-14 16:44:28'),(500233,'忠县',500200,1,'2018-05-14 16:44:28'),(500235,'云阳县',500200,1,'2018-05-14 16:44:29'),(500236,'奉节县',500200,1,'2018-05-14 16:44:29'),(500237,'巫山县',500200,1,'2018-05-14 16:44:29'),(500238,'巫溪县',500200,1,'2018-05-14 16:44:29'),(500240,'石柱土家族自治县',500200,1,'2018-05-14 16:44:29'),(500241,'秀山土家族苗族自治县',500200,1,'2018-05-14 16:44:29'),(500242,'酉阳土家族苗族自治县',500200,1,'2018-05-14 16:44:29'),(500243,'彭水苗族土家族自治县',500200,1,'2018-05-14 16:44:29'),(510101,'市辖区',510100,1,'2018-05-14 16:44:29'),(510104,'锦江区',510100,1,'2018-05-14 16:44:29'),(510105,'青羊区',510100,1,'2018-05-14 16:44:29'),(510106,'金牛区',510100,1,'2018-05-14 16:44:29'),(510107,'武侯区',510100,1,'2018-05-14 16:44:29'),(510108,'成华区',510100,1,'2018-05-14 16:44:29'),(510112,'龙泉驿区',510100,1,'2018-05-14 16:44:29'),(510113,'青白江区',510100,1,'2018-05-14 16:44:29'),(510114,'新都区',510100,1,'2018-05-14 16:44:29'),(510115,'温江区',510100,1,'2018-05-14 16:44:29'),(510116,'双流区',510100,1,'2018-05-14 16:44:29'),(510121,'金堂县',510100,1,'2018-05-14 16:44:29'),(510124,'郫县',510100,1,'2018-05-14 16:44:29'),(510129,'大邑县',510100,1,'2018-05-14 16:44:29'),(510131,'蒲江县',510100,1,'2018-05-14 16:44:29'),(510132,'新津县',510100,1,'2018-05-14 16:44:29'),(510181,'都江堰市',510100,1,'2018-05-14 16:44:29'),(510182,'彭州市',510100,1,'2018-05-14 16:44:29'),(510183,'邛崃市',510100,1,'2018-05-14 16:44:29'),(510184,'崇州市',510100,1,'2018-05-14 16:44:29'),(510185,'简阳市',510100,1,'2018-05-14 16:44:29'),(510301,'市辖区',510300,1,'2018-05-14 16:44:29'),(510302,'自流井区',510300,1,'2018-05-14 16:44:29'),(510303,'贡井区',510300,1,'2018-05-14 16:44:29'),(510304,'大安区',510300,1,'2018-05-14 16:44:29'),(510311,'沿滩区',510300,1,'2018-05-14 16:44:29'),(510321,'荣县',510300,1,'2018-05-14 16:44:29'),(510322,'富顺县',510300,1,'2018-05-14 16:44:29'),(510401,'市辖区',510400,1,'2018-05-14 16:44:29'),(510402,'东区',510400,1,'2018-05-14 16:44:29'),(510403,'西区',510400,1,'2018-05-14 16:44:29'),(510411,'仁和区',510400,1,'2018-05-14 16:44:29'),(510421,'米易县',510400,1,'2018-05-14 16:44:29'),(510422,'盐边县',510400,1,'2018-05-14 16:44:29'),(510501,'市辖区',510500,1,'2018-05-14 16:44:29'),(510502,'江阳区',510500,1,'2018-05-14 16:44:29'),(510503,'纳溪区',510500,1,'2018-05-14 16:44:29'),(510504,'龙马潭区',510500,1,'2018-05-14 16:44:29'),(510521,'泸县',510500,1,'2018-05-14 16:44:29'),(510522,'合江县',510500,1,'2018-05-14 16:44:29'),(510524,'叙永县',510500,1,'2018-05-14 16:44:29'),(510525,'古蔺县',510500,1,'2018-05-14 16:44:29'),(510601,'市辖区',510600,1,'2018-05-14 16:44:29'),(510603,'旌阳区',510600,1,'2018-05-14 16:44:29'),(510623,'中江县',510600,1,'2018-05-14 16:44:29'),(510626,'罗江县',510600,1,'2018-05-14 16:44:29'),(510681,'广汉市',510600,1,'2018-05-14 16:44:29'),(510682,'什邡市',510600,1,'2018-05-14 16:44:29'),(510683,'绵竹市',510600,1,'2018-05-14 16:44:29'),(510701,'市辖区',510700,1,'2018-05-14 16:44:29'),(510703,'涪城区',510700,1,'2018-05-14 16:44:29'),(510704,'游仙区',510700,1,'2018-05-14 16:44:29'),(510705,'安州区',510700,1,'2018-05-14 16:44:29'),(510722,'三台县',510700,1,'2018-05-14 16:44:29'),(510723,'盐亭县',510700,1,'2018-05-14 16:44:30'),(510725,'梓潼县',510700,1,'2018-05-14 16:44:30'),(510726,'北川羌族自治县',510700,1,'2018-05-14 16:44:30'),(510727,'平武县',510700,1,'2018-05-14 16:44:30'),(510781,'江油市',510700,1,'2018-05-14 16:44:30'),(510801,'市辖区',510800,1,'2018-05-14 16:44:30'),(510802,'利州区',510800,1,'2018-05-14 16:44:30'),(510811,'昭化区',510800,1,'2018-05-14 16:44:30'),(510812,'朝天区',510800,1,'2018-05-14 16:44:30'),(510821,'旺苍县',510800,1,'2018-05-14 16:44:30'),(510822,'青川县',510800,1,'2018-05-14 16:44:30'),(510823,'剑阁县',510800,1,'2018-05-14 16:44:30'),(510824,'苍溪县',510800,1,'2018-05-14 16:44:30'),(510901,'市辖区',510900,1,'2018-05-14 16:44:30'),(510903,'船山区',510900,1,'2018-05-14 16:44:30'),(510904,'安居区',510900,1,'2018-05-14 16:44:30'),(510921,'蓬溪县',510900,1,'2018-05-14 16:44:30'),(510922,'射洪县',510900,1,'2018-05-14 16:44:30'),(510923,'大英县',510900,1,'2018-05-14 16:44:30'),(511001,'市辖区',511000,1,'2018-05-14 16:44:30'),(511002,'市中区',511000,1,'2018-05-14 16:44:30'),(511011,'东兴区',511000,1,'2018-05-14 16:44:30'),(511024,'威远县',511000,1,'2018-05-14 16:44:30'),(511025,'资中县',511000,1,'2018-05-14 16:44:30'),(511028,'隆昌县',511000,1,'2018-05-14 16:44:30'),(511101,'市辖区',511100,1,'2018-05-14 16:44:30'),(511102,'市中区',511100,1,'2018-05-14 16:44:30'),(511111,'沙湾区',511100,1,'2018-05-14 16:44:30'),(511112,'五通桥区',511100,1,'2018-05-14 16:44:30'),(511113,'金口河区',511100,1,'2018-05-14 16:44:30'),(511123,'犍为县',511100,1,'2018-05-14 16:44:30'),(511124,'井研县',511100,1,'2018-05-14 16:44:30'),(511126,'夹江县',511100,1,'2018-05-14 16:44:30'),(511129,'沐川县',511100,1,'2018-05-14 16:44:30'),(511132,'峨边彝族自治县',511100,1,'2018-05-14 16:44:30'),(511133,'马边彝族自治县',511100,1,'2018-05-14 16:44:30'),(511181,'峨眉山市',511100,1,'2018-05-14 16:44:30'),(511301,'市辖区',511300,1,'2018-05-14 16:44:30'),(511302,'顺庆区',511300,1,'2018-05-14 16:44:30'),(511303,'高坪区',511300,1,'2018-05-14 16:44:30'),(511304,'嘉陵区',511300,1,'2018-05-14 16:44:30'),(511321,'南部县',511300,1,'2018-05-14 16:44:30'),(511322,'营山县',511300,1,'2018-05-14 16:44:30'),(511323,'蓬安县',511300,1,'2018-05-14 16:44:30'),(511324,'仪陇县',511300,1,'2018-05-14 16:44:30'),(511325,'西充县',511300,1,'2018-05-14 16:44:30'),(511381,'阆中市',511300,1,'2018-05-14 16:44:30'),(511401,'市辖区',511400,1,'2018-05-14 16:44:30'),(511402,'东坡区',511400,1,'2018-05-14 16:44:30'),(511403,'彭山区',511400,1,'2018-05-14 16:44:30'),(511421,'仁寿县',511400,1,'2018-05-14 16:44:30'),(511423,'洪雅县',511400,1,'2018-05-14 16:44:30'),(511424,'丹棱县',511400,1,'2018-05-14 16:44:30'),(511425,'青神县',511400,1,'2018-05-14 16:44:30'),(511501,'市辖区',511500,1,'2018-05-14 16:44:30'),(511502,'翠屏区',511500,1,'2018-05-14 16:44:30'),(511503,'南溪区',511500,1,'2018-05-14 16:44:30'),(511521,'宜宾县',511500,1,'2018-05-14 16:44:30'),(511523,'江安县',511500,1,'2018-05-14 16:44:30'),(511524,'长宁县',511500,1,'2018-05-14 16:44:30'),(511525,'高县',511500,1,'2018-05-14 16:44:30'),(511526,'珙县',511500,1,'2018-05-14 16:44:31'),(511527,'筠连县',511500,1,'2018-05-14 16:44:31'),(511528,'兴文县',511500,1,'2018-05-14 16:44:31'),(511529,'屏山县',511500,1,'2018-05-14 16:44:31'),(511601,'市辖区',511600,1,'2018-05-14 16:44:31'),(511602,'广安区',511600,1,'2018-05-14 16:44:31'),(511603,'前锋区',511600,1,'2018-05-14 16:44:31'),(511621,'岳池县',511600,1,'2018-05-14 16:44:31'),(511622,'武胜县',511600,1,'2018-05-14 16:44:31'),(511623,'邻水县',511600,1,'2018-05-14 16:44:31'),(511681,'华蓥市',511600,1,'2018-05-14 16:44:31'),(511701,'市辖区',511700,1,'2018-05-14 16:44:31'),(511702,'通川区',511700,1,'2018-05-14 16:44:31'),(511703,'达川区',511700,1,'2018-05-14 16:44:31'),(511722,'宣汉县',511700,1,'2018-05-14 16:44:31'),(511723,'开江县',511700,1,'2018-05-14 16:44:31'),(511724,'大竹县',511700,1,'2018-05-14 16:44:31'),(511725,'渠县',511700,1,'2018-05-14 16:44:31'),(511781,'万源市',511700,1,'2018-05-14 16:44:31'),(511801,'市辖区',511800,1,'2018-05-14 16:44:31'),(511802,'雨城区',511800,1,'2018-05-14 16:44:31'),(511803,'名山区',511800,1,'2018-05-14 16:44:31'),(511822,'荥经县',511800,1,'2018-05-14 16:44:31'),(511823,'汉源县',511800,1,'2018-05-14 16:44:31'),(511824,'石棉县',511800,1,'2018-05-14 16:44:31'),(511825,'天全县',511800,1,'2018-05-14 16:44:31'),(511826,'芦山县',511800,1,'2018-05-14 16:44:31'),(511827,'宝兴县',511800,1,'2018-05-14 16:44:31'),(511901,'市辖区',511900,1,'2018-05-14 16:44:31'),(511902,'巴州区',511900,1,'2018-05-14 16:44:31'),(511903,'恩阳区',511900,1,'2018-05-14 16:44:31'),(511921,'通江县',511900,1,'2018-05-14 16:44:31'),(511922,'南江县',511900,1,'2018-05-14 16:44:31'),(511923,'平昌县',511900,1,'2018-05-14 16:44:31'),(512001,'市辖区',512000,1,'2018-05-14 16:44:31'),(512002,'雁江区',512000,1,'2018-05-14 16:44:31'),(512021,'安岳县',512000,1,'2018-05-14 16:44:31'),(512022,'乐至县',512000,1,'2018-05-14 16:44:31'),(513201,'马尔康市',513200,1,'2018-05-14 16:44:31'),(513221,'汶川县',513200,1,'2018-05-14 16:44:31'),(513222,'理县',513200,1,'2018-05-14 16:44:31'),(513223,'茂县',513200,1,'2018-05-14 16:44:31'),(513224,'松潘县',513200,1,'2018-05-14 16:44:31'),(513225,'九寨沟县',513200,1,'2018-05-14 16:44:31'),(513226,'金川县',513200,1,'2018-05-14 16:44:31'),(513227,'小金县',513200,1,'2018-05-14 16:44:31'),(513228,'黑水县',513200,1,'2018-05-14 16:44:31'),(513230,'壤塘县',513200,1,'2018-05-14 16:44:31'),(513231,'阿坝县',513200,1,'2018-05-14 16:44:31'),(513232,'若尔盖县',513200,1,'2018-05-14 16:44:31'),(513233,'红原县',513200,1,'2018-05-14 16:44:31'),(513301,'康定市',513300,1,'2018-05-14 16:44:31'),(513322,'泸定县',513300,1,'2018-05-14 16:44:31'),(513323,'丹巴县',513300,1,'2018-05-14 16:44:31'),(513324,'九龙县',513300,1,'2018-05-14 16:44:31'),(513325,'雅江县',513300,1,'2018-05-14 16:44:31'),(513326,'道孚县',513300,1,'2018-05-14 16:44:32'),(513327,'炉霍县',513300,1,'2018-05-14 16:44:32'),(513328,'甘孜县',513300,1,'2018-05-14 16:44:32'),(513329,'新龙县',513300,1,'2018-05-14 16:44:32'),(513330,'德格县',513300,1,'2018-05-14 16:44:32'),(513331,'白玉县',513300,1,'2018-05-14 16:44:32'),(513332,'石渠县',513300,1,'2018-05-14 16:44:32'),(513333,'色达县',513300,1,'2018-05-14 16:44:32'),(513334,'理塘县',513300,1,'2018-05-14 16:44:32'),(513335,'巴塘县',513300,1,'2018-05-14 16:44:32'),(513336,'乡城县',513300,1,'2018-05-14 16:44:32'),(513337,'稻城县',513300,1,'2018-05-14 16:44:32'),(513338,'得荣县',513300,1,'2018-05-14 16:44:32'),(513401,'西昌市',513400,1,'2018-05-14 16:44:32'),(513422,'木里藏族自治县',513400,1,'2018-05-14 16:44:32'),(513423,'盐源县',513400,1,'2018-05-14 16:44:32'),(513424,'德昌县',513400,1,'2018-05-14 16:44:32'),(513425,'会理县',513400,1,'2018-05-14 16:44:32'),(513426,'会东县',513400,1,'2018-05-14 16:44:32'),(513427,'宁南县',513400,1,'2018-05-14 16:44:32'),(513428,'普格县',513400,1,'2018-05-14 16:44:32'),(513429,'布拖县',513400,1,'2018-05-14 16:44:32'),(513430,'金阳县',513400,1,'2018-05-14 16:44:32'),(513431,'昭觉县',513400,1,'2018-05-14 16:44:32'),(513432,'喜德县',513400,1,'2018-05-14 16:44:32'),(513433,'冕宁县',513400,1,'2018-05-14 16:44:32'),(513434,'越西县',513400,1,'2018-05-14 16:44:32'),(513435,'甘洛县',513400,1,'2018-05-14 16:44:32'),(513436,'美姑县',513400,1,'2018-05-14 16:44:32'),(513437,'雷波县',513400,1,'2018-05-14 16:44:32'),(520101,'市辖区',520100,1,'2018-05-14 16:44:32'),(520102,'南明区',520100,1,'2018-05-14 16:44:32'),(520103,'云岩区',520100,1,'2018-05-14 16:44:32'),(520111,'花溪区',520100,1,'2018-05-14 16:44:32'),(520112,'乌当区',520100,1,'2018-05-14 16:44:32'),(520113,'白云区',520100,1,'2018-05-14 16:44:32'),(520115,'观山湖区',520100,1,'2018-05-14 16:44:32'),(520121,'开阳县',520100,1,'2018-05-14 16:44:32'),(520122,'息烽县',520100,1,'2018-05-14 16:44:32'),(520123,'修文县',520100,1,'2018-05-14 16:44:32'),(520181,'清镇市',520100,1,'2018-05-14 16:44:32'),(520201,'钟山区',520200,1,'2018-05-14 16:44:32'),(520203,'六枝特区',520200,1,'2018-05-14 16:44:32'),(520221,'水城县',520200,1,'2018-05-14 16:44:32'),(520222,'盘县',520200,1,'2018-05-14 16:44:32'),(520301,'市辖区',520300,1,'2018-05-14 16:44:32'),(520302,'红花岗区',520300,1,'2018-05-14 16:44:32'),(520303,'汇川区',520300,1,'2018-05-14 16:44:32'),(520304,'播州区',520300,1,'2018-05-14 16:44:32'),(520322,'桐梓县',520300,1,'2018-05-14 16:44:32'),(520323,'绥阳县',520300,1,'2018-05-14 16:44:32'),(520324,'正安县',520300,1,'2018-05-14 16:44:32'),(520325,'道真仡佬族苗族自治县',520300,1,'2018-05-14 16:44:32'),(520326,'务川仡佬族苗族自治县',520300,1,'2018-05-14 16:44:32'),(520327,'凤冈县',520300,1,'2018-05-14 16:44:32'),(520328,'湄潭县',520300,1,'2018-05-14 16:44:32'),(520329,'余庆县',520300,1,'2018-05-14 16:44:32'),(520330,'习水县',520300,1,'2018-05-14 16:44:32'),(520381,'赤水市',520300,1,'2018-05-14 16:44:33'),(520382,'仁怀市',520300,1,'2018-05-14 16:44:33'),(520401,'市辖区',520400,1,'2018-05-14 16:44:33'),(520402,'西秀区',520400,1,'2018-05-14 16:44:33'),(520403,'平坝区',520400,1,'2018-05-14 16:44:33'),(520422,'普定县',520400,1,'2018-05-14 16:44:33'),(520423,'镇宁布依族苗族自治县',520400,1,'2018-05-14 16:44:33'),(520424,'关岭布依族苗族自治县',520400,1,'2018-05-14 16:44:33'),(520425,'紫云苗族布依族自治县',520400,1,'2018-05-14 16:44:33'),(520501,'市辖区',520500,1,'2018-05-14 16:44:33'),(520502,'七星关区',520500,1,'2018-05-14 16:44:33'),(520521,'大方县',520500,1,'2018-05-14 16:44:33'),(520522,'黔西县',520500,1,'2018-05-14 16:44:33'),(520523,'金沙县',520500,1,'2018-05-14 16:44:33'),(520524,'织金县',520500,1,'2018-05-14 16:44:33'),(520525,'纳雍县',520500,1,'2018-05-14 16:44:33'),(520526,'威宁彝族回族苗族自治县',520500,1,'2018-05-14 16:44:33'),(520527,'赫章县',520500,1,'2018-05-14 16:44:33'),(520601,'市辖区',520600,1,'2018-05-14 16:44:33'),(520602,'碧江区',520600,1,'2018-05-14 16:44:33'),(520603,'万山区',520600,1,'2018-05-14 16:44:33'),(520621,'江口县',520600,1,'2018-05-14 16:44:33'),(520622,'玉屏侗族自治县',520600,1,'2018-05-14 16:44:33'),(520623,'石阡县',520600,1,'2018-05-14 16:44:33'),(520624,'思南县',520600,1,'2018-05-14 16:44:33'),(520625,'印江土家族苗族自治县',520600,1,'2018-05-14 16:44:33'),(520626,'德江县',520600,1,'2018-05-14 16:44:33'),(520627,'沿河土家族自治县',520600,1,'2018-05-14 16:44:33'),(520628,'松桃苗族自治县',520600,1,'2018-05-14 16:44:33'),(522301,'兴义市',522300,1,'2018-05-14 16:44:33'),(522322,'兴仁县',522300,1,'2018-05-14 16:44:33'),(522323,'普安县',522300,1,'2018-05-14 16:44:33'),(522324,'晴隆县',522300,1,'2018-05-14 16:44:33'),(522325,'贞丰县',522300,1,'2018-05-14 16:44:33'),(522326,'望谟县',522300,1,'2018-05-14 16:44:33'),(522327,'册亨县',522300,1,'2018-05-14 16:44:33'),(522328,'安龙县',522300,1,'2018-05-14 16:44:33'),(522601,'凯里市',522600,1,'2018-05-14 16:44:33'),(522622,'黄平县',522600,1,'2018-05-14 16:44:33'),(522623,'施秉县',522600,1,'2018-05-14 16:44:33'),(522624,'三穗县',522600,1,'2018-05-14 16:44:33'),(522625,'镇远县',522600,1,'2018-05-14 16:44:33'),(522626,'岑巩县',522600,1,'2018-05-14 16:44:33'),(522627,'天柱县',522600,1,'2018-05-14 16:44:33'),(522628,'锦屏县',522600,1,'2018-05-14 16:44:33'),(522629,'剑河县',522600,1,'2018-05-14 16:44:33'),(522630,'台江县',522600,1,'2018-05-14 16:44:33'),(522631,'黎平县',522600,1,'2018-05-14 16:44:33'),(522632,'榕江县',522600,1,'2018-05-14 16:44:33'),(522633,'从江县',522600,1,'2018-05-14 16:44:33'),(522634,'雷山县',522600,1,'2018-05-14 16:44:33'),(522635,'麻江县',522600,1,'2018-05-14 16:44:33'),(522636,'丹寨县',522600,1,'2018-05-14 16:44:33'),(522701,'都匀市',522700,1,'2018-05-14 16:44:33'),(522702,'福泉市',522700,1,'2018-05-14 16:44:33'),(522722,'荔波县',522700,1,'2018-05-14 16:44:33'),(522723,'贵定县',522700,1,'2018-05-14 16:44:33'),(522725,'瓮安县',522700,1,'2018-05-14 16:44:33'),(522726,'独山县',522700,1,'2018-05-14 16:44:33'),(522727,'平塘县',522700,1,'2018-05-14 16:44:33'),(522728,'罗甸县',522700,1,'2018-05-14 16:44:33'),(522729,'长顺县',522700,1,'2018-05-14 16:44:33'),(522730,'龙里县',522700,1,'2018-05-14 16:44:33'),(522731,'惠水县',522700,1,'2018-05-14 16:44:33'),(522732,'三都水族自治县',522700,1,'2018-05-14 16:44:33'),(530101,'市辖区',530100,1,'2018-05-14 16:44:34'),(530102,'五华区',530100,1,'2018-05-14 16:44:34'),(530103,'盘龙区',530100,1,'2018-05-14 16:44:34'),(530111,'官渡区',530100,1,'2018-05-14 16:44:34'),(530112,'西山区',530100,1,'2018-05-14 16:44:34'),(530113,'东川区',530100,1,'2018-05-14 16:44:34'),(530114,'呈贡区',530100,1,'2018-05-14 16:44:34'),(530122,'晋宁县',530100,1,'2018-05-14 16:44:34'),(530124,'富民县',530100,1,'2018-05-14 16:44:34'),(530125,'宜良县',530100,1,'2018-05-14 16:44:34'),(530126,'石林彝族自治县',530100,1,'2018-05-14 16:44:34'),(530127,'嵩明县',530100,1,'2018-05-14 16:44:34'),(530128,'禄劝彝族苗族自治县',530100,1,'2018-05-14 16:44:34'),(530129,'寻甸回族彝族自治县',530100,1,'2018-05-14 16:44:34'),(530181,'安宁市',530100,1,'2018-05-14 16:44:34'),(530301,'市辖区',530300,1,'2018-05-14 16:44:34'),(530302,'麒麟区',530300,1,'2018-05-14 16:44:34'),(530303,'沾益区',530300,1,'2018-05-14 16:44:34'),(530321,'马龙县',530300,1,'2018-05-14 16:44:34'),(530322,'陆良县',530300,1,'2018-05-14 16:44:34'),(530323,'师宗县',530300,1,'2018-05-14 16:44:34'),(530324,'罗平县',530300,1,'2018-05-14 16:44:34'),(530325,'富源县',530300,1,'2018-05-14 16:44:34'),(530326,'会泽县',530300,1,'2018-05-14 16:44:34'),(530381,'宣威市',530300,1,'2018-05-14 16:44:34'),(530401,'市辖区',530400,1,'2018-05-14 16:44:34'),(530402,'红塔区',530400,1,'2018-05-14 16:44:34'),(530403,'江川区',530400,1,'2018-05-14 16:44:34'),(530422,'澄江县',530400,1,'2018-05-14 16:44:34'),(530423,'通海县',530400,1,'2018-05-14 16:44:34'),(530424,'华宁县',530400,1,'2018-05-14 16:44:34'),(530425,'易门县',530400,1,'2018-05-14 16:44:34'),(530426,'峨山彝族自治县',530400,1,'2018-05-14 16:44:34'),(530427,'新平彝族傣族自治县',530400,1,'2018-05-14 16:44:34'),(530428,'元江哈尼族彝族傣族自治县',530400,1,'2018-05-14 16:44:34'),(530501,'市辖区',530500,1,'2018-05-14 16:44:34'),(530502,'隆阳区',530500,1,'2018-05-14 16:44:34'),(530521,'施甸县',530500,1,'2018-05-14 16:44:34'),(530523,'龙陵县',530500,1,'2018-05-14 16:44:34'),(530524,'昌宁县',530500,1,'2018-05-14 16:44:34'),(530581,'腾冲市',530500,1,'2018-05-14 16:44:34'),(530601,'市辖区',530600,1,'2018-05-14 16:44:34'),(530602,'昭阳区',530600,1,'2018-05-14 16:44:34'),(530621,'鲁甸县',530600,1,'2018-05-14 16:44:34'),(530622,'巧家县',530600,1,'2018-05-14 16:44:34'),(530623,'盐津县',530600,1,'2018-05-14 16:44:34'),(530624,'大关县',530600,1,'2018-05-14 16:44:34'),(530625,'永善县',530600,1,'2018-05-14 16:44:34'),(530626,'绥江县',530600,1,'2018-05-14 16:44:34'),(530627,'镇雄县',530600,1,'2018-05-14 16:44:34'),(530628,'彝良县',530600,1,'2018-05-14 16:44:34'),(530629,'威信县',530600,1,'2018-05-14 16:44:34'),(530630,'水富县',530600,1,'2018-05-14 16:44:34'),(530701,'市辖区',530700,1,'2018-05-14 16:44:34'),(530702,'古城区',530700,1,'2018-05-14 16:44:34'),(530721,'玉龙纳西族自治县',530700,1,'2018-05-14 16:44:34'),(530722,'永胜县',530700,1,'2018-05-14 16:44:34'),(530723,'华坪县',530700,1,'2018-05-14 16:44:34'),(530724,'宁蒗彝族自治县',530700,1,'2018-05-14 16:44:34'),(530801,'市辖区',530800,1,'2018-05-14 16:44:34'),(530802,'思茅区',530800,1,'2018-05-14 16:44:34'),(530821,'宁洱哈尼族彝族自治县',530800,1,'2018-05-14 16:44:35'),(530822,'墨江哈尼族自治县',530800,1,'2018-05-14 16:44:35'),(530823,'景东彝族自治县',530800,1,'2018-05-14 16:44:35'),(530824,'景谷傣族彝族自治县',530800,1,'2018-05-14 16:44:35'),(530825,'镇沅彝族哈尼族拉祜族自治县',530800,1,'2018-05-14 16:44:35'),(530826,'江城哈尼族彝族自治县',530800,1,'2018-05-14 16:44:35'),(530827,'孟连傣族拉祜族佤族自治县',530800,1,'2018-05-14 16:44:35'),(530828,'澜沧拉祜族自治县',530800,1,'2018-05-14 16:44:35'),(530829,'西盟佤族自治县',530800,1,'2018-05-14 16:44:35'),(530901,'市辖区',530900,1,'2018-05-14 16:44:35'),(530902,'临翔区',530900,1,'2018-05-14 16:44:35'),(530921,'凤庆县',530900,1,'2018-05-14 16:44:35'),(530922,'云县',530900,1,'2018-05-14 16:44:35'),(530923,'永德县',530900,1,'2018-05-14 16:44:35'),(530924,'镇康县',530900,1,'2018-05-14 16:44:35'),(530925,'双江拉祜族佤族布朗族傣族自治县',530900,1,'2018-05-14 16:44:35'),(530926,'耿马傣族佤族自治县',530900,1,'2018-05-14 16:44:35'),(530927,'沧源佤族自治县',530900,1,'2018-05-14 16:44:35'),(532301,'楚雄市',532300,1,'2018-05-14 16:44:35'),(532322,'双柏县',532300,1,'2018-05-14 16:44:35'),(532323,'牟定县',532300,1,'2018-05-14 16:44:35'),(532324,'南华县',532300,1,'2018-05-14 16:44:35'),(532325,'姚安县',532300,1,'2018-05-14 16:44:35'),(532326,'大姚县',532300,1,'2018-05-14 16:44:35'),(532327,'永仁县',532300,1,'2018-05-14 16:44:35'),(532328,'元谋县',532300,1,'2018-05-14 16:44:35'),(532329,'武定县',532300,1,'2018-05-14 16:44:35'),(532331,'禄丰县',532300,1,'2018-05-14 16:44:35'),(532501,'个旧市',532500,1,'2018-05-14 16:44:35'),(532502,'开远市',532500,1,'2018-05-14 16:44:35'),(532503,'蒙自市',532500,1,'2018-05-14 16:44:35'),(532504,'弥勒市',532500,1,'2018-05-14 16:44:35'),(532523,'屏边苗族自治县',532500,1,'2018-05-14 16:44:35'),(532524,'建水县',532500,1,'2018-05-14 16:44:35'),(532525,'石屏县',532500,1,'2018-05-14 16:44:35'),(532527,'泸西县',532500,1,'2018-05-14 16:44:35'),(532528,'元阳县',532500,1,'2018-05-14 16:44:35'),(532529,'红河县',532500,1,'2018-05-14 16:44:35'),(532530,'金平苗族瑶族傣族自治县',532500,1,'2018-05-14 16:44:35'),(532531,'绿春县',532500,1,'2018-05-14 16:44:35'),(532532,'河口瑶族自治县',532500,1,'2018-05-14 16:44:35'),(532601,'文山市',532600,1,'2018-05-14 16:44:35'),(532622,'砚山县',532600,1,'2018-05-14 16:44:35'),(532623,'西畴县',532600,1,'2018-05-14 16:44:35'),(532624,'麻栗坡县',532600,1,'2018-05-14 16:44:35'),(532625,'马关县',532600,1,'2018-05-14 16:44:35'),(532626,'丘北县',532600,1,'2018-05-14 16:44:35'),(532627,'广南县',532600,1,'2018-05-14 16:44:35'),(532628,'富宁县',532600,1,'2018-05-14 16:44:35'),(532801,'景洪市',532800,1,'2018-05-14 16:44:35'),(532822,'勐海县',532800,1,'2018-05-14 16:44:35'),(532823,'勐腊县',532800,1,'2018-05-14 16:44:35'),(532901,'大理市',532900,1,'2018-05-14 16:44:35'),(532922,'漾濞彝族自治县',532900,1,'2018-05-14 16:44:35'),(532923,'祥云县',532900,1,'2018-05-14 16:44:36'),(532924,'宾川县',532900,1,'2018-05-14 16:44:36'),(532925,'弥渡县',532900,1,'2018-05-14 16:44:36'),(532926,'南涧彝族自治县',532900,1,'2018-05-14 16:44:36'),(532927,'巍山彝族回族自治县',532900,1,'2018-05-14 16:44:36'),(532928,'永平县',532900,1,'2018-05-14 16:44:36'),(532929,'云龙县',532900,1,'2018-05-14 16:44:36'),(532930,'洱源县',532900,1,'2018-05-14 16:44:36'),(532931,'剑川县',532900,1,'2018-05-14 16:44:36'),(532932,'鹤庆县',532900,1,'2018-05-14 16:44:36'),(533102,'瑞丽市',533100,1,'2018-05-14 16:44:36'),(533103,'芒市',533100,1,'2018-05-14 16:44:36'),(533122,'梁河县',533100,1,'2018-05-14 16:44:36'),(533123,'盈江县',533100,1,'2018-05-14 16:44:36'),(533124,'陇川县',533100,1,'2018-05-14 16:44:36'),(533301,'泸水市',533300,1,'2018-05-14 16:44:36'),(533323,'福贡县',533300,1,'2018-05-14 16:44:36'),(533324,'贡山独龙族怒族自治县',533300,1,'2018-05-14 16:44:36'),(533325,'兰坪白族普米族自治县',533300,1,'2018-05-14 16:44:36'),(533401,'香格里拉市',533400,1,'2018-05-14 16:44:36'),(533422,'德钦县',533400,1,'2018-05-14 16:44:36'),(533423,'维西傈僳族自治县',533400,1,'2018-05-14 16:44:36'),(540101,'市辖区',540100,1,'2018-05-14 16:44:36'),(540102,'城关区',540100,1,'2018-05-14 16:44:36'),(540103,'堆龙德庆区',540100,1,'2018-05-14 16:44:36'),(540121,'林周县',540100,1,'2018-05-14 16:44:36'),(540122,'当雄县',540100,1,'2018-05-14 16:44:36'),(540123,'尼木县',540100,1,'2018-05-14 16:44:36'),(540124,'曲水县',540100,1,'2018-05-14 16:44:36'),(540126,'达孜县',540100,1,'2018-05-14 16:44:36'),(540127,'墨竹工卡县',540100,1,'2018-05-14 16:44:36'),(540202,'桑珠孜区',540200,1,'2018-05-14 16:44:36'),(540221,'南木林县',540200,1,'2018-05-14 16:44:36'),(540222,'江孜县',540200,1,'2018-05-14 16:44:36'),(540223,'定日县',540200,1,'2018-05-14 16:44:36'),(540224,'萨迦县',540200,1,'2018-05-14 16:44:36'),(540225,'拉孜县',540200,1,'2018-05-14 16:44:36'),(540226,'昂仁县',540200,1,'2018-05-14 16:44:36'),(540227,'谢通门县',540200,1,'2018-05-14 16:44:36'),(540228,'白朗县',540200,1,'2018-05-14 16:44:36'),(540229,'仁布县',540200,1,'2018-05-14 16:44:36'),(540230,'康马县',540200,1,'2018-05-14 16:44:36'),(540231,'定结县',540200,1,'2018-05-14 16:44:36'),(540232,'仲巴县',540200,1,'2018-05-14 16:44:36'),(540233,'亚东县',540200,1,'2018-05-14 16:44:36'),(540234,'吉隆县',540200,1,'2018-05-14 16:44:36'),(540235,'聂拉木县',540200,1,'2018-05-14 16:44:36'),(540236,'萨嘎县',540200,1,'2018-05-14 16:44:36'),(540237,'岗巴县',540200,1,'2018-05-14 16:44:36'),(540302,'卡若区',540300,1,'2018-05-14 16:44:36'),(540321,'江达县',540300,1,'2018-05-14 16:44:36'),(540322,'贡觉县',540300,1,'2018-05-14 16:44:36'),(540323,'类乌齐县',540300,1,'2018-05-14 16:44:36'),(540324,'丁青县',540300,1,'2018-05-14 16:44:36'),(540325,'察雅县',540300,1,'2018-05-14 16:44:36'),(540326,'八宿县',540300,1,'2018-05-14 16:44:36'),(540327,'左贡县',540300,1,'2018-05-14 16:44:36'),(540328,'芒康县',540300,1,'2018-05-14 16:44:37'),(540329,'洛隆县',540300,1,'2018-05-14 16:44:37'),(540330,'边坝县',540300,1,'2018-05-14 16:44:37'),(540402,'巴宜区',540400,1,'2018-05-14 16:44:37'),(540421,'工布江达县',540400,1,'2018-05-14 16:44:37'),(540422,'米林县',540400,1,'2018-05-14 16:44:37'),(540423,'墨脱县',540400,1,'2018-05-14 16:44:37'),(540424,'波密县',540400,1,'2018-05-14 16:44:37'),(540425,'察隅县',540400,1,'2018-05-14 16:44:37'),(540426,'朗县',540400,1,'2018-05-14 16:44:37'),(540501,'市辖区',540500,1,'2018-05-14 16:44:37'),(540502,'乃东区',540500,1,'2018-05-14 16:44:37'),(540521,'扎囊县',540500,1,'2018-05-14 16:44:37'),(540522,'贡嘎县',540500,1,'2018-05-14 16:44:37'),(540523,'桑日县',540500,1,'2018-05-14 16:44:37'),(540524,'琼结县',540500,1,'2018-05-14 16:44:37'),(540525,'曲松县',540500,1,'2018-05-14 16:44:37'),(540526,'措美县',540500,1,'2018-05-14 16:44:37'),(540527,'洛扎县',540500,1,'2018-05-14 16:44:37'),(540528,'加查县',540500,1,'2018-05-14 16:44:37'),(540529,'隆子县',540500,1,'2018-05-14 16:44:37'),(540530,'错那县',540500,1,'2018-05-14 16:44:37'),(540531,'浪卡子县',540500,1,'2018-05-14 16:44:37'),(542421,'那曲县',542400,1,'2018-05-14 16:44:37'),(542422,'嘉黎县',542400,1,'2018-05-14 16:44:37'),(542423,'比如县',542400,1,'2018-05-14 16:44:37'),(542424,'聂荣县',542400,1,'2018-05-14 16:44:37'),(542425,'安多县',542400,1,'2018-05-14 16:44:37'),(542426,'申扎县',542400,1,'2018-05-14 16:44:37'),(542427,'索县',542400,1,'2018-05-14 16:44:37'),(542428,'班戈县',542400,1,'2018-05-14 16:44:37'),(542429,'巴青县',542400,1,'2018-05-14 16:44:37'),(542430,'尼玛县',542400,1,'2018-05-14 16:44:37'),(542431,'双湖县',542400,1,'2018-05-14 16:44:37'),(542521,'普兰县',542500,1,'2018-05-14 16:44:37'),(542522,'札达县',542500,1,'2018-05-14 16:44:37'),(542523,'噶尔县',542500,1,'2018-05-14 16:44:37'),(542524,'日土县',542500,1,'2018-05-14 16:44:37'),(542525,'革吉县',542500,1,'2018-05-14 16:44:37'),(542526,'改则县',542500,1,'2018-05-14 16:44:37'),(542527,'措勤县',542500,1,'2018-05-14 16:44:37'),(610101,'市辖区',610100,1,'2018-05-14 16:44:37'),(610102,'新城区',610100,1,'2018-05-14 16:44:37'),(610103,'碑林区',610100,1,'2018-05-14 16:44:37'),(610104,'莲湖区',610100,1,'2018-05-14 16:44:37'),(610111,'灞桥区',610100,1,'2018-05-14 16:44:37'),(610112,'未央区',610100,1,'2018-05-14 16:44:37'),(610113,'雁塔区',610100,1,'2018-05-14 16:44:37'),(610114,'阎良区',610100,1,'2018-05-14 16:44:37'),(610115,'临潼区',610100,1,'2018-05-14 16:44:37'),(610116,'长安区',610100,1,'2018-05-14 16:44:37'),(610117,'高陵区',610100,1,'2018-05-14 16:44:37'),(610122,'蓝田县',610100,1,'2018-05-14 16:44:37'),(610124,'周至县',610100,1,'2018-05-14 16:44:37'),(610125,'户县',610100,1,'2018-05-14 16:44:37'),(610201,'市辖区',610200,1,'2018-05-14 16:44:37'),(610202,'王益区',610200,1,'2018-05-14 16:44:37'),(610203,'印台区',610200,1,'2018-05-14 16:44:37'),(610204,'耀州区',610200,1,'2018-05-14 16:44:37'),(610222,'宜君县',610200,1,'2018-05-14 16:44:37'),(610301,'市辖区',610300,1,'2018-05-14 16:44:37'),(610302,'渭滨区',610300,1,'2018-05-14 16:44:38'),(610303,'金台区',610300,1,'2018-05-14 16:44:38'),(610304,'陈仓区',610300,1,'2018-05-14 16:44:38'),(610322,'凤翔县',610300,1,'2018-05-14 16:44:38'),(610323,'岐山县',610300,1,'2018-05-14 16:44:38'),(610324,'扶风县',610300,1,'2018-05-14 16:44:38'),(610326,'眉县',610300,1,'2018-05-14 16:44:38'),(610327,'陇县',610300,1,'2018-05-14 16:44:38'),(610328,'千阳县',610300,1,'2018-05-14 16:44:38'),(610329,'麟游县',610300,1,'2018-05-14 16:44:38'),(610330,'凤县',610300,1,'2018-05-14 16:44:38'),(610331,'太白县',610300,1,'2018-05-14 16:44:38'),(610401,'市辖区',610400,1,'2018-05-14 16:44:38'),(610402,'秦都区',610400,1,'2018-05-14 16:44:38'),(610403,'杨陵区',610400,1,'2018-05-14 16:44:38'),(610404,'渭城区',610400,1,'2018-05-14 16:44:38'),(610422,'三原县',610400,1,'2018-05-14 16:44:38'),(610423,'泾阳县',610400,1,'2018-05-14 16:44:38'),(610424,'乾县',610400,1,'2018-05-14 16:44:38'),(610425,'礼泉县',610400,1,'2018-05-14 16:44:38'),(610426,'永寿县',610400,1,'2018-05-14 16:44:38'),(610427,'彬县',610400,1,'2018-05-14 16:44:38'),(610428,'长武县',610400,1,'2018-05-14 16:44:38'),(610429,'旬邑县',610400,1,'2018-05-14 16:44:38'),(610430,'淳化县',610400,1,'2018-05-14 16:44:38'),(610431,'武功县',610400,1,'2018-05-14 16:44:38'),(610481,'兴平市',610400,1,'2018-05-14 16:44:38'),(610501,'市辖区',610500,1,'2018-05-14 16:44:38'),(610502,'临渭区',610500,1,'2018-05-14 16:44:38'),(610503,'华州区',610500,1,'2018-05-14 16:44:38'),(610522,'潼关县',610500,1,'2018-05-14 16:44:38'),(610523,'大荔县',610500,1,'2018-05-14 16:44:38'),(610524,'合阳县',610500,1,'2018-05-14 16:44:38'),(610525,'澄城县',610500,1,'2018-05-14 16:44:38'),(610526,'蒲城县',610500,1,'2018-05-14 16:44:38'),(610527,'白水县',610500,1,'2018-05-14 16:44:38'),(610528,'富平县',610500,1,'2018-05-14 16:44:38'),(610581,'韩城市',610500,1,'2018-05-14 16:44:38'),(610582,'华阴市',610500,1,'2018-05-14 16:44:38'),(610601,'市辖区',610600,1,'2018-05-14 16:44:38'),(610602,'宝塔区',610600,1,'2018-05-14 16:44:38'),(610603,'安塞区',610600,1,'2018-05-14 16:44:38'),(610621,'延长县',610600,1,'2018-05-14 16:44:38'),(610622,'延川县',610600,1,'2018-05-14 16:44:38'),(610623,'子长县',610600,1,'2018-05-14 16:44:38'),(610625,'志丹县',610600,1,'2018-05-14 16:44:38'),(610626,'吴起县',610600,1,'2018-05-14 16:44:38'),(610627,'甘泉县',610600,1,'2018-05-14 16:44:38'),(610628,'富县',610600,1,'2018-05-14 16:44:38'),(610629,'洛川县',610600,1,'2018-05-14 16:44:38'),(610630,'宜川县',610600,1,'2018-05-14 16:44:38'),(610631,'黄龙县',610600,1,'2018-05-14 16:44:38'),(610632,'黄陵县',610600,1,'2018-05-14 16:44:38'),(610701,'市辖区',610700,1,'2018-05-14 16:44:38'),(610702,'汉台区',610700,1,'2018-05-14 16:44:38'),(610721,'南郑县',610700,1,'2018-05-14 16:44:38'),(610722,'城固县',610700,1,'2018-05-14 16:44:38'),(610723,'洋县',610700,1,'2018-05-14 16:44:38'),(610724,'西乡县',610700,1,'2018-05-14 16:44:39'),(610725,'勉县',610700,1,'2018-05-14 16:44:39'),(610726,'宁强县',610700,1,'2018-05-14 16:44:39'),(610727,'略阳县',610700,1,'2018-05-14 16:44:39'),(610728,'镇巴县',610700,1,'2018-05-14 16:44:39'),(610729,'留坝县',610700,1,'2018-05-14 16:44:39'),(610730,'佛坪县',610700,1,'2018-05-14 16:44:39'),(610801,'市辖区',610800,1,'2018-05-14 16:44:39'),(610802,'榆阳区',610800,1,'2018-05-14 16:44:39'),(610803,'横山区',610800,1,'2018-05-14 16:44:39'),(610821,'神木县',610800,1,'2018-05-14 16:44:39'),(610822,'府谷县',610800,1,'2018-05-14 16:44:39'),(610824,'靖边县',610800,1,'2018-05-14 16:44:39'),(610825,'定边县',610800,1,'2018-05-14 16:44:39'),(610826,'绥德县',610800,1,'2018-05-14 16:44:39'),(610827,'米脂县',610800,1,'2018-05-14 16:44:39'),(610828,'佳县',610800,1,'2018-05-14 16:44:39'),(610829,'吴堡县',610800,1,'2018-05-14 16:44:39'),(610830,'清涧县',610800,1,'2018-05-14 16:44:39'),(610831,'子洲县',610800,1,'2018-05-14 16:44:39'),(610901,'市辖区',610900,1,'2018-05-14 16:44:39'),(610902,'汉滨区',610900,1,'2018-05-14 16:44:39'),(610921,'汉阴县',610900,1,'2018-05-14 16:44:39'),(610922,'石泉县',610900,1,'2018-05-14 16:44:39'),(610923,'宁陕县',610900,1,'2018-05-14 16:44:39'),(610924,'紫阳县',610900,1,'2018-05-14 16:44:39'),(610925,'岚皋县',610900,1,'2018-05-14 16:44:39'),(610926,'平利县',610900,1,'2018-05-14 16:44:39'),(610927,'镇坪县',610900,1,'2018-05-14 16:44:39'),(610928,'旬阳县',610900,1,'2018-05-14 16:44:39'),(610929,'白河县',610900,1,'2018-05-14 16:44:39'),(611001,'市辖区',611000,1,'2018-05-14 16:44:39'),(611002,'商州区',611000,1,'2018-05-14 16:44:39'),(611021,'洛南县',611000,1,'2018-05-14 16:44:39'),(611022,'丹凤县',611000,1,'2018-05-14 16:44:39'),(611023,'商南县',611000,1,'2018-05-14 16:44:39'),(611024,'山阳县',611000,1,'2018-05-14 16:44:39'),(611025,'镇安县',611000,1,'2018-05-14 16:44:39'),(611026,'柞水县',611000,1,'2018-05-14 16:44:39'),(620101,'市辖区',620100,1,'2018-05-14 16:44:39'),(620102,'城关区',620100,1,'2018-05-14 16:44:39'),(620103,'七里河区',620100,1,'2018-05-14 16:44:39'),(620104,'西固区',620100,1,'2018-05-14 16:44:39'),(620105,'安宁区',620100,1,'2018-05-14 16:44:39'),(620111,'红古区',620100,1,'2018-05-14 16:44:39'),(620121,'永登县',620100,1,'2018-05-14 16:44:39'),(620122,'皋兰县',620100,1,'2018-05-14 16:44:39'),(620123,'榆中县',620100,1,'2018-05-14 16:44:39'),(620201,'市辖区',620200,1,'2018-05-14 16:44:39'),(620301,'市辖区',620300,1,'2018-05-14 16:44:39'),(620302,'金川区',620300,1,'2018-05-14 16:44:39'),(620321,'永昌县',620300,1,'2018-05-14 16:44:39'),(620401,'市辖区',620400,1,'2018-05-14 16:44:39'),(620402,'白银区',620400,1,'2018-05-14 16:44:39'),(620403,'平川区',620400,1,'2018-05-14 16:44:39'),(620421,'靖远县',620400,1,'2018-05-14 16:44:39'),(620422,'会宁县',620400,1,'2018-05-14 16:44:39'),(620423,'景泰县',620400,1,'2018-05-14 16:44:39'),(620501,'市辖区',620500,1,'2018-05-14 16:44:39'),(620502,'秦州区',620500,1,'2018-05-14 16:44:39'),(620503,'麦积区',620500,1,'2018-05-14 16:44:39'),(620521,'清水县',620500,1,'2018-05-14 16:44:39'),(620522,'秦安县',620500,1,'2018-05-14 16:44:40'),(620523,'甘谷县',620500,1,'2018-05-14 16:44:40'),(620524,'武山县',620500,1,'2018-05-14 16:44:40'),(620525,'张家川回族自治县',620500,1,'2018-05-14 16:44:40'),(620601,'市辖区',620600,1,'2018-05-14 16:44:40'),(620602,'凉州区',620600,1,'2018-05-14 16:44:40'),(620621,'民勤县',620600,1,'2018-05-14 16:44:40'),(620622,'古浪县',620600,1,'2018-05-14 16:44:40'),(620623,'天祝藏族自治县',620600,1,'2018-05-14 16:44:40'),(620701,'市辖区',620700,1,'2018-05-14 16:44:40'),(620702,'甘州区',620700,1,'2018-05-14 16:44:40'),(620721,'肃南裕固族自治县',620700,1,'2018-05-14 16:44:40'),(620722,'民乐县',620700,1,'2018-05-14 16:44:40'),(620723,'临泽县',620700,1,'2018-05-14 16:44:40'),(620724,'高台县',620700,1,'2018-05-14 16:44:40'),(620725,'山丹县',620700,1,'2018-05-14 16:44:40'),(620801,'市辖区',620800,1,'2018-05-14 16:44:40'),(620802,'崆峒区',620800,1,'2018-05-14 16:44:40'),(620821,'泾川县',620800,1,'2018-05-14 16:44:40'),(620822,'灵台县',620800,1,'2018-05-14 16:44:40'),(620823,'崇信县',620800,1,'2018-05-14 16:44:40'),(620824,'华亭县',620800,1,'2018-05-14 16:44:40'),(620825,'庄浪县',620800,1,'2018-05-14 16:44:40'),(620826,'静宁县',620800,1,'2018-05-14 16:44:40'),(620901,'市辖区',620900,1,'2018-05-14 16:44:40'),(620902,'肃州区',620900,1,'2018-05-14 16:44:40'),(620921,'金塔县',620900,1,'2018-05-14 16:44:40'),(620922,'瓜州县',620900,1,'2018-05-14 16:44:40'),(620923,'肃北蒙古族自治县',620900,1,'2018-05-14 16:44:40'),(620924,'阿克塞哈萨克族自治县',620900,1,'2018-05-14 16:44:40'),(620981,'玉门市',620900,1,'2018-05-14 16:44:40'),(620982,'敦煌市',620900,1,'2018-05-14 16:44:40'),(621001,'市辖区',621000,1,'2018-05-14 16:44:40'),(621002,'西峰区',621000,1,'2018-05-14 16:44:40'),(621021,'庆城县',621000,1,'2018-05-14 16:44:40'),(621022,'环县',621000,1,'2018-05-14 16:44:40'),(621023,'华池县',621000,1,'2018-05-14 16:44:40'),(621024,'合水县',621000,1,'2018-05-14 16:44:40'),(621025,'正宁县',621000,1,'2018-05-14 16:44:40'),(621026,'宁县',621000,1,'2018-05-14 16:44:40'),(621027,'镇原县',621000,1,'2018-05-14 16:44:40'),(621101,'市辖区',621100,1,'2018-05-14 16:44:40'),(621102,'安定区',621100,1,'2018-05-14 16:44:40'),(621121,'通渭县',621100,1,'2018-05-14 16:44:40'),(621122,'陇西县',621100,1,'2018-05-14 16:44:40'),(621123,'渭源县',621100,1,'2018-05-14 16:44:40'),(621124,'临洮县',621100,1,'2018-05-14 16:44:40'),(621125,'漳县',621100,1,'2018-05-14 16:44:40'),(621126,'岷县',621100,1,'2018-05-14 16:44:40'),(621201,'市辖区',621200,1,'2018-05-14 16:44:40'),(621202,'武都区',621200,1,'2018-05-14 16:44:40'),(621221,'成县',621200,1,'2018-05-14 16:44:40'),(621222,'文县',621200,1,'2018-05-14 16:44:40'),(621223,'宕昌县',621200,1,'2018-05-14 16:44:40'),(621224,'康县',621200,1,'2018-05-14 16:44:40'),(621225,'西和县',621200,1,'2018-05-14 16:44:40'),(621226,'礼县',621200,1,'2018-05-14 16:44:40'),(621227,'徽县',621200,1,'2018-05-14 16:44:40'),(621228,'两当县',621200,1,'2018-05-14 16:44:40'),(622901,'临夏市',622900,1,'2018-05-14 16:44:40'),(622921,'临夏县',622900,1,'2018-05-14 16:44:40'),(622922,'康乐县',622900,1,'2018-05-14 16:44:40'),(622923,'永靖县',622900,1,'2018-05-14 16:44:40'),(622924,'广河县',622900,1,'2018-05-14 16:44:41'),(622925,'和政县',622900,1,'2018-05-14 16:44:41'),(622926,'东乡族自治县',622900,1,'2018-05-14 16:44:41'),(622927,'积石山保安族东乡族撒拉族自治县',622900,1,'2018-05-14 16:44:41'),(623001,'合作市',623000,1,'2018-05-14 16:44:41'),(623021,'临潭县',623000,1,'2018-05-14 16:44:41'),(623022,'卓尼县',623000,1,'2018-05-14 16:44:41'),(623023,'舟曲县',623000,1,'2018-05-14 16:44:41'),(623024,'迭部县',623000,1,'2018-05-14 16:44:41'),(623025,'玛曲县',623000,1,'2018-05-14 16:44:41'),(623026,'碌曲县',623000,1,'2018-05-14 16:44:41'),(623027,'夏河县',623000,1,'2018-05-14 16:44:41'),(630101,'市辖区',630100,1,'2018-05-14 16:44:41'),(630102,'城东区',630100,1,'2018-05-14 16:44:41'),(630103,'城中区',630100,1,'2018-05-14 16:44:41'),(630104,'城西区',630100,1,'2018-05-14 16:44:41'),(630105,'城北区',630100,1,'2018-05-14 16:44:41'),(630121,'大通回族土族自治县',630100,1,'2018-05-14 16:44:41'),(630122,'湟中县',630100,1,'2018-05-14 16:44:41'),(630123,'湟源县',630100,1,'2018-05-14 16:44:41'),(630202,'乐都区',630200,1,'2018-05-14 16:44:41'),(630203,'平安区',630200,1,'2018-05-14 16:44:41'),(630222,'民和回族土族自治县',630200,1,'2018-05-14 16:44:41'),(630223,'互助土族自治县',630200,1,'2018-05-14 16:44:41'),(630224,'化隆回族自治县',630200,1,'2018-05-14 16:44:41'),(630225,'循化撒拉族自治县',630200,1,'2018-05-14 16:44:41'),(632221,'门源回族自治县',632200,1,'2018-05-14 16:44:41'),(632222,'祁连县',632200,1,'2018-05-14 16:44:41'),(632223,'海晏县',632200,1,'2018-05-14 16:44:41'),(632224,'刚察县',632200,1,'2018-05-14 16:44:41'),(632321,'同仁县',632300,1,'2018-05-14 16:44:41'),(632322,'尖扎县',632300,1,'2018-05-14 16:44:41'),(632323,'泽库县',632300,1,'2018-05-14 16:44:41'),(632324,'河南蒙古族自治县',632300,1,'2018-05-14 16:44:41'),(632521,'共和县',632500,1,'2018-05-14 16:44:41'),(632522,'同德县',632500,1,'2018-05-14 16:44:41'),(632523,'贵德县',632500,1,'2018-05-14 16:44:41'),(632524,'兴海县',632500,1,'2018-05-14 16:44:41'),(632525,'贵南县',632500,1,'2018-05-14 16:44:41'),(632621,'玛沁县',632600,1,'2018-05-14 16:44:41'),(632622,'班玛县',632600,1,'2018-05-14 16:44:41'),(632623,'甘德县',632600,1,'2018-05-14 16:44:41'),(632624,'达日县',632600,1,'2018-05-14 16:44:41'),(632625,'久治县',632600,1,'2018-05-14 16:44:41'),(632626,'玛多县',632600,1,'2018-05-14 16:44:41'),(632701,'玉树市',632700,1,'2018-05-14 16:44:41'),(632722,'杂多县',632700,1,'2018-05-14 16:44:41'),(632723,'称多县',632700,1,'2018-05-14 16:44:41'),(632724,'治多县',632700,1,'2018-05-14 16:44:41'),(632725,'囊谦县',632700,1,'2018-05-14 16:44:41'),(632726,'曲麻莱县',632700,1,'2018-05-14 16:44:41'),(632801,'格尔木市',632800,1,'2018-05-14 16:44:41'),(632802,'德令哈市',632800,1,'2018-05-14 16:44:41'),(632821,'乌兰县',632800,1,'2018-05-14 16:44:41'),(632822,'都兰县',632800,1,'2018-05-14 16:44:41'),(632823,'天峻县',632800,1,'2018-05-14 16:44:41'),(640101,'市辖区',640100,1,'2018-05-14 16:44:42'),(640104,'兴庆区',640100,1,'2018-05-14 16:44:42'),(640105,'西夏区',640100,1,'2018-05-14 16:44:42'),(640106,'金凤区',640100,1,'2018-05-14 16:44:42'),(640121,'永宁县',640100,1,'2018-05-14 16:44:42'),(640122,'贺兰县',640100,1,'2018-05-14 16:44:42'),(640181,'灵武市',640100,1,'2018-05-14 16:44:42'),(640201,'市辖区',640200,1,'2018-05-14 16:44:42'),(640202,'大武口区',640200,1,'2018-05-14 16:44:42'),(640205,'惠农区',640200,1,'2018-05-14 16:44:42'),(640221,'平罗县',640200,1,'2018-05-14 16:44:42'),(640301,'市辖区',640300,1,'2018-05-14 16:44:42'),(640302,'利通区',640300,1,'2018-05-14 16:44:42'),(640303,'红寺堡区',640300,1,'2018-05-14 16:44:42'),(640323,'盐池县',640300,1,'2018-05-14 16:44:42'),(640324,'同心县',640300,1,'2018-05-14 16:44:42'),(640381,'青铜峡市',640300,1,'2018-05-14 16:44:42'),(640401,'市辖区',640400,1,'2018-05-14 16:44:42'),(640402,'原州区',640400,1,'2018-05-14 16:44:42'),(640422,'西吉县',640400,1,'2018-05-14 16:44:42'),(640423,'隆德县',640400,1,'2018-05-14 16:44:42'),(640424,'泾源县',640400,1,'2018-05-14 16:44:42'),(640425,'彭阳县',640400,1,'2018-05-14 16:44:42'),(640501,'市辖区',640500,1,'2018-05-14 16:44:42'),(640502,'沙坡头区',640500,1,'2018-05-14 16:44:42'),(640521,'中宁县',640500,1,'2018-05-14 16:44:42'),(640522,'海原县',640500,1,'2018-05-14 16:44:42'),(650101,'市辖区',650100,1,'2018-05-14 16:44:42'),(650102,'天山区',650100,1,'2018-05-14 16:44:42'),(650103,'沙依巴克区',650100,1,'2018-05-14 16:44:42'),(650104,'新市区',650100,1,'2018-05-14 16:44:42'),(650105,'水磨沟区',650100,1,'2018-05-14 16:44:42'),(650106,'头屯河区',650100,1,'2018-05-14 16:44:42'),(650107,'达坂城区',650100,1,'2018-05-14 16:44:42'),(650109,'米东区',650100,1,'2018-05-14 16:44:42'),(650121,'乌鲁木齐县',650100,1,'2018-05-14 16:44:42'),(650201,'市辖区',650200,1,'2018-05-14 16:44:42'),(650202,'独山子区',650200,1,'2018-05-14 16:44:42'),(650203,'克拉玛依区',650200,1,'2018-05-14 16:44:42'),(650204,'白碱滩区',650200,1,'2018-05-14 16:44:42'),(650205,'乌尔禾区',650200,1,'2018-05-14 16:44:42'),(650402,'高昌区',650400,1,'2018-05-14 16:44:42'),(650421,'鄯善县',650400,1,'2018-05-14 16:44:42'),(650422,'托克逊县',650400,1,'2018-05-14 16:44:42'),(650502,'伊州区',650500,1,'2018-05-14 16:44:42'),(650521,'巴里坤哈萨克自治县',650500,1,'2018-05-14 16:44:42'),(650522,'伊吾县',650500,1,'2018-05-14 16:44:42'),(652301,'昌吉市',652300,1,'2018-05-14 16:44:42'),(652302,'阜康市',652300,1,'2018-05-14 16:44:42'),(652323,'呼图壁县',652300,1,'2018-05-14 16:44:42'),(652324,'玛纳斯县',652300,1,'2018-05-14 16:44:42'),(652325,'奇台县',652300,1,'2018-05-14 16:44:42'),(652327,'吉木萨尔县',652300,1,'2018-05-14 16:44:42'),(652328,'木垒哈萨克自治县',652300,1,'2018-05-14 16:44:42'),(652701,'博乐市',652700,1,'2018-05-14 16:44:42'),(652702,'阿拉山口市',652700,1,'2018-05-14 16:44:42'),(652722,'精河县',652700,1,'2018-05-14 16:44:42'),(652723,'温泉县',652700,1,'2018-05-14 16:44:42'),(652801,'库尔勒市',652800,1,'2018-05-14 16:44:42'),(652822,'轮台县',652800,1,'2018-05-14 16:44:43'),(652823,'尉犁县',652800,1,'2018-05-14 16:44:43'),(652824,'若羌县',652800,1,'2018-05-14 16:44:43'),(652825,'且末县',652800,1,'2018-05-14 16:44:43'),(652826,'焉耆回族自治县',652800,1,'2018-05-14 16:44:43'),(652827,'和静县',652800,1,'2018-05-14 16:44:43'),(652828,'和硕县',652800,1,'2018-05-14 16:44:43'),(652829,'博湖县',652800,1,'2018-05-14 16:44:43'),(652901,'阿克苏市',652900,1,'2018-05-14 16:44:43'),(652922,'温宿县',652900,1,'2018-05-14 16:44:43'),(652923,'库车县',652900,1,'2018-05-14 16:44:43'),(652924,'沙雅县',652900,1,'2018-05-14 16:44:43'),(652925,'新和县',652900,1,'2018-05-14 16:44:43'),(652926,'拜城县',652900,1,'2018-05-14 16:44:43'),(652927,'乌什县',652900,1,'2018-05-14 16:44:43'),(652928,'阿瓦提县',652900,1,'2018-05-14 16:44:43'),(652929,'柯坪县',652900,1,'2018-05-14 16:44:43'),(653001,'阿图什市',653000,1,'2018-05-14 16:44:43'),(653022,'阿克陶县',653000,1,'2018-05-14 16:44:43'),(653023,'阿合奇县',653000,1,'2018-05-14 16:44:43'),(653024,'乌恰县',653000,1,'2018-05-14 16:44:43'),(653101,'喀什市',653100,1,'2018-05-14 16:44:43'),(653121,'疏附县',653100,1,'2018-05-14 16:44:43'),(653122,'疏勒县',653100,1,'2018-05-14 16:44:43'),(653123,'英吉沙县',653100,1,'2018-05-14 16:44:43'),(653124,'泽普县',653100,1,'2018-05-14 16:44:43'),(653125,'莎车县',653100,1,'2018-05-14 16:44:43'),(653126,'叶城县',653100,1,'2018-05-14 16:44:43'),(653127,'麦盖提县',653100,1,'2018-05-14 16:44:43'),(653128,'岳普湖县',653100,1,'2018-05-14 16:44:43'),(653129,'伽师县',653100,1,'2018-05-14 16:44:43'),(653130,'巴楚县',653100,1,'2018-05-14 16:44:43'),(653131,'塔什库尔干塔吉克自治县',653100,1,'2018-05-14 16:44:43'),(653201,'和田市',653200,1,'2018-05-14 16:44:43'),(653221,'和田县',653200,1,'2018-05-14 16:44:43'),(653222,'墨玉县',653200,1,'2018-05-14 16:44:43'),(653223,'皮山县',653200,1,'2018-05-14 16:44:43'),(653224,'洛浦县',653200,1,'2018-05-14 16:44:43'),(653225,'策勒县',653200,1,'2018-05-14 16:44:43'),(653226,'于田县',653200,1,'2018-05-14 16:44:43'),(653227,'民丰县',653200,1,'2018-05-14 16:44:43'),(654002,'伊宁市',654000,1,'2018-05-14 16:44:43'),(654003,'奎屯市',654000,1,'2018-05-14 16:44:43'),(654004,'霍尔果斯市',654000,1,'2018-05-14 16:44:43'),(654021,'伊宁县',654000,1,'2018-05-14 16:44:43'),(654022,'察布查尔锡伯自治县',654000,1,'2018-05-14 16:44:43'),(654023,'霍城县',654000,1,'2018-05-14 16:44:43'),(654024,'巩留县',654000,1,'2018-05-14 16:44:43'),(654025,'新源县',654000,1,'2018-05-14 16:44:43'),(654026,'昭苏县',654000,1,'2018-05-14 16:44:43'),(654027,'特克斯县',654000,1,'2018-05-14 16:44:43'),(654028,'尼勒克县',654000,1,'2018-05-14 16:44:43'),(654201,'塔城市',654200,1,'2018-05-14 16:44:43'),(654202,'乌苏市',654200,1,'2018-05-14 16:44:43'),(654221,'额敏县',654200,1,'2018-05-14 16:44:44'),(654223,'沙湾县',654200,1,'2018-05-14 16:44:44'),(654224,'托里县',654200,1,'2018-05-14 16:44:44'),(654225,'裕民县',654200,1,'2018-05-14 16:44:44'),(654226,'和布克赛尔蒙古自治县',654200,1,'2018-05-14 16:44:44'),(654301,'阿勒泰市',654300,1,'2018-05-14 16:44:44'),(654321,'布尔津县',654300,1,'2018-05-14 16:44:44'),(654322,'富蕴县',654300,1,'2018-05-14 16:44:44'),(654323,'福海县',654300,1,'2018-05-14 16:44:44'),(654324,'哈巴河县',654300,1,'2018-05-14 16:44:44'),(654325,'青河县',654300,1,'2018-05-14 16:44:44'),(654326,'吉木乃县',654300,1,'2018-05-14 16:44:44'),(659001,'石河子市',659000,1,'2018-05-14 16:44:44'),(659002,'阿拉尔市',659000,1,'2018-05-14 16:44:44'),(659003,'图木舒克市',659000,1,'2018-05-14 16:44:44'),(659004,'五家渠市',659000,1,'2018-05-14 16:44:44'),(659006,'铁门关市',659000,1,'2018-05-14 16:44:44');

/*Table structure for table `fixture_data_mptemplate` */

DROP TABLE IF EXISTS `fixture_data_mptemplate`;

CREATE TABLE `fixture_data_mptemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模板名称',
  `format` text COLLATE utf8mb4_unicode_ci COMMENT '格式，',
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模板格式json',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否显示 1显示 0不显示',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='数据源 - 微信公众号模板类型';

/*Data for the table `fixture_data_mptemplate` */

insert  into `fixture_data_mptemplate`(`id`,`name`,`format`,`content`,`status`,`created_at`) values (1,'客户预约','{\r\n    \"first\":\"{{first.DATA}}\",\r\n    \"keyword1\":\"{{keyword1.DATA}}\",\r\n    \"keyword2\":\"{{keyword2.DATA}}\",\r\n    \"keyword3\":\"{{keyword3.DATA}}\",\r\n    \"keyword4\":\"{{keyword4.DATA}}\",\r\n    \"remark\":\"{{remark.DATA}}\"\r\n}','{\r\n    \"first\":\"有新的客户预约，请及时确认\",\r\n    \"客户姓名\":\"张某\",\r\n    \"客户手机\":\"13888888888\",\r\n    \"预约时间\":\"2018-07-11 14:07\",\r\n    \"预约内容\":\"免费量房\",\r\n    \"remark\":\"客户在 陕西省 西安市发起了预约,住房面积为25平米\"\r\n}',1,'2018-07-11 14:05:22'),(2,'客户留言通知','{\r\n    \"first\":\"{{first.DATA}}\",\r\n    \"keyword1\":\"{{keyword1.DATA}}\",\r\n    \"keyword2\":\"{{keyword2.DATA}}\",\r\n    \"keyword3\":\"{{keyword3.DATA}}\",\r\n    \"remark\":\"{{remark.DATA}}\"\r\n}','{\r\n    \"first\":\"客户有新留言了，赶快看吧\",\r\n    \"客户姓名\":\"小王\",\r\n    \"留言内容\":\"您好，我要参观工地\",\r\n    \"预约时间\":\"2018-07-11 14:07\"\r\n}',1,'2018-07-11 14:05:25');

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
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` date DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据源 - 职位';

/*Data for the table `fixture_data_position` */

/*Table structure for table `fixture_data_prize_level` */

DROP TABLE IF EXISTS `fixture_data_prize_level`;

CREATE TABLE `fixture_data_prize_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '状态  1显示 0不显示',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='抽奖活动奖项等级';

/*Data for the table `fixture_data_prize_level` */

insert  into `fixture_data_prize_level`(`id`,`name`,`status`,`created_at`,`updated_at`) values (1,'谢谢参与',1,'2018-05-18 16:28:45',NULL),(2,'一等奖',1,'2018-05-18 16:28:47',NULL),(3,'二等奖',1,'2018-05-18 16:28:50',NULL),(4,'三等奖',1,'2018-05-18 16:28:52',NULL),(5,'四等奖',1,'2018-05-18 16:28:55',NULL),(6,'五等奖',1,'2018-05-18 16:28:57',NULL),(7,'六等奖',1,'2018-05-18 16:28:59',NULL),(8,'七等奖',1,'2018-05-18 16:29:01',NULL),(9,'八等奖',0,'2018-05-18 16:29:04',NULL);

/*Table structure for table `fixture_data_province` */

DROP TABLE IF EXISTS `fixture_data_province`;

CREATE TABLE `fixture_data_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=820001 DEFAULT CHARSET=utf8 COMMENT='数据源 - 省份';

/*Data for the table `fixture_data_province` */

insert  into `fixture_data_province`(`id`,`name`,`status`,`created_at`) values (110000,'北京市',1,'2018-05-14 16:43:50'),(120000,'天津市',1,'2018-05-14 16:43:51'),(130000,'河北省',1,'2018-05-14 16:43:51'),(140000,'山西省',1,'2018-05-14 16:43:54'),(150000,'内蒙古自治区',1,'2018-05-14 16:43:56'),(210000,'辽宁省',1,'2018-05-14 16:43:58'),(220000,'吉林省',1,'2018-05-14 16:44:00'),(230000,'黑龙江省',1,'2018-05-14 16:44:01'),(310000,'上海市',1,'2018-05-14 16:44:04'),(320000,'江苏省',1,'2018-05-14 16:44:04'),(330000,'浙江省',1,'2018-05-14 16:44:06'),(340000,'安徽省',1,'2018-05-14 16:44:07'),(350000,'福建省',1,'2018-05-14 16:44:09'),(360000,'江西省',1,'2018-05-14 16:44:11'),(370000,'山东省',1,'2018-05-14 16:44:13'),(410000,'河南省',1,'2018-05-14 16:44:16'),(420000,'湖北省',1,'2018-05-14 16:44:19'),(430000,'湖南省',1,'2018-05-14 16:44:21'),(440000,'广东省',1,'2018-05-14 16:44:23'),(450000,'广西壮族自治区',1,'2018-05-14 16:44:26'),(460000,'海南省',1,'2018-05-14 16:44:28'),(500000,'重庆市',1,'2018-05-14 16:44:28'),(510000,'四川省',1,'2018-05-14 16:44:29'),(520000,'贵州省',1,'2018-05-14 16:44:32'),(530000,'云南省',1,'2018-05-14 16:44:34'),(540000,'西藏自治区',1,'2018-05-14 16:44:36'),(610000,'陕西省',1,'2018-05-14 16:44:37'),(620000,'甘肃省',1,'2018-05-14 16:44:39'),(630000,'青海省',1,'2018-05-14 16:44:41'),(640000,'宁夏回族自治区',1,'2018-05-14 16:44:42'),(650000,'新疆维吾尔自治区',1,'2018-05-14 16:44:42'),(710000,'台湾省',1,'2018-05-14 16:44:44'),(810000,'香港特别行政区',1,'2018-05-14 16:44:44'),(820000,'澳门特别行政区',1,'2018-05-14 16:44:44');

/*Table structure for table `fixture_data_renovationmode` */

DROP TABLE IF EXISTS `fixture_data_renovationmode`;

CREATE TABLE `fixture_data_renovationmode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据源 - 装修方式';

/*Data for the table `fixture_data_renovationmode` */

/*Table structure for table `fixture_data_roomstyle` */

DROP TABLE IF EXISTS `fixture_data_roomstyle`;

CREATE TABLE `fixture_data_roomstyle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据源 - 装修风格';

/*Data for the table `fixture_data_roomstyle` */

/*Table structure for table `fixture_data_roomtype` */

DROP TABLE IF EXISTS `fixture_data_roomtype`;

CREATE TABLE `fixture_data_roomtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '创建时间',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据源 - 户型';

/*Data for the table `fixture_data_roomtype` */

/*Table structure for table `fixture_data_select_default` */

DROP TABLE IF EXISTS `fixture_data_select_default`;

CREATE TABLE `fixture_data_select_default` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '创建时间',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `pid` int(11) DEFAULT NULL COMMENT '父类id 分类id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COMMENT='数据源 - 默认数据（ 职位、装修方式、装修风格、户型）';

/*Data for the table `fixture_data_select_default` */

insert  into `fixture_data_select_default`(`id`,`name`,`status`,`pid`,`created_at`) values (1,'装修方式',1,0,'2018-03-19 16:37:09'),(2,'装修风格',1,0,'2018-03-19 16:37:09'),(3,'户型',1,0,'2018-03-19 16:37:09'),(4,'职位',1,0,'2018-03-19 16:37:09'),(5,'清包',1,1,'2018-03-19 16:37:09'),(6,'半包',1,1,'2018-03-19 16:37:09'),(7,'全包',1,1,'2018-03-19 16:37:09'),(8,'拎包入住',1,1,'2018-05-16 10:30:18'),(9,'整装',1,1,'2018-05-16 10:30:20'),(10,'现代',1,2,'2018-05-16 10:30:22'),(11,'中式',1,2,'2018-05-16 10:30:24'),(12,'欧式',1,2,'2018-05-16 10:30:29'),(13,'美式',1,2,'2018-05-16 10:30:31'),(14,'混搭',1,2,'2018-05-16 10:30:33'),(15,'田园',1,2,'2018-05-16 10:30:35'),(16,'新古典',1,2,'2018-05-16 10:30:37'),(17,'简约',1,2,'2018-05-16 10:30:40'),(18,'地中海',1,2,'2018-05-16 10:30:42'),(19,'东南亚',1,2,'2018-05-16 10:30:45'),(20,'别墅',1,3,'2018-05-16 10:31:19'),(21,'公寓',1,3,'2018-05-16 10:31:23'),(22,'普通住宅',1,3,'2018-05-16 10:31:25'),(23,'大平房',1,3,'2018-05-16 10:31:27'),(24,'老公房',1,3,'2018-05-16 10:31:30'),(25,'工装',1,3,'2018-05-16 10:31:32'),(26,'其他',1,3,'2018-05-16 10:31:35'),(27,'项目经理',1,4,'2018-06-05 15:27:32'),(28,'家装顾问',1,4,'2018-06-05 15:27:34'),(29,'项目监理',1,4,'2018-06-05 15:27:36'),(30,'设计师',1,4,'2018-06-05 15:27:38'),(31,'营销主管',1,4,'2018-06-05 15:27:40'),(32,'设计师主管',1,4,'2018-06-05 15:27:43'),(33,'客服主管',1,4,'2018-06-05 15:27:44'),(34,'资深设计师',1,4,'2018-06-05 15:27:47'),(35,'工长',1,4,'2018-06-05 15:27:50'),(36,'水电工',1,4,'2018-06-05 15:27:52'),(37,'设计总监',1,4,'2018-06-05 15:27:54'),(38,'油漆工',1,4,'2018-06-05 15:27:56'),(39,'客服',1,4,'2018-06-05 15:27:58'),(40,'泥工',1,4,'2018-06-05 15:28:17'),(41,'木工',1,4,'2018-06-05 15:28:20'),(42,'总经理',1,4,'2018-06-05 15:28:23'),(43,'瓦工',1,4,'2018-06-05 15:28:25'),(44,'质量总监',1,4,'2018-06-05 15:28:28'),(45,'董事长',1,4,'2018-06-05 15:28:30'),(46,'区域经理',1,4,'2018-06-05 15:28:32'),(47,'工程总监',1,4,'2018-06-05 15:28:35');

/*Table structure for table `fixture_data_source` */

DROP TABLE IF EXISTS `fixture_data_source`;

CREATE TABLE `fixture_data_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `sourcecateid` int(11) DEFAULT NULL COMMENT '来源分类id  对应sourcecate表id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='数据源 - 客户来源';

/*Data for the table `fixture_data_source` */

insert  into `fixture_data_source`(`id`,`name`,`sourcecateid`,`status`,`created_at`) values (1,'预约参观',1,1,'2018-03-19 16:42:04'),(2,'免费量房',1,1,'2018-03-19 16:42:04'),(3,'我要报名',1,1,'2018-03-19 16:42:04'),(4,'装修报价',1,1,'2018-03-19 16:42:04'),(5,'抽奖活动',2,1,'2018-05-17 10:33:22');

/*Table structure for table `fixture_data_sourcecate` */

DROP TABLE IF EXISTS `fixture_data_sourcecate`;

CREATE TABLE `fixture_data_sourcecate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '来源分类',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='数据源 - 客户来源分类';

/*Data for the table `fixture_data_sourcecate` */

insert  into `fixture_data_sourcecate`(`id`,`name`,`status`,`created_at`) values (1,'预约',1,'2018-05-17 10:34:00'),(2,'抽奖活动',1,'2018-05-17 10:34:02');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='数据源 - 会员机制';

/*Data for the table `fixture_data_vipmechanism` */

insert  into `fixture_data_vipmechanism`(`id`,`name`,`status`,`created_at`) values (1,'免费版',1,'2018-06-25 15:36:42'),(2,'标准版',1,'2018-06-25 15:36:44');

/*Table structure for table `fixture_dynamic` */

DROP TABLE IF EXISTS `fixture_dynamic`;

CREATE TABLE `fixture_dynamic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `cityid` int(11) DEFAULT NULL COMMENT '门店对应的城市id',
  `sitetid` int(11) DEFAULT NULL COMMENT '工地id',
  `activityid` int(11) DEFAULT NULL COMMENT '活动id',
  `participatoryid` int(11) DEFAULT NULL COMMENT '活动参与方式id ',
  `createuserid` int(11) DEFAULT NULL COMMENT '创建者id 用户 参与者  ',
  `title` varchar(200) DEFAULT NULL COMMENT '标题 活动',
  `resume` varchar(255) DEFAULT NULL COMMENT '简要文本 活动',
  `content` text COMMENT '内容',
  `type` tinyint(1) DEFAULT '0' COMMENT '类型 0工地动态 1活动动态',
  `sitestagename` varchar(255) DEFAULT NULL COMMENT '工地阶段名称',
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
  `content` text COMMENT '内容',
  `createuserid` int(11) DEFAULT NULL COMMENT '评论者id',
  `replyuserid` int(11) DEFAULT NULL COMMENT '回复者id',
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
  `commentnum` int(11) DEFAULT NULL COMMENT '评论数和回复数',
  `thumbsupnum` int(11) DEFAULT NULL COMMENT '点赞数，只可增加。',
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

/*Table structure for table `fixture_filter_function` */

DROP TABLE IF EXISTS `fixture_filter_function`;

CREATE TABLE `fixture_filter_function` (
  `id` int(11) NOT NULL COMMENT '编号',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称',
  `pid` int(11) DEFAULT NULL COMMENT '父类id',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `ismenu` tinyint(1) DEFAULT NULL COMMENT '是否菜单显示 1显示 0不显示',
  `menuname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '菜单显示名称',
  `level` tinyint(1) DEFAULT NULL COMMENT '层级',
  `controller` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '接口地址  和真实一样',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '访问地址',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1可用 0 不可用',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='过滤 - 功能';

/*Data for the table `fixture_filter_function` */

insert  into `fixture_filter_function`(`id`,`uuid`,`name`,`pid`,`sort`,`ismenu`,`menuname`,`level`,`controller`,`url`,`status`,`created_at`) values (1,'a62045a65ff211e889fa94de807e34a0','活动管理',0,1,1,'活动管理',1,'',NULL,1,'2018-05-25 16:07:00'),(2,'a620486f5ff211e889fa94de807e34a0','项目管理',0,2,1,'项目管理',1,'',NULL,1,'2018-05-25 16:07:00'),(3,'a620498d5ff211e889fa94de807e34a0','客户管理',0,3,1,'客户管理',1,'',NULL,1,'2018-05-25 16:07:00'),(4,'a6204aa75ff211e889fa94de807e34a0','门店管理',0,5,1,'门店管理',1,'StoreController','store-index',1,'2018-05-25 16:07:00'),(5,'a6204b8e5ff211e889fa94de807e34a0','角色管理',0,6,1,'角色管理',1,'RolesController','roles-index',1,'2018-05-25 16:07:00'),(6,'a6204c755ff211e889fa94de807e34a0','用户管理',0,7,1,'用户管理',1,'AdminController','admin-index',1,'2018-05-25 16:07:00'),(7,'a6204d5f5ff211e889fa94de807e34a0','系统属性',0,8,1,'系统属性',1,'DataController','data-index',1,'2018-05-25 16:07:00'),(8,'817dee2788e211e89e1f94de807e34a0','服务通知',0,4,1,'服务通知',1,'WeChatPublicNumberController','mp-send-index',1,'2018-07-16 18:25:05'),(101,'a6204e405ff211e889fa94de807e34a0','幸运抽奖',1,1,1,'幸运抽奖',2,'ActivityLuckyController','lucky-index',1,'2018-05-25 16:07:00'),(201,'a62055235ff211e889fa94de807e34a0','项目列表',2,1,1,'项目列表',2,'SiteController','site.index',1,'2018-05-25 16:07:00'),(202,'a62056155ff211e889fa94de807e34a0','新建项目',2,2,1,'新建项目',2,'SiteController','site.create',1,'2018-05-25 16:07:00'),(203,'a62056f55ff211e889fa94de807e34a0','阶段模板',2,3,1,'阶段模板',2,'SiteTemplateController','site-template.index',1,'2018-05-25 16:07:00'),(204,'751e6d517b8111e89f8694de807e34a0','工地动态',2,4,0,'工地动态',2,'DynamicController','dynamic-index',1,'2018-06-29 17:47:38'),(301,'a6205c485ff211e889fa94de807e34a0','预约客户',3,1,1,'预约客户',3,'ClientController','client.index',1,'2018-05-25 16:07:00'),(302,'a6205d325ff211e889fa94de807e34a0','抽奖客户',3,2,1,'抽奖客户',3,'ClientController','lucky-client',1,'2018-05-25 16:07:00');


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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='过滤 - 角色';

/*Data for the table `fixture_filter_role` */

insert  into `fixture_filter_role`(`id`,`uuid`,`name`,`status`,`isdefault`,`companyid`,`storeid`,`cityid`,`userid`,`created_at`,`updated_at`) values (1,'3809fa10aaf93ff5082040abea90a165','管理员',1,1,0,0,0,0,'2018-06-13 15:54:08',NULL),(2,'4a800506371511e89ce094de807e34a0','门店管理员',1,1,NULL,NULL,NULL,NULL,'2018-06-13 15:54:08',NULL);

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

/*Table structure for table `fixture_filter_roleauthority` */

DROP TABLE IF EXISTS `fixture_filter_roleauthority`;

CREATE TABLE `fixture_filter_roleauthority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `authorityoperationitemid` int(11) DEFAULT NULL COMMENT '业务功能id 0代表所有功能，个别的使用具体itemid值',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='过滤 - 自定义角色权限';

/*Data for the table `fixture_filter_roleauthority` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='过滤 - 用户角色';

/*Data for the table `fixture_filter_userauth` */

/*Table structure for table `fixture_log_notice` */

DROP TABLE IF EXISTS `fixture_log_notice`;

CREATE TABLE `fixture_log_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `cityid` int(11) DEFAULT NULL COMMENT '城市id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `nickname` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信昵称',
  `faceimg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信昵称',
  `typeid` tinyint(4) DEFAULT NULL COMMENT '1关注  、2赞、3评论、4客户预约',
  `typename` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '关注  、赞、评论、客户预约',
  `dynamicid` int(11) DEFAULT NULL COMMENT '动态id',
  `siteid` int(11) DEFAULT NULL COMMENT '工地id',
  `activityid` int(11) DEFAULT NULL COMMENT '活动id',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标题',
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '内容',
  `isread` tinyint(1) DEFAULT '0' COMMENT '是否已读 1已读 0未读',
  `userid` int(11) DEFAULT NULL COMMENT '用户id，对应用户表id',
  `iscreate` tinyint(4) DEFAULT '0' COMMENT '是否是创建者（触发者）1是 0不是',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='消息 - 通知';

/*Data for the table `fixture_log_notice` */

/*Table structure for table `fixture_log_vipupgrade` */

DROP TABLE IF EXISTS `fixture_log_vipupgrade`;

CREATE TABLE `fixture_log_vipupgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `vipmechanismid` int(11) DEFAULT NULL COMMENT '会员机制id，默认 标准版',
  `deadline` datetime DEFAULT NULL COMMENT '过期时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态 0申请中  1已申请',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
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
  `roomshapnumber` varchar(20) DEFAULT NULL COMMENT '房型按照英文逗号写入',
  `roomshap` varchar(20) DEFAULT NULL COMMENT '房型 几室几厅几厨几卫',
  `explodedossurl` varchar(255) DEFAULT NULL COMMENT '展示图',
  `codeimg` varchar(255) DEFAULT NULL,
  `isopen` tinyint(1) DEFAULT '1' COMMENT '是否公开（允许项目被其他人发现）默认1,1公开 0不公开',
  `stagetype` tinyint(1) DEFAULT '0' COMMENT '更新阶段者类型，默认0， 0用户 1参与者 （最新一次） ',
  `isfinish` tinyint(1) DEFAULT '0' COMMENT '是否完工，默认0， 1完工 0未完工',
  `createuserid` int(11) DEFAULT NULL COMMENT '创建者id 对应user表id',
  `linkednum` int(11) DEFAULT NULL COMMENT '工地浏览量',
  `follownum` int(11) DEFAULT NULL COMMENT '工地关注数',
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
  `participantid` int(11) DEFAULT NULL COMMENT '新建的成员信息id,对应成员表',
  `userid` int(11) DEFAULT NULL COMMENT '邀请者id，对应用户user表id',
  `joinuserid` int(11) DEFAULT NULL COMMENT '参与者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='参与者被邀请的工地';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工地阶段进度记录';

/*Data for the table `fixture_site_stageschedule` */

/*Table structure for table `fixture_small_program` */

DROP TABLE IF EXISTS `fixture_small_program`;

CREATE TABLE `fixture_small_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyid` int(11) NOT NULL COMMENT '公司id',
  `token` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'token',
  `EncodingAESKey` char(43) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '消息加密密钥',
  `authorization_info` text COLLATE utf8mb4_unicode_ci COMMENT '授权信息',
  `authorizer_info` text COLLATE utf8mb4_unicode_ci COMMENT '小程序信息',
  `authorizer_appid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '授权方appid',
  `authorizer_appid_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '小程序密钥',
  `type` tinyint(1) DEFAULT '0' COMMENT '0第三方授权1.独立部署',
  `authorizer_access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '授权方接口调用凭据（在授权的公众号或小程序具备API权限时，才有此返回值），也简称为令牌',
  `expires_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '有效期（在授权的公众号或小程序具备API权限时，才有此返回值）',
  `authorizer_refresh_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '接口调用凭据刷新令牌（在授权的公众号具备API权限时，才有此返回值），刷新令牌主要用于第三方平台获取和刷新已授权用户的access_token，只会在授权时刻提供，请妥善保存。 一旦丢失，只能让用户重新授权，才能再次拿到新的刷新令牌',
  `func_info` text COLLATE utf8mb4_unicode_ci COMMENT '授权给开发者的权限集列表，ID为1到26分别代表： 1、消息管理权限 2、用户管理权限 3、帐号服务权限 4、网页服务权限 5、微信小店权限 6、微信多客服权限 7、群发与通知权限 8、微信卡券权限 9、微信扫一扫权限 10、微信连WIFI权限 11、素材管理权限 12、微信摇周边权限 13、微信门店权限 14、微信支付权限 15、自定义菜单权限 16、获取认证状态及信息 17、帐号管理权限（小程序） 18、开发管理与数据分析权限（小程序） 19、客服消息管理权限（小程序） 20、微信登录权限（小程序） 21、数据分析权限（小程序） 22、城市服务接口权限 23、广告管理权限 24、开放平台帐号管理权限 25、 开放平台帐号管理权限（小程序） 26、微信电子发票权限 请注意： 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的帐号类型和认证情况，来判断公众号的接口权限。',
  `nick_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '授权方昵称',
  `head_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '授权方头像',
  `qrcode_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '二维码',
  `verify_type_info` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '授权方认证类型，-1代表未认证，0代表微信认证',
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '小程序的原始ID',
  `principal_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '小程序的主体名称',
  `status` tinyint(1) DEFAULT NULL COMMENT '认证状态 0.授权成功通 1取消授权 2.更新授权 ',
  `seturl` tinyint(1) DEFAULT NULL COMMENT '1设置url成功 0设置失败',
  `codestatus` tinyint(1) DEFAULT NULL COMMENT '1.完善用户信息2.设置类目3.设置url4.上传代码5.提交审核6.审核发布7.发布成功',
  `errmsg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '发布小程序信息',
  `auditid` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '发布小程序审核编号',
  `union_wechat_mp_appid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信公众号appid',
  `union_wechat_mp_appsecret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信公众号密钥',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='小程序应用授权';

/*Data for the table `fixture_small_program` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='发送短息表';

/*Data for the table `fixture_sms_history` */

/*Table structure for table `fixture_store` */

DROP TABLE IF EXISTS `fixture_store`;

CREATE TABLE `fixture_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `provinceid` int(11) DEFAULT NULL COMMENT '省id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `addr` varchar(255) DEFAULT NULL COMMENT '地址',
  `fulladdr` text COMMENT '省+市+地址',
  `isdefault` tinyint(1) DEFAULT '0' COMMENT '1公司默认门店 0公司创建的门店',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店';

/*Data for the table `fixture_store` */

/*Table structure for table `fixture_user` */

DROP TABLE IF EXISTS `fixture_user`;

CREATE TABLE `fixture_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `storeid` int(11) DEFAULT NULL COMMENT '门店id',
  `provinceid` int(11) DEFAULT NULL COMMENT '省id',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `positionid` int(11) DEFAULT NULL COMMENT '职位id',
  `username` varchar(20) DEFAULT NULL COMMENT '用户账号，系统自动生成 字母+数字，随机字符串 ',
  `phone` varchar(30) DEFAULT NULL COMMENT '手机号',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `nickname` varchar(200) DEFAULT NULL COMMENT '姓名/昵称',
  `resume` varchar(255) DEFAULT NULL COMMENT '个人简介',
  `faceimg` varchar(255) DEFAULT NULL COMMENT '头像',
  `wechatopenid` varchar(100) DEFAULT NULL COMMENT '微信openid',
  `isadmin` tinyint(1) DEFAULT '0' COMMENT '是否管理员，无默认，0不是 1是',
  `isadminafter` tinyint(1) DEFAULT '0' COMMENT '是否后端创建过来的 1是 0不是',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型 0B端用户 1C端用户 ',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id  对应role表id',
  `isinvitationed` tinyint(1) DEFAULT '0' COMMENT '是否是被邀请的参与者 1是 0不是',
  `isowner` tinyint(1) DEFAULT '0' COMMENT 'C端用户，是否业主 1是 0否',
  `isdefault` tinyint(1) DEFAULT '0' COMMENT '是否默认 0否 1是',
  `status` tinyint(1) DEFAULT '1' COMMENT '当前进行中账号状态 ，默认1, 1启用 0禁用',
  `token` char(32) DEFAULT NULL COMMENT '如果用户修改了用户相关信息请变更token防止多用户登陆信息不统一',
  `oid` int(11) DEFAULT NULL COMMENT '之前的用户id,解绑后需要恢复的用户id',
  `jguser` varchar(100) DEFAULT NULL COMMENT '极光账号',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户';

/*Data for the table `fixture_user` */

/*Table structure for table `fixture_user_dynamic_give` */

DROP TABLE IF EXISTS `fixture_user_dynamic_give`;

CREATE TABLE `fixture_user_dynamic_give` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dynamicid` int(11) DEFAULT NULL COMMENT '动态id',
  `userid` int(11) DEFAULT NULL COMMENT '工地id',
  `created_at` datetime DEFAULT NULL COMMENT '评论数和回复数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='动态 - 用户点赞';

/*Data for the table `fixture_user_dynamic_give` */

/*Table structure for table `fixture_user_mptemplate` */

DROP TABLE IF EXISTS `fixture_user_mptemplate`;

CREATE TABLE `fixture_user_mptemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `companytempid` int(11) DEFAULT NULL COMMENT '公司微信公众号模板绑定id，对应company_mptemplate表id',
  `datatemplateid` int(11) DEFAULT NULL COMMENT '数据源模板id,对应 data_mptemplate表id',
  `mpopenid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信公众号openid',
  `mpstatus` tinyint(1) DEFAULT '1' COMMENT '是否开启发送,1开启 0关闭',
  `isdefault` tinyint(1) DEFAULT '0' COMMENT '是否公司超管0 非超管 1超管',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='用户 - 已申请的微信公众号服务通知模板';

/*Data for the table `fixture_user_mptemplate` */

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

/* Procedure structure for procedure `role_function` */

/*!50003 DROP PROCEDURE IF EXISTS  `role_function` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`xxs`@`%` PROCEDURE `role_function`()
BEGIN

  DECLARE strRoleid int;

  DECLARE strIslook int;

  DECLARE stop int default 0;

  DECLARE cur cursor for(

		SELECT roleid,islook FROM `fixture_filter_role_function` WHERE functionid=2 and roleid not in (

			SELECT roleid FROM `fixture_filter_role_function` WHERE functionid=204 GROUP BY roleid

		) GROUP BY roleid

	);

  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET stop = null;

  OPEN cur;

		FETCH cur INTO strRoleid,strIslook;

		WHILE (stop is not null)DO

		INSERT INTO `fixture_filter_role_function` VALUES ('', REPLACE(UUID(),"-",""), strRoleid, '204', strIslook, now());

		FETCH cur INTO strRoleid,strIslook;

    END WHILE;

	CLOSE cur;

END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
