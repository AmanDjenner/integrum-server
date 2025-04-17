tee mysql-integrum-update-1.5.0.txt
DROP TRIGGER mapsatel.`hierarchy_before_insert`;

CREATE DATABASE `essential` /*!40100 COLLATE 'utf8mb4_unicode_ci' */;
RENAME TABLE `mapsatel`.`camera` TO `essential`.`camera`, `mapsatel`.`camera_geom` TO `essential`.`camera_geom`, `mapsatel`.`datasource` TO `essential`.`datasource`, `mapsatel`.`hierarchy` TO `essential`.`hierarchy`, `mapsatel`.`layer_kind` TO `essential`.`layer_kind`, `mapsatel`.`map` TO `essential`.`map`, `mapsatel`.`map_geom` TO `essential`.`map_geom`, `mapsatel`.`map_layer` TO `essential`.`map_layer`;

DROP DATABASE `mapsatel`;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE DEFINER=`root`@`localhost` TRIGGER `essential`.`hierarchy_before_insert` BEFORE INSERT ON `hierarchy` FOR EACH ROW begin
if new.query_idx is null or new.query_idx = '' then 
set new.query_idx=concat('1.',new.id);
end if;
end//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


GRANT SELECT, EXECUTE, SHOW VIEW, ALTER, ALTER ROUTINE, CREATE, CREATE ROUTINE, CREATE TEMPORARY TABLES, CREATE VIEW, DELETE, DROP, EVENT, INDEX, INSERT, REFERENCES, TRIGGER, UPDATE, LOCK TABLES  ON `essential`.* TO 'mapsatel'@'%';

USE `essential`;
ALTER TABLE `layer_kind` DROP INDEX `uk_layer_kind_layer_code_name`;
ALTER TABLE `layer_kind` ADD UNIQUE INDEX `uk_layer_kind_layer_code_name` (`layer_code`, `name`);

ALTER TABLE `map_geom`
	ADD COLUMN `color` INT UNSIGNED NULL AFTER `id_attr`;

ALTER TABLE `map`
	ADD COLUMN `hidden` TINYINT NULL DEFAULT '0' AFTER `lockedby`;
	
USE `integrum`;

DROP VIEW IF EXISTS `integra_event_users_list`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `integra_event_users_list` AS select `h`.`query_idx` AS `query_idx`,`iu`.`id_integra` AS `id_integra`,(case when isnull(`u`.`name`) then 'I' else 'U' end) AS `user_type`,(case when isnull(`u`.`name`) then `iu`.`id` else `iu`.`id_user` end) AS `user_id`,(case when isnull(`u`.`name`) then concat(`iu`.`name`,'[',`i`.`name`,']') else `u`.`name` end) AS `name`,`iu`.`integra_idx` AS `integra_idx` from `integrum`.`integra_user` `iu` left join `integrum`.`users` `u` on `u`.`id` = `iu`.`id_user` join `integrum`.`integra` `i` on `iu`.`id_integra` = `i`.`id` join `essential`.`hierarchy` `h` on `i`.`hierarchy_qry_idx` = `h`.`query_idx` 
union all
select `h`.`query_idx` AS `query_idx`,`i`.`id` AS `id_integra`,'S' AS `user_type`,255 AS `user_id`,'Service' AS `name`,255 AS `integra_idx` from `integrum`.`integra` `i` join `essential`.`hierarchy` `h` on `i`.`hierarchy_qry_idx` = `h`.`query_idx`;


-- Dumping structure for trigger integrum.integra_event_before_insert
DROP TRIGGER `integra_event_before_insert`;
-- Dumping structure for trigger integrum.integra_after_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `integra_after_update` AFTER UPDATE ON `integra` FOR EACH ROW BEGIN
 if (NEW.hierarchy_qry_idx!=OLD.hierarchy_qry_idx) then
   update integra_event e set e.hierarchy_qry_idx = NEW.hierarchy_qry_idx where e.id_integra=NEW.id;
 end if; 
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;



ALTER TABLE `integra_evnt_descr`
	ADD COLUMN `class_` INT UNSIGNED NULL AFTER `long_desc`;

delete from integra_evnt_descr  where code<0;
delete from integra_event where eventcode<0;
update integra_evnt_descr d join integra_event e on e.eventcode=d.code
set d.class_=e.class_;
update integra_evnt_descr d set d.class_=130 where d.code>60000;
delete from integra_evnt_descr  where class_ is null;
commit;

ALTER TABLE `integra_evnt_descr`
	ALTER `class_` DROP DEFAULT;
ALTER TABLE `integra_evnt_descr`
	CHANGE COLUMN `class_` `class_` INT(10) UNSIGNED NOT NULL AFTER `long_desc`;
	
update integra_event e JOIN integra i ON (e.id_integra=i.id) set e.hierarchy_qry_idx = i.hierarchy_qry_idx where e.id_integra in (select id from integra);
	
-- Dumping structure for trigger integrum.integra_after_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `integra_after_update` AFTER UPDATE ON `integra` FOR EACH ROW BEGIN
if (NEW.hierarchy_qry_idx!=OLD.hierarchy_qry_idx) then
  update integra_event e set e.hierarchy_qry_idx = NEW.hierarchy_qry_idx where e.id_integra=NEW.id;
end if; 
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

CREATE TABLE `integra_output_state` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`active` TINYINT(4) NULL DEFAULT '1',
	`state_` INT(10) UNSIGNED NULL DEFAULT '1',
	`id_output` INT(11) UNSIGNED NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_integra_detail_state_output` (`id_output`),
	CONSTRAINT `fk_integra_detail_state_output` FOREIGN KEY (`id_output`) REFERENCES `integra_output` (`id`)
)
ENGINE=InnoDB
ROW_FORMAT=COMPACT
AUTO_INCREMENT=1
;

CREATE TABLE `integra_geom` (
	`gid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_map` INT(11) UNSIGNED NOT NULL,
	`id_attr` INT(11) NULL DEFAULT NULL,
	`geom` POLYGON NOT NULL,
	PRIMARY KEY (`gid`),
	UNIQUE INDEX `uk_attr_integra_geom` (`id_map`, `id_attr`),
	INDEX `fk_attr_integra_geom` (`id_attr`),
	CONSTRAINT `fk_attr_integra_geom` FOREIGN KEY (`id_attr`) REFERENCES `integra` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
)
ENGINE=InnoDB;

CREATE TABLE `integra_event_comment` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_event` BIGINT(20) UNSIGNED NOT NULL,
	`date` DATETIME NOT NULL,
	`id_user` INT(11) NOT NULL,
	`event_comment` VARCHAR(5000) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `Index 3` (`id_event`),
	INDEX `integr_event_commend_user_id` (`id_user`),
	CONSTRAINT `integr_event_commend_user_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE
)
ENGINE=InnoDB;


-- Dumping structure for table integrum.perm_permission
CREATE TABLE IF NOT EXISTS `perm_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `group_` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
ALTER TABLE `perm_permission`
	CHANGE COLUMN `group` `group_` VARCHAR(15) NOT NULL AFTER `code`;

-- Dumping data for table integrum.perm_permission: ~31 rows (approximately)
/*!40000 ALTER TABLE `perm_permission` DISABLE KEYS */;
INSERT IGNORE INTO `perm_permission` (`id`, `code`, `group_`) VALUES
	(1, 'MANREGION', 'REGION'),
	(4, 'CREUSER', 'USER'),
	(5, 'EDTUSER', 'USER'),
	(6, 'DELUSER', 'USER'),
	(7, 'MANPROFILE', 'USER'), 
	(8, 'NOPROFILE', 'USERINTEGRA'), 
	(10, 'MANUSERAPPL', 'USERAPPL'),
	(13, 'CREUSERINTEGRA', 'USERINTEGRA'), 
	(14, 'EDTUSERINTEGRA', 'USERINTEGRA'), 
	(15, 'DELUSERINTEGRA', 'USERINTEGRA'), 
	(16, 'SELUSERINTEGRA', 'USERINTEGRA'),
	(17, 'CREINTEGRA', 'INTEGRA'),
	(18, 'EDTINTEGRA', 'INTEGRA'),
	(19, 'DELINTEGRA', 'INTEGRA'),
	(20, 'SELINTEGRA', 'INTEGRA'),
	(21, 'EXPINTEGRA', 'INTEGRA'),
	(23, 'MANINTEGRA', 'INTEGRA'),
	(24, 'SELEVENTS', 'EVENTS'),
	(25, 'COMLATEREVENTS', 'EVENTS'),
	(26, 'COMEVENTS', 'DASHBOARD'), 
	(27, 'SELDASHBOARD', 'DASHBOARD'), 
	(28, 'LICMANAGE', 'LICENSE'),
	(29, 'EDTMAP', 'MAP'), 
	(30, 'SELUSER', 'USER'),
	(31, 'ACTDASHBOARD', 'DASHBOARD'), 
	(32, 'MANROLES', 'USER');
/*!40000 ALTER TABLE `perm_permission` ENABLE KEYS */;



-- Dumping structure for table integrum.perm_role
CREATE TABLE IF NOT EXISTS `perm_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table integrum.perm_role: ~7 rows (approximately)
/*!40000 ALTER TABLE `perm_role` DISABLE KEYS */;
INSERT IGNORE INTO `perm_role` (`id`, `name`) VALUES
	(1, 'Administator'),
	(2, 'Handling'),
	(4, 'Events handling'), ##BASIC_HERE
	(3, 'Read only');
/*!40000 ALTER TABLE `perm_role` ENABLE KEYS */;


-- Dumping structure for table integrum.perm_role_permission
CREATE TABLE IF NOT EXISTS `perm_role_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_role` int(10) unsigned NOT NULL,
  `id_permission` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_perm_role_permission` (`id_role`,`id_permission`),
  KEY `perm_role_permission_fk2` (`id_permission`),
  CONSTRAINT `perm_role_permission_fk1` FOREIGN KEY (`id_role`) REFERENCES `perm_role` (`id`),
  CONSTRAINT `perm_role_permission_fk2` FOREIGN KEY (`id_permission`) REFERENCES `perm_permission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- Dumping data for table integrum.perm_role_permission: ~62 rows (approximately)
/*!40000 ALTER TABLE `perm_role_permission` DISABLE KEYS */;
INSERT IGNORE INTO `perm_role_permission` (`id`, `id_role`, `id_permission`) VALUES
	(1, 1, 1),
	(4, 1, 4),
	(5, 1, 5),
	(6, 1, 6),
	(7, 1, 7), 
	(8, 1, 8), 
	(9, 1, 10),
	(13, 1, 13), 
	(14, 1, 14), 
	(15, 1, 15), 
	(16, 1, 16),
	(17, 1, 17),
	(18, 1, 18),
	(19, 1, 19),
	(20, 1, 20),
	(21, 1, 21),
	(23, 1, 23),
	(24, 1, 24),
	(25, 1, 25),
	(26, 1, 26), 
	(27, 1, 27), 
	(28, 1, 28),
	(29, 1, 29), 
	(80, 1, 30),
	(81, 1, 31), 
	(84, 1, 32),
	(38, 2, 7), 
	(39, 2, 8), 
	(47, 2, 16),
	(51, 2, 20),
	(52, 2, 21),
	(54, 2, 23),
	(55, 2, 24),
	(56, 2, 25),
	(57, 2, 26), 
	(58, 2, 27), 
	(79, 2, 30),
	(82, 2, 31), 
	(66, 3, 16),
	(67, 3, 20),
	(71, 3, 24),
	(74, 3, 27), 
	(85, 4, 26), 
	(78, 3, 30);

update perm_permission set code = 'MANUSERAPPL' where id =10;
delete from perm_role_permission where id_permission in (11,12);
delete from perm_permission where id in (11,12);
    
CREATE TABLE `users_integrum` (
	`id_user` INT(11) NOT NULL,
	`integra_def_name` VARCHAR(64) NULL DEFAULT NULL,
	`code` CHAR(12) NULL DEFAULT NULL,
	`card` CHAR(10) NULL DEFAULT NULL,
	`dallas` CHAR(12) NULL DEFAULT NULL,
	`modify_time` TIMESTAMP NULL DEFAULT NULL,
	`modify_user` INT(11) NULL DEFAULT NULL,
	`modify_removed` TINYINT(1) NOT NULL DEFAULT '0',
	`versionid` INT(11) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id_user`),
	UNIQUE INDEX `uk_kodsatel2group` (`code`),
	CONSTRAINT `fk_users_integrum_users_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
)
ENGINE=InnoDB
ROW_FORMAT=COMPACT;
CREATE TABLE IF NOT EXISTS `user_application_settings` (
  `id_user` int(11) NOT NULL,
  `access_hierarchy_qry_idx` varchar(100) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `fk_users_appliaction_group` (`access_hierarchy_qry_idx`)
)
ENGINE=InnoDB
ROW_FORMAT=COMPACT;

ALTER TABLE `user_application_settings`
	ADD CONSTRAINT `user_application_settings_ibfk_1` FOREIGN KEY (`access_hierarchy_qry_idx`) REFERENCES `essential`.`hierarchy` (`query_idx`) ON UPDATE CASCADE;
ALTER TABLE `user_application_settings`
	ADD CONSTRAINT `user_application_settings_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user_application` (`id_user`) ON UPDATE CASCADE;

insert into users_integrum(`id_user`, `integra_def_name`, `code`, `card`, `dallas`, `modify_time`, `modify_user`, `modify_removed`, `versionid`)
select `id`, `integra_def_name`, ui.`code`, ui.`card`, ui.`dallas`, ui.`modify_time`, ui.`modify_user`, ui.`modify_removed`, ui.`versionid` from users ui
where ui.integra_def_name is not null or ui.code is not null or ui.dallas is not null or ui.card is not null ;

ALTER TABLE `users`
	DROP COLUMN `integra_def_name`,
	DROP COLUMN `code`,
	DROP COLUMN `card`,
	DROP COLUMN `dallas`;

insert into user_application_settings (`id_user`, `access_hierarchy_qry_idx`)
select `id_user`, `access_hierarchy_qry_idx` from user_application;

CREATE TABLE IF NOT EXISTS `user_application_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_role` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_application_role_uk` (`id_user`,`id_role`),
  KEY `user_application_role_ibfk_2` (`id_role`),
  KEY `user_application_role_ibfk_1` (`id_user`),
  CONSTRAINT `user_application_role_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user_application` (`id_user`) ON UPDATE CASCADE,
  CONSTRAINT `user_application_role_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `perm_role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

insert into user_application_role (`id_user`, `id_role`)
select `id_user`, case `role` when 2 then 1 when 1 then 2 else 3 end from user_application;


ALTER TABLE `user_application`
	DROP FOREIGN KEY `fk_users_appliaction_group`;
ALTER TABLE `user_application`
	DROP COLUMN `role`;
ALTER TABLE `user_application`	
	DROP COLUMN `access_hierarchy_qry_idx`;
ALTER TABLE `user_application`
	ADD COLUMN `locked` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' AFTER `password`;

ALTER TABLE `integra_state`
	ADD COLUMN `is_plus` INT(5) NULL DEFAULT NULL AFTER `type`;

USE `integrum`;
REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES
	(1, 'db_version', '1.5.0');

notee
exit
