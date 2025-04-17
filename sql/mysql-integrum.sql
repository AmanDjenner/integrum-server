-- --------------------------------------------------------
-- Host:                         192.168.1.11
-- Server version:               5.5.40-0+wheezy1 - (Debian)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------
tee mysql-integrum.txt

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for integrum
CREATE DATABASE IF NOT EXISTS `integrum` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `integrum`;


-- Dumping structure for table integrum.authority_profile
CREATE TABLE IF NOT EXISTS `authority_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `usertype` tinyint(4) unsigned NOT NULL,
  `authority_level` BIGINT(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table integrum.global_state
CREATE TABLE IF NOT EXISTS `global_state` (
  `id` int(11) NOT NULL DEFAULT '0',
  `commit_in_progress` int(11) DEFAULT NULL,
  `backup_in_progress` int(11) DEFAULT NULL,
  `locked_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_global_status_user` (`commit_in_progress`),
  KEY `fk_global_status_lock` (`locked_by`),
  CONSTRAINT `fk_global_state_lock` FOREIGN KEY (`locked_by`) REFERENCES `user_application` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_global_state_user` FOREIGN KEY (`commit_in_progress`) REFERENCES `user_application` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra
CREATE TABLE IF NOT EXISTS `integra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ethm` int(11) DEFAULT NULL,
  `online` TINYINT(1) NOT NULL DEFAULT '0',
  `hierarchy_qry_idx` varchar(100) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `servicecode` varchar(12) DEFAULT NULL,
  `integraid` varchar(12) DEFAULT NULL,
  `dloadid` varchar(12) DEFAULT NULL,
  `guardid` varchar(12) DEFAULT NULL,
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  `versionid` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_integra_ethm` (`id_ethm`),
  KEY `uk_integra_name` (`hierarchy_qry_idx`,`name`),
  KEY `fk_integra_group` (`hierarchy_qry_idx`),
  CONSTRAINT `fk_integra_ethm` FOREIGN KEY (`id_ethm`) REFERENCES `integra_ethm` (`id`),
  CONSTRAINT `fk_integra_group` FOREIGN KEY (`hierarchy_qry_idx`) REFERENCES `essential`.`hierarchy` (`query_idx`) ON UPDATE CASCADE
) ENGINE=InnoDB ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra_crc
CREATE TABLE IF NOT EXISTS `integra_crc` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_integra` int(11) NOT NULL,
  `typ` tinyint(3) unsigned NOT NULL,
  `crc` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_integra_crc_typ` (`id_integra`,`typ`),
  KEY `fk_integra_crc_integra` (`id_integra`),
  CONSTRAINT `fk_integra_crc_integra` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra_ethm
CREATE TABLE IF NOT EXISTS `integra_ethm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_number` VARCHAR(50) NULL DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `port` smallint(6) unsigned  DEFAULT NULL,
  `mac` VARCHAR(20) NULL DEFAULT NULL,
  `dloadport` smallint(6) unsigned DEFAULT NULL,
  `dloadkey` varchar(12) DEFAULT NULL,
  `guardkey` varchar(12) DEFAULT NULL,
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  `versionid` int(11) NOT NULL DEFAULT '1',
  `hierarchy_qry_idx` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_integra_ethm_mac` (`mac`),
  KEY `fk_integra_ethm_hierarchy` (`hierarchy_qry_idx`),
  CONSTRAINT `fk_integra_ethm_hierarchy` FOREIGN KEY (`hierarchy_qry_idx`) REFERENCES `essential`.`hierarchy` (`query_idx`) ON UPDATE CASCADE
) ENGINE=InnoDB ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra_ethm_state
CREATE TABLE IF NOT EXISTS `integra_ethm_state` (
  `id` int(11) NOT NULL,
  `version` int(4) DEFAULT NULL,
  `version_date` varchar(10) DEFAULT NULL,
  `mac` VARCHAR(20) NULL DEFAULT NULL,
  `version_notsupported` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_integra_ethm_ethm` FOREIGN KEY (`id`) REFERENCES `integra_ethm` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

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


-- Dumping structure for table integrum.perm_permission
CREATE TABLE IF NOT EXISTS `perm_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `group_` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
	UNIQUE INDEX `perm_permission_uk` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- Dumping structure for table integrum.perm_role
CREATE TABLE IF NOT EXISTS `perm_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;


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

-- Dumping structure for table integrum.integra_event
CREATE TABLE IF NOT EXISTS `integra_event` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_integra` int(11) DEFAULT NULL,
  `date_` datetime DEFAULT NULL,
  `class_` int(11) unsigned DEFAULT NULL,
  `eventcode` int(10) DEFAULT NULL,
  `monitoring_state` tinyint(4) unsigned DEFAULT NULL,
  `partition_number` int(11) unsigned DEFAULT NULL,
  `object_number` int(11) unsigned DEFAULT NULL,
  `source_number` int(11) unsigned DEFAULT NULL,
  `is_restore` tinyint(4) unsigned DEFAULT NULL,
  `partition_name` varchar(50) DEFAULT NULL,
  `object_name` varchar(50) DEFAULT NULL,
  `zone_name` varchar(50) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_ctrl_number` tinyint(4) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `address_cycle` int(11) NOT NULL DEFAULT '0',
  `address` int(11) NOT NULL,
  `id_parent` int(11) unsigned DEFAULT NULL,
  `hierarchy_qry_idx` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_integra_event` (`id_integra`),
  KEY `fk_integra_event_user` (`id_user`),
  KEY `uk_integra_event_address` (`id_integra`,`address_cycle`,`address`),
  KEY `fk_integra_event_hierarchy` (`hierarchy_qry_idx`),
  CONSTRAINT `fk_integra_event` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`),
  CONSTRAINT `fk_integra_event_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for trigger integrum.integra_event_before_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `integra_after_update` AFTER UPDATE ON `integra` FOR EACH ROW BEGIN
if (NEW.hierarchy_qry_idx!=OLD.hierarchy_qry_idx) then
  update integra_event e set e.hierarchy_qry_idx = NEW.hierarchy_qry_idx where e.id_integra=NEW.id;
end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for view integrum.integra_event_users_list
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `integra_event_users_list` (
	`query_idx` VARCHAR(100) NOT NULL,
	`id_integra` INT(11) NOT NULL,
	`user_type` VARCHAR(1) NOT NULL,
	`user_id` BIGINT(11) NULL,
	`name` VARCHAR(198) NULL,
	`integra_idx` SMALLINT(5) UNSIGNED NOT NULL
) ENGINE=MyISAM;


-- Dumping structure for table integrum.integra_evnt_descr
CREATE TABLE IF NOT EXISTS `integra_evnt_descr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) NOT NULL DEFAULT 'PL',
  `long_desc` tinyint(1) NOT NULL DEFAULT '0',
  `class_` INT UNSIGNED NOT NULL,
  `code` int(11) NOT NULL,
  `type1` int(11) unsigned NOT NULL,
  `type2` int(11) unsigned NOT NULL,
  `text` varchar(46) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `opis_unique` (`code`,`long_desc`,`type1`,`type2`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

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

-- Dumping structure for table integrum.integra_object
CREATE TABLE IF NOT EXISTS `integra_object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_integra` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `integra_idx` smallint(5) unsigned NOT NULL,
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_integra_zone_integra` (`id_integra`),
  INDEX `integra_object_idx` (`id_integra`,`id`),
  CONSTRAINT `fk_integra_object_integra` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`)
) ENGINE=InnoDB;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra_partition
CREATE TABLE IF NOT EXISTS `integra_partition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_integra` int(11) NOT NULL,
  `id_object` int(11) DEFAULT NULL,
  `name` varchar(16) NOT NULL,
  `integra_idx` smallint(5) unsigned NOT NULL,
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_integra_partition_integra_idx` (`id_integra`,`integra_idx`),
  KEY `fk_integra_partition_object` (`id_object`),
  KEY `fk_integra_partition_integra` (`id_integra`),
  CONSTRAINT `fk_integra_partition_integra` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`),
  CONSTRAINT `fk_integra_partition_object` FOREIGN KEY (`id_object`) REFERENCES `integra_object` (`id`)
) ENGINE=InnoDB;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra_partition_geom
CREATE TABLE IF NOT EXISTS `integra_partition_geom` (
  `gid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_map` int(11) unsigned NOT NULL,
  `id_attr` int(11) DEFAULT NULL,
  `geom` polygon NOT NULL,
  PRIMARY KEY (`gid`),
  KEY `fk_attr_integra_partition_geom` (`id_attr`),
  CONSTRAINT `fk_attr_integra_partition_geom` FOREIGN KEY (`id_attr`) REFERENCES `integra_partition` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra_state
CREATE TABLE IF NOT EXISTS `integra_state` (
  `id_integra` int(11) NOT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `status_code` TINYINT(3) NULL DEFAULT NULL,
  `progress` INT(11) NULL DEFAULT '0',
  `version` INT(4) NULL DEFAULT NULL,
  `version_date` CHAR(10) NULL DEFAULT NULL,
  `type` INT(5) NULL DEFAULT NULL,
  `is_plus` INT(5) NULL DEFAULT NULL,
  `version_notsupported` tinyint(1) NOT NULL DEFAULT '0',
  `dload_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `state_alarm` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
  `state_trouble` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
  `state_arm` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
  `state_service` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
  `state_group_a` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
  `state_group_b` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id_integra`),
  UNIQUE INDEX `fk_integra_state_integra` (`id_integra`),
  CONSTRAINT `fk_integra_state_integra` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for view integrum.integra_state_by_hierarchy
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `integra_state_by_hierarchy` (
	`hierarchy_qry_idx` VARCHAR(100) NOT NULL,
	`alarm_count` DECIMAL(23,0) NULL,
	`trouble_count` DECIMAL(23,0) NULL,
	`service_count` DECIMAL(23,0) NULL,
	`armed_count` DECIMAL(23,0) NULL,
	`offline_count` DECIMAL(23,0) NULL,
	`total` BIGINT(21) NOT NULL,
	`ok` INT(0) NULL
) ENGINE=MyISAM;


-- Dumping structure for table integrum.integra_user
CREATE TABLE IF NOT EXISTS `integra_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_integra` int(11) NOT NULL,
  `id_object` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `archived` int(11) DEFAULT NULL,
  `integra_idx` smallint(5) unsigned NOT NULL,
  `control_number` int(11) DEFAULT NULL,
  `name` varchar(16) NOT NULL,
  `type` tinyint(4) unsigned NOT NULL,
  `valid_time` smallint(6) DEFAULT NULL,
  `code` CHAR(12) NULL,
  `tele_code` CHAR(12) DEFAULT NULL,
  `partition_idx` bigint signed NOT NULL,
  `authority_level` bigint(20) unsigned NOT NULL,
  `card` char(10) DEFAULT NULL,
  `dallas` char(12) DEFAULT NULL,
  `uschema` TINYINT UNSIGNED NULL DEFAULT NULL,
  `cnt` TINYINT UNSIGNED NULL DEFAULT NULL,
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  `versionid` int(11) NOT NULL DEFAULT '1',
  `hierarchy_qry_idx` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_integra_user_idx` (`id_integra`,`integra_idx`),
  UNIQUE KEY `uk_integra_user_user` (`id_integra`,`id_user`),
  KEY `fk_integra_detail_object` (`id_object`),
  KEY `fk_integra_detail_integra` (`id_integra`),
  KEY `fk_integra_users_user` (`id_user`),
  KEY `fk_integra_users_object` (`id_integra`,`id_object`),
  CONSTRAINT `fk_integra_users_integra` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`),
  CONSTRAINT `fk_integra_users_object` FOREIGN KEY (`id_integra`, `id_object`) REFERENCES `integra_object` (`id_integra`, `id`),
  CONSTRAINT `fk_integra_users_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra_user_state
CREATE TABLE IF NOT EXISTS `integra_user_state` (
  `id` int(11) NOT NULL,
  `code_change` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Flaga, mĂłwi o koniecznoĹ›Ä‡i zmiany kodu przez uĹĽytkownika',
  `code_changed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Flaga mĂłwi, ĹĽe uĹĽytkonik sam zmieniĹ‚ kod',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_integra_user_state` FOREIGN KEY (`id`) REFERENCES `integra_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra_zone
CREATE TABLE IF NOT EXISTS `integra_zone` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_integra` int(11) DEFAULT NULL,
  `id_partition` int(11) DEFAULT NULL,
  `name` varchar(16) NOT NULL,
  `integra_idx` smallint(5) unsigned NOT NULL,
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_integra_zone_partition_idx` (`id_partition`,`integra_idx`),
  KEY `fk_integra_zone_partition` (`id_partition`),
  KEY `fk_integra_zone_integra` (`id_integra`),
  CONSTRAINT `fk_integra_zone_integra` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`),
  CONSTRAINT `fk_integra_zone_partition` FOREIGN KEY (`id_partition`) REFERENCES `integra_partition` (`id`)
) ENGINE=InnoDB;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra_zone_geom
CREATE TABLE IF NOT EXISTS `integra_zone_geom` (
  `gid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_map` int(11) unsigned NOT NULL,
  `id_attr` int(11) unsigned DEFAULT NULL,
  `geom` POINT NOT NULL,
  `rot` decimal(10,4) unsigned DEFAULT '0.0000',
  `scale` decimal(10,4) unsigned DEFAULT '1.0000',
  `kind` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`gid`),
  KEY `integra_zone_geom_map` (`id_map`),
  KEY `fk_attr_integra_zone_geom` (`id_attr`),
  CONSTRAINT `fk_attr_integra_zone_geom` FOREIGN KEY (`id_attr`) REFERENCES `integra_zone` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

CREATE TABLE `license` (
	`mac` VARCHAR(20) NOT NULL,
	`license` TEXT NOT NULL,
	PRIMARY KEY (`mac`)
)
ENGINE=InnoDB;

-- Dumping structure for table integrum.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_` varchar(50) NOT NULL,
  `value_` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table integrum.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `surname` varchar(64) DEFAULT NULL,
  `forename` varchar(32) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `accounting_number` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  `versionid` int(11) NOT NULL DEFAULT '1',
  `hierarchy_qry_idx` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_users_name` (`name`),
  KEY `fk_users_group` (`hierarchy_qry_idx`),
  CONSTRAINT `fk_users_group` FOREIGN KEY (`hierarchy_qry_idx`) REFERENCES `essential`.`hierarchy` (`query_idx`)ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

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
	CONSTRAINT `fk_users_integrum_users_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE=InnoDB
ROW_FORMAT=COMPACT;

-- Dumping structure for table integrum.user_application
CREATE TABLE IF NOT EXISTS `user_application` (
  `id_user` int(11) NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `locked` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  `versionid` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `uk_users_application_login` (`login`),
  CONSTRAINT `fk_users_application_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB ROW_FORMAT=COMPACT COMMENT=' ';

-- Data exporting was unselected.

CREATE TABLE IF NOT EXISTS `user_application_settings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `grp` INT(11) UNSIGNED NOT NULL,
  `access_hierarchy_qry_idx` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `user_application_setgs_hierarchy_uk` (`id_user`, `grp`, `access_hierarchy_qry_idx`),
  INDEX `user_application_settings_ibfk_1` (`access_hierarchy_qry_idx`),
  CONSTRAINT `user_application_settings_ibfk_1` FOREIGN KEY (`access_hierarchy_qry_idx`) REFERENCES `essential`.`hierarchy` (`query_idx`) ON UPDATE CASCADE,
  CONSTRAINT `user_application_settings_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user_application` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE=InnoDB
ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `user_application_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `grp` INT(11) UNSIGNED NOT NULL,
  `id_role` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_application_role_uk` (`id_user`, `grp`, `id_role`),
  KEY `user_application_role_ibfk_2` (`id_role`),
  KEY `user_application_role_ibfk_1` (`id_user`),
  CONSTRAINT `user_application_role_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user_application` (`id_user`)  ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_application_role_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `perm_role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;



-- Dumping structure for table integrum.user_contact
CREATE TABLE IF NOT EXISTS `user_contact` (
  `id_contact` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `contact_type` smallint(6) NOT NULL DEFAULT '0' COMMENT '0-Phone,1-Email',
  `contact_detail` varchar(150) NOT NULL DEFAULT '0',
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_contact`),
  KEY `ix_contact` (`contact_detail`,`contact_type`),
  KEY `fk_contact_user_id` (`id_user`),
  CONSTRAINT `fk_users_contact_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table integrum.user_photo
CREATE TABLE IF NOT EXISTS `user_photo` (
  `id_user` int(11) NOT NULL,
  `filecontent` mediumblob NOT NULL,
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`),
  CONSTRAINT `fk_users_photo_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for trigger integrum.integra_after_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `integra_after_insert` AFTER INSERT ON `integra` FOR EACH ROW BEGIN
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 0, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 1, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 2, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 3, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 4, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 5, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 6, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 7, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 8, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 9, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 10, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 11, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 12, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 13, 0);
  INSERT INTO integra_crc(id_integra,typ,crc) VALUES(new.id, 14, 0);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;



-- Dumping structure for table integrum.integra_expander
CREATE TABLE `integra_expander` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_integra` INT(11) NOT NULL,
	`name` VARCHAR(16) NOT NULL,
	`integra_idx` SMALLINT(5) UNSIGNED NOT NULL,
	`type` INT(11) NOT NULL,
	`modify_time` TIMESTAMP NULL DEFAULT NULL,
	`modify_user` INT(11) NULL DEFAULT NULL,
	`modify_removed` TINYINT(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `ix_integra_expander_idx` (`id_integra`, `integra_idx`),
	INDEX `fk_integra_expander_integra` (`id_integra`),
	CONSTRAINT `fk_integra_expander_integra` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`)
)
ENGINE=InnoDB
AUTO_INCREMENT=1
;

CREATE TABLE `integra_expander_geom` (
	`gid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_map` INT(11) UNSIGNED NOT NULL,
	`id_attr` INT(11) UNSIGNED NULL DEFAULT NULL,
	`geom` POINT NOT NULL,
	`rot` DECIMAL(10,4) UNSIGNED NULL DEFAULT '0.0000',
	`scale` DECIMAL(10,4) UNSIGNED NULL DEFAULT '1.0000',
	`kind` INT(10) UNSIGNED NULL DEFAULT NULL,
	PRIMARY KEY (`gid`),
	INDEX `integra_expander_geom_map` (`id_map`),
	INDEX `fk_attr_integra_expander_geom` (`id_attr`),
	CONSTRAINT `fk_attr_integra_expander_geom` FOREIGN KEY (`id_attr`) REFERENCES `integra_expander` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;

-- Dumping structure for table integrum.integra_output
CREATE TABLE IF NOT EXISTS `integra_output` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_integra` int(11) DEFAULT NULL,
  `name` varchar(16) NOT NULL,
  `type` INT(10) UNSIGNED NOT NULL,
  `integra_idx` smallint(5) unsigned NOT NULL,
  `modify_time` timestamp NULL DEFAULT NULL,
  `modify_user` int(11) DEFAULT NULL,
  `modify_removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_integra_output_integra_idx` (`id_integra`,`integra_idx`),
  KEY `fk_integra_zone_integra` (`id_integra`),
  CONSTRAINT `fk_integra_output_integra` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table integrum.integra_trouble_state
CREATE TABLE `integra_trouble_state` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_integra` INT(11) NOT NULL,
	`idx` INT(11) NOT NULL DEFAULT '0',
	`is_memory` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
	`txt` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_integra_trouble_state_integra` (`id_integra`),
	CONSTRAINT `fk_integra_trouble_state_integra` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB
AUTO_INCREMENT=1;

-- Data exporting was unselected.


-- Dumping structure for table integrum.integra_output_geom
CREATE TABLE IF NOT EXISTS `integra_output_geom` (
  `gid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_map` int(11) unsigned NOT NULL,
  `id_attr` int(11) unsigned DEFAULT NULL,
  `geom` point NOT NULL,
  `rot` decimal(10,4) unsigned DEFAULT '0.0000',
  `scale` decimal(10,4) unsigned DEFAULT '1.0000',
  `kind` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`gid`),
  KEY `integra_output_geom_map` (`id_map`),
  KEY `fk_attr_integra_output_geom` (`id_attr`),
  CONSTRAINT `fk_attr_integra_output_geom` FOREIGN KEY (`id_attr`) REFERENCES `integra_output` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Zrzut struktury tabela integrum.integra_event_archive
CREATE TABLE IF NOT EXISTS `integra_event_archive` (
  `ARCHIVE_id` varchar(50) DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `id_integra` int(11) DEFAULT NULL,
  `date_` datetime DEFAULT NULL,
  `class_` int(11) unsigned DEFAULT NULL,
  `eventcode` int(10) DEFAULT NULL,
  `monitoring_state` tinyint(4) unsigned DEFAULT NULL,
  `partition_number` int(11) unsigned DEFAULT NULL,
  `object_number` int(11) unsigned DEFAULT NULL,
  `source_number` int(11) unsigned DEFAULT NULL,
  `is_restore` tinyint(4) unsigned DEFAULT NULL,
  `partition_name` varchar(50) DEFAULT NULL,
  `object_name` varchar(50) DEFAULT NULL,
  `zone_name` varchar(50) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_ctrl_number` tinyint(4) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `address_cycle` int(11) NOT NULL DEFAULT '0',
  `address` int(11) NOT NULL,
  `id_parent` int(11) unsigned DEFAULT NULL,
  `hierarchy_qry_idx` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Zrzut struktury tabela integrum.integra_event_comment_archive
CREATE TABLE IF NOT EXISTS `integra_event_comment_archive` (
  `archive_id` varchar(50) NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_event` bigint(20) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `event_comment` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 3` (`id_event`),
  KEY `integr_event_commend_user_id` (`id_user`),
  CONSTRAINT `integra_event_comment_archive_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1;

-- Dumping structure for trigger integrum.user_name_before_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `user_name_before_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
  IF IFNULL(NEW.forename,'EMPTY') != IFNULL(OLD.forename,'EMPTY') AND NEW.name IS NULL THEN
    SET NEW.name=LEFT(CONCAT(IFNULL(OLD.surname,''), ' ', IFNULL(NEW.forename,'')),16);
  ELSEIF IFNULL(NEW.surname,'EMPTY') != IFNULL(OLD.surname,'EMPTY') AND NEW.name IS NULL THEN
    SET NEW.name=LEFT(CONCAT(IFNULL(NEW.surname,''), ' ', IFNULL(OLD.forename,'')),16);
  END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger integrum.integra_ethm_after_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `integra_ethm_after_insert` AFTER INSERT ON `integra_ethm` FOR EACH ROW BEGIN
  INSERT INTO integra_ethm_state(id,version, version_date, version_notsupported,mac)
  VALUES(new.id, 0, null, 0, null);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for function integrum.has_partition
DELIMITER //
CREATE FUNCTION `has_partition`(`partition_idx` INT, `part` INT) RETURNS int(11)
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
  return case when substr(lpad(conv(partition_idx,10,2),32,0),32-part+1,1) ='0' then 0 else 1 end;
END//
DELIMITER ;

-- Dumping structure for view integrum.integra_event_users_list
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `integra_event_users_list`;
DROP VIEW IF EXISTS `integra_event_users_list`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `integra_event_users_list` AS select `h`.`query_idx` AS `query_idx`,`iu`.`id_integra` AS `id_integra`,(case when isnull(`u`.`name`) then 'I' else 'U' end) AS `user_type`,(case when isnull(`u`.`name`) then `iu`.`id` else `iu`.`id_user` end) AS `user_id`,(case when isnull(`u`.`name`) then concat(`iu`.`name`,'[',`i`.`name`,']') else `u`.`name` end) AS `name`,`iu`.`integra_idx` AS `integra_idx` from `integrum`.`integra_user` `iu` left join `integrum`.`users` `u` on `u`.`id` = `iu`.`id_user` join `integrum`.`integra` `i` on `iu`.`id_integra` = `i`.`id` join `essential`.`hierarchy` `h` on `i`.`hierarchy_qry_idx` = `h`.`query_idx`
union all
select `h`.`query_idx` AS `query_idx`,`i`.`id` AS `id_integra`,'S' AS `user_type`,255 AS `user_id`,'Service' AS `name`,255 AS `integra_idx` from `integrum`.`integra` `i` join `essential`.`hierarchy` `h` on `i`.`hierarchy_qry_idx` = `h`.`query_idx`;

-- Dumping structure for view integrum.integra_state_by_hierarchy
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `integra_state_by_hierarchy`;
DROP VIEW IF EXISTS `integra_state_by_hierarchy`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `integra_state_by_hierarchy` AS select `i`.`hierarchy_qry_idx` AS `hierarchy_qry_idx`,sum((case when (`s`.`state_alarm` > 0) then 1 else 0 end)) AS `alarm_count`,sum((case when (`s`.`state_trouble` > 0) then 1 else 0 end)) AS `trouble_count`,sum((case when (`s`.`state_service` > 0) then 1 else 0 end)) AS `service_count`,sum((case when (`s`.`state_arm` > 0) then 1 else 0 end)) AS `armed_count`,sum((case when (`s`.`is_online` = 1) then 0 else 1 end)) AS `offline_count`,count(`s`.`id_integra`) AS `total`,(case when ((((sum((case when (`s`.`state_alarm` > 0) then 1 else 0 end)) + sum((case when (`s`.`state_trouble` > 0) then 1 else 0 end))) + sum((case when (`s`.`state_service` > 0) then 1 else 0 end))) + sum((case when (`s`.`is_online` = 1) then 0 else 1 end))) > 0) then 0 else 1 end) AS `ok` from (`integra_state` `s` join `integra` `i` on(((`s`.`id_integra` = `i`.`id`) and (`i`.`modify_removed` = 0)))) group by `i`.`hierarchy_qry_idx`;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

notee
