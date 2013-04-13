
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `findnimei`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `historyscore`
-- 

CREATE TABLE `historyscore` (
  `historyscore_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `level` int(10) unsigned NOT NULL,
  `use_time` int(11) default NULL,
  `money` int(11) default NULL,
  PRIMARY KEY  (`historyscore_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `historyscore`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `step`
-- 

CREATE TABLE `step` (
  `step_id` int(10) unsigned NOT NULL auto_increment,
  `step_name` varchar(40) default NULL,
  `main_word` varchar(20) default NULL,
  `key_word` varchar(20) default NULL,
  `present_num` int(11) default NULL,
  `how_long` int(11) default NULL,
  `playment` int(11) default NULL,
  `result_name` varchar(40) default NULL,
  PRIMARY KEY  (`step_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=9;

-- 
-- 导出表中的数据 `step`
-- 

INSERT INTO `step` VALUES (1, '冰肌玉骨', '亮', '壳', 4, 60, 10, '瞎子');
INSERT INTO `step` VALUES (2, '风姿绰约', '免', '兔', 4, 60, 20, '近视眼');
INSERT INTO `step` VALUES (3, '环肥燕瘦', '呜', '鸣', 4, 60, 30, '大眼睛');
INSERT INTO `step` VALUES (4, '沉鱼落雁', '竞', '竟', 3, 50, 40, '炯炯有神');
INSERT INTO `step` VALUES (5, '闭月羞花', '束', '柬', 3, 50, 50, '监视器');
INSERT INTO `step` VALUES (6, '皓齿明眸', '已', '己', 2, 40, 60, '显微镜');
INSERT INTO `step` VALUES (7, '惊鸿艳影', '赢', '嬴', 2, 40, 70, '望远镜');
INSERT INTO `step` VALUES (8, '一笑倾城', '士', '土', 4, 30, 80, '火眼金睛');

-- --------------------------------------------------------

-- 
-- 表的结构 `user`
-- 

CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `open_id` varchar(40) default NULL,
  `current_level` int(10) unsigned NOT NULL,
  `moneynum` int(11) default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `user`
-- 

