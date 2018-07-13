#授权
ALTER TABLE `fixture_small_program` MODIFY COLUMN `sourcecode`  tinyint(1) NULL DEFAULT NULL COMMENT '1审核成功 0代码提交失败 2.审核中  3.审核失败' AFTER `uploadcode`;
#增加公司封面背景图
ALTER TABLE `fixture_company` ADD COLUMN `covermap`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '封面图' AFTER `deadline`;
#会员机制
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `text`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `name`;
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `value`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '免费版value' AFTER `text`;
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `vipvalue`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'vip版value' AFTER `value`;
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `viptext`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `vipvalue`;
ALTER TABLE `fixture_conf_vipfunctionpoint` MODIFY COLUMN `content`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '说明' AFTER `viptext`;
ALTER TABLE `fixture_conf_vipfunctionpoint` DROP COLUMN `vipmechanismid`;
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `type`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '类型 max has' AFTER `content`;
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `controller`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '控制器' AFTER `type`;
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `mehod`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '方法' AFTER `controller`;
#插入会员机制数据
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('1', 'vip_max_site', '2', '2个', '0', '不限', '创建工地个数', 'max', null, null, '1', '2018-06-29 15:52:15');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('2', 'vip_dynamic', '2', '图文+VR', '2', '图文+VR+小视频', '发布工地动态', 'max', null, null, '1', '2018-06-29 15:52:18');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('3', 'vip_activity', '2', '每月2条', '0', '不限', '发布促销活动', 'max', null, null, '1', '2018-06-29 15:52:23');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('4', 'vip_has_participatory', '0', '无', '1', '有', '活动参与方式', 'has', 'ActivityController', null, '1', '2018-06-29 15:52:25');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('5', 'vip_appointment', '1', '每月一条', '1', '有', '客户预约', 'max', null, null, '1', '2018-06-29 15:52:27');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('6', 'vip_has_luck', '1', '有', '1', '有', '抽奖活动', 'has', 'ActivityLuckyController', null, '1', '2018-06-29 15:52:30');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('7', 'vip_has_freeoffer', '1', '有', '1', '有', '免费报价', 'allow', 'ClientAppointmentController', 'Appointment', '1', '2018-06-29 15:52:32');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('8', 'vip_has_message', '1', '有', '1', '有', '在线咨询', 'allow', null, null, '1', '2018-06-29 15:52:35');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('9', 'vip_has_consultation', '1', '有', '1', '有', '消息提醒', 'allow', null, null, '1', '2018-06-29 15:52:37');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('10', 'vip_has_visit_site', '1', '有', '1', '有', '预约参观', 'allow', 'ClientAppointmentController', 'Appointment', '1', '2018-06-29 15:52:39');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('11', 'vip_has_inviting_team_members', '1', '有', '1', '有', '邀请团队成员', 'allow', null, null, '1', '2018-06-29 15:52:41');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('12', 'vip_has_bussiness_comment', '1', '有', '1', '有', '业务评价', 'allow', null, null, '1', '2018-06-29 15:52:43');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('13', 'vip_has_share_more', '1', '有', '1', '有', '多渠道分享', 'allow', null, null, '1', '2018-06-29 15:52:46');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('14', 'vip_has_add_store', '1', '有', '1', '有', '新增门店', 'has', 'StoreController', null, '1', '2018-06-29 15:52:48');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('15', 'vip_has_add_admin', '0', '无', '1', '有', '新增用户', 'has', 'AdminController', null, '1', '2018-06-29 15:52:54');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('16', 'vip_has_role', '0', '无', '1', '有', '用户角色', 'has', 'RolesController', null, '1', '2018-06-29 15:52:58');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('17', 'vip_has_auth', '0', '无', '1', '有', '角色操作权限', 'has', 'RolesController', null, '1', '2018-06-29 15:53:00');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('18', 'vip_has_look', '0', '无', '1', '有', '角色视野权限', 'has', 'RolesController', null, '1', '2018-06-29 15:53:02');
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('19', 'vip_has_charts', '1', '简单数据分析', '2', '活动效果分析、客户转化率分析、渠道分析等更详细的数据分析、主流业务增长', '数据分析', 'max', null, null, '1', '2018-06-29 15:53:04');
#添加会员版本数据源数据
INSERT INTO `fixture_data_vipmechanism` VALUES ('1', '免费版', '1', '2018-06-25 15:36:42');
INSERT INTO `fixture_data_vipmechanism` VALUES ('2', '标准版', '1', '2018-06-25 15:36:44');

#删除工地成员
DROP TABLE `fixture_site_participant`;
#修改成公司成员
CREATE TABLE `fixture_company_participant` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`uuid`  char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '唯一索引' ,
`companyid`  int(11) NULL DEFAULT NULL COMMENT '公司id' ,
`positionid`  int(11) NULL DEFAULT NULL COMMENT '职位id' ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名，也就是对用户昵称的一个别名' ,
`userid`  int(11) NULL DEFAULT NULL COMMENT '创建者id,对应用户表id' ,
`created_at`  datetime NULL DEFAULT NULL COMMENT '创建时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Compact;
#参与者被邀请的工地/工地成员
ALTER TABLE `fixture_site_invitation` ADD COLUMN `participantid`  int(11) NULL DEFAULT NULL COMMENT '新建的成员信息id,对应成员表' AFTER `siteid`;
ALTER TABLE `fixture_site_invitation` ADD COLUMN `joinuserid`  int(11) NULL DEFAULT NULL COMMENT '参与者id' AFTER `userid`;
ALTER TABLE `fixture_site_invitation` MODIFY COLUMN `userid`  int(11) NULL DEFAULT NULL COMMENT '邀请者id，对应用户user表id' AFTER `joinuserid`;

#工地动态权限录入
INSERT INTO `fixture_filter_function` VALUES ('204', '751e6d517b8111e89f8694de807e34a0', '工地动态', '2', '4', '0', '工地动态', '2', 'DynamicController', 'dynamic-index', '1', '2018-06-29 17:47:38');

#将动态权限加入有已经有项目管理的角色里。
DROP PROCEDURE IF EXISTS role_function;
delimiter //
CREATE PROCEDURE role_function()
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
END;//
delimiter ;
call role_function();


#vip升级申请
ALTER TABLE `fixture_log_vipupgrade` ADD COLUMN `status`  tinyint(4) NULL DEFAULT 0 COMMENT '状态 0申请中  1已申请' AFTER `deadline`;
ALTER TABLE `fixture_log_vipupgrade` ADD COLUMN `updated_at`  datetime NULL DEFAULT NULL COMMENT '更新时间' AFTER `created_at`;

#用户解绑
ALTER TABLE `fixture_user` ADD COLUMN `oid`  int(11) NULL DEFAULT NULL COMMENT '之前的用户id,解绑后需要恢复的用户id' AFTER `token`;
#用户对应极光账号
ALTER TABLE `fixture_user` ADD COLUMN `jguser`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '极光账号' AFTER `oid`;



ALTER TABLE `fixture`.`fixture_client`  CHANGE `clientcity` `clientcity` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL  COMMENT '客户所在城市';

ALTER TABLE `fixture_small_program` DROP COLUMN `template_id`;

CREATE TABLE `fixture_data_mptemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模板名称',
  `format` text COLLATE utf8mb4_unicode_ci COMMENT '格式，',
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模板格式json',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否显示 1显示 0不显示',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='数据源 - 微信公众号模板类型';

-- ----------------------------
-- Records of fixture_data_mptemplate
-- ----------------------------
INSERT INTO `fixture_data_mptemplate` VALUES ('1', '客户预约', '{\r\n    \"first\":\"{{first.DATA}}\",\r\n    \"keyword1\":\"{{keyword1.DATA}}\",\r\n    \"keyword2\":\"{{keyword2.DATA}}\",\r\n    \"keyword3\":\"{{keyword3.DATA}}\",\r\n    \"remark\":\"{{remark.DATA}}\"\r\n}', '{\r\n    \"first\":\"有新的客户预约，请及时确认\",\r\n    \"客户姓名\":\"张某\",\r\n    \"客户手机\":\"13888888888\",\r\n    \"预约时间\":\"2018-07-11 14:07\",\r\n    \"预约内容\":\"免费量房\",\r\n    \"remark\":\"客户在 陕西省 西安市发起了预约,住房面积为25平米\"\r\n}', '1', '2018-07-11 14:05:25');
INSERT INTO `fixture_data_mptemplate` VALUES ('2', '客户留言通知', '{\r\n    \"first\":\"{{first.DATA}}\",\r\n    \"keyword1\":\"{{keyword1.DATA}}\",\r\n    \"keyword2\":\"{{keyword2.DATA}}\",\r\n    \"keyword3\":\"{{keyword3.DATA}}\",\r\n    \"keyword4\":\"{{keyword4.DATA}}\",\r\n    \"remark\":\"{{remark.DATA}}\"\r\n}', '{\r\n    \"first\":\"客户有新留言了，赶快看吧\",\r\n    \"客户姓名\":\"小王\",\r\n    \"留言内容\":\"您好，我要参观工地\",\r\n    \"预约时间\":\"2018-07-11 14:07\"\r\n}', '1', '2018-07-11 14:05:22');

CREATE TABLE `fixture_company_mptemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `datatemplateid` int(11) DEFAULT NULL COMMENT '模板类型id,对应data_mptemplate表的id',
  `mptemplateid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信公众号号模板id',
  `status` tinyint(1) DEFAULT '1' COMMENT '是否禁用  1正常 0关闭',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='公司 - 设置的微信公众号服务通知模板';


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户 - 已申请的微信公众号服务通知模板';


ALTER TABLE `xxs_fixture`.`fixture_small_program` DROP COLUMN `uploadcode`, DROP COLUMN `sourcecode`, DROP COLUMN `verify_ticket`;


#####以上已同步线上######
