SET FOREIGN_KEY_CHECKS=0;
#增加公司封面背景图
ALTER TABLE `fixture_company` ADD COLUMN `covermap`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '封面图' AFTER `deadline`;
#会员机制
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `text`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `name`;
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `value`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标准版value' AFTER `text`;
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `vipvalue`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'vip版value' AFTER `value`;
ALTER TABLE `fixture_conf_vipfunctionpoint` ADD COLUMN `viptext`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `vipvalue`;
ALTER TABLE `fixture_conf_vipfunctionpoint` MODIFY COLUMN `content`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '说明' AFTER `viptext`;
ALTER TABLE `fixture_conf_vipfunctionpoint` DROP COLUMN `vipmechanismid`;
#授权
ALTER TABLE `fixture_small_program` MODIFY COLUMN `sourcecode`  tinyint(1) NULL DEFAULT NULL COMMENT '1审核成功 0代码提交失败 2.审核中  3.审核失败' AFTER `uploadcode`;
#用户
ALTER TABLE `fixture_user` MODIFY COLUMN `faceimg`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '头像' AFTER `resume`;
SET FOREIGN_KEY_CHECKS=1;

-- ----------------------------
-- Records of fixture_data_vipmechanism
-- ----------------------------
INSERT INTO `fixture_data_vipmechanism` VALUES ('1', '标准版', '1', '2018-06-25 15:36:42');
INSERT INTO `fixture_data_vipmechanism` VALUES ('2', '专业版', '1', '2018-06-25 15:36:44');
-- ----------------------------
-- Records of fixture_conf_vipfunctionpoint
-- ----------------------------
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('1', 'vip_max_site', '2', '2个', '0', '不限', '创建工地个数', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('2', 'vip_dynamic', '2', '图文+VR', '2', '图文+VR+小视频', '发布工地动态', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('3', 'vip_activity', '2', '每月2条', '0', '不限', '发布促销活动', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('4', 'vip_participatory', '0', '无', '1', '有', '活动参与方式', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('5', 'vip_appointment', '1', '每月一条', '1', '有', '客户预约', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('6', 'vip_has_luck', '1', '有', '1', '有', '抽奖活动', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('7', 'vip_has_freeoffer', '1', '有', '1', '有', '免费报价', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('8', 'vip_has_message', '1', '有', '1', '有', '在线咨询', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('9', 'vip_has_consultation', '1', '有', '1', '有', '消息提醒', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('10', 'vip_has_visit_site', '1', '有', '1', '有', '预约参观', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('11', 'vip_has_inviting_team_members', '1', '有', '1', '有', '邀请团队成员', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('12', 'vip_has_bussiness_comment', '1', '有', '1', '有', '业务评价', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('13', 'vip_has_share_more', '1', '有', '1', '有', '多渠道分享', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('14', 'vip_has_add_store', '1', '有', '1', '有', '新增门店', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('15', 'vip_has_add_admin', '0', '无', '1', '有', '新增用户', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('16', 'vip_has_role', '0', '有', '1', '有', '用户角色', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('17', 'vip_has_auth', '0', '有', '1', '有', '角色操作权限', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('18', 'vip_has_look', '0', '有', '1', '有', '角色视野权限', '1', null);
INSERT INTO `fixture_conf_vipfunctionpoint` VALUES ('19', 'vip_has_charts', '1', '简单数据分析', '1', '活动效果分析、客户转化率分析、渠道分析等更详细的数据分析、主流业务增长', '数据分析', '1', null);
