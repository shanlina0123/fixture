CREATE TABLE `fixture_site_evaluate` (
`id`  int(11) UNSIGNED ZEROFILL NOT NULL ,
`companyid`  int(11) NOT NULL COMMENT '公司id' ,
`siteid`  int(11) NOT NULL COMMENT '工地ID' ,
`userid`  int(11) NOT NULL COMMENT '用户id' ,
`sitestageid`  int(11) NULL DEFAULT NULL COMMENT '工地阶段id' ,
`sitestagename`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '工地阶段名称' ,
`score`  tinyint(1) NULL DEFAULT NULL COMMENT '评分 1-5分。最小1分' ,
`content`  text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '评论内容' ,
`status`  tinyint(1) NULL DEFAULT NULL COMMENT '1.已邀请了业主 2.还未邀请' ,
`created_at`  datetime NULL DEFAULT NULL ,
`updated_at`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci
ROW_FORMAT=Compact
;
