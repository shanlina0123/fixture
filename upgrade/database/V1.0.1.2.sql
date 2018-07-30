#促销活动 - 修改字段
ALTER TABLE `fixture_activity` MODIFY COLUMN `participatoryid`  int(11) NULL DEFAULT 4 COMMENT '活动参与方式id ' AFTER `cityid`;
#促销活动 - 新增字段
ALTER TABLE `fixture_activity` ADD COLUMN `bgurl`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '封面图' AFTER `title`;
#促销活动 - 新增字段
ALTER TABLE `fixture_activity` ADD COLUMN `mainurl`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容图' AFTER `bgurl`;
#促销活动 - 新增字段
ALTER TABLE `fixture_activity` ADD COLUMN `isonline`  tinyint(1) NULL DEFAULT 1 COMMENT '是否公开 默认1  1显示  0不显示' AFTER `content`;
#促销活动 - 新增字段
ALTER TABLE `fixture_activity` ADD COLUMN `updated_at`  datetime NULL DEFAULT NULL COMMENT '更新时间' AFTER `created_at`;
#促销活动 - 新增字段
ALTER TABLE `fixture_activity` ADD COLUMN `startdate`  datetime NULL DEFAULT NULL COMMENT '开始时间' AFTER `title`;
#促销活动 - 新增字段
ALTER TABLE `fixture_activity` ADD COLUMN `enddate`  datetime NULL DEFAULT NULL COMMENT '结束时间' AFTER `startdate`;
#促销活动 - 删除字段
ALTER TABLE `fixture_activity` DROP COLUMN `createuserid`;
#促销活动 - 删除字段
ALTER TABLE `fixture_activity` DROP COLUMN `showurl`;
#促销活动 - 删除字段
ALTER TABLE `fixture_activity` DROP COLUMN `isopen`;
#促销活动 - 删除字段
ALTER TABLE `fixture_activity` DROP COLUMN `status`;
#业主评价 - 新建表
CREATE TABLE `fixture_site_evaluate` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`companyid`  int(11) NOT NULL COMMENT '公司id' ,
`siteid`  int(11) NOT NULL COMMENT '工地ID' ,
`userid`  int(11) NOT NULL COMMENT '用户id' ,
`sitestageid`  int(11) NULL DEFAULT NULL COMMENT '工地阶段id' ,
`sitestagename`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '工地阶段名称' ,
`score`  tinyint(1) NULL DEFAULT NULL COMMENT '评分 1-5分。最小1分' ,
`content`  text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '评论内容' ,
`created_at`  datetime NULL DEFAULT NULL ,
`updated_at`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci
ROW_FORMAT=Compact;
#邀请业主 - 新增字段
ALTER TABLE `fixture_site_invitation` ADD COLUMN `isowner`  tinyint(4) NULL DEFAULT 0 COMMENT '是否业主 0非业主 1业主' AFTER `participantid`;
#屏蔽部分vip功能
UPDATE  `fixture_conf_vipfunctionpoint` SET `status`=0  WHERE  id in (3,4,19);
UPDATE  `fixture_conf_vipfunctionpoint` SET viptext="不限" WHERE  id=5;


CREATE TABLE `fixture_log_operation` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`uid`  int(11) NULL DEFAULT NULL ,
`path`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL ,
`method`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL ,
`ip`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL ,
`sql`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL ,
`input`  text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL ,
`created_at`  datetime NULL DEFAULT NULL ,
`updated_at`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci
ROW_FORMAT=Compact
;
#抽奖活动 - 新增字段
ALTER TABLE `fixture_activity_lucky` ADD COLUMN `advurl`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '广告位' AFTER `sharetitle`;
#促销活动  - 图片
DROP TABLE `fixture_activity_images`;
#促销活动 - 邀请的促销
DROP TABLE `fixture_activity_inrecord`;
#权限功能 - 修改数据
UPDATE `fixture_filter_function` SET sort=2 WHERE id=101;
#权限功能 - 新增数据
INSERT INTO `fixture_filter_function` VALUES ('102', '34800fa0914c11e89a1594de807e34a0', '促销活动', '1', '1', '1', '促销活动', '2', 'ActivityController', 'activity-index', '1', '2018-07-27 11:21:51');

#权限功能 - 过滤已有数据新增数据
DROP PROCEDURE IF EXISTS pro_actrole_function;
delimiter //
CREATE PROCEDURE pro_actrole_function()
BEGIN
  DECLARE strRoleid int;
  DECLARE strIslook int;
  DECLARE stop int default 0;
  DECLARE cur cursor for(
		SELECT roleid,islook FROM `fixture_filter_role_function` WHERE functionid=1 and roleid not in (
			SELECT roleid FROM `fixture_filter_role_function` WHERE functionid=102 GROUP BY roleid
		) GROUP BY roleid
	);
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET stop = null;
  OPEN cur;
		FETCH cur INTO strRoleid,strIslook;
		WHILE (stop is not null)DO
		INSERT INTO `fixture_filter_role_function` VALUES ('', REPLACE(UUID(),"-",""), strRoleid, '102', strIslook, now());
		FETCH cur INTO strRoleid,strIslook;
    END WHILE;
	CLOSE cur;
END;//
delimiter ;
call pro_actrole_function();
DROP PROCEDURE IF EXISTS pro_actrole_function;
#邀请的成员 - 新增字段
ALTER TABLE `fixture_site_invitation` ADD COLUMN `positionid`  int(11) NULL DEFAULT 0 COMMENT '职位id' AFTER `siteid`;
#邀请的成员 - 新增字段
ALTER TABLE `fixture_site_invitation` ADD COLUMN `code`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邀请成员对应的code码，只能使用一次' AFTER `joinuserid`;
#小程序绑定 - 删除字段
ALTER TABLE `fixture_small_program` DROP COLUMN `seturl`;
#系统配置 - 删除
DROP TABLE `fixture_conf_sys`;
#删除之前同步权限存储过程
DROP PROCEDURE `role_function`;
#工地成员 -  删除字段
ALTER TABLE `fixture_site_invitation` DROP COLUMN `participantid`;
#公司成员 -  删除字段
DROP TABLE `fixture_company_participant`;

--  已同步线上