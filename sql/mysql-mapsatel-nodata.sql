-- --------------------------------------------------------
-- Host:                         192.168.1.11
-- Wersja serwera:               5.5.40-0+wheezy1 - (Debian)
-- Serwer OS:                    debian-linux-gnu
-- HeidiSQL Wersja:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
tee schema-essential.txt
-- Zrzut struktury bazy danych essential
USE `essential`;


-- Zrzut struktury tabela essential.camera
CREATE TABLE IF NOT EXISTS `camera` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `type` int(11) unsigned DEFAULT NULL,
  `link` varchar(400) DEFAULT NULL,
  `hierarchy_qry_idx` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_integra_group` (`hierarchy_qry_idx`),
  KEY `fk_camera_kind` (`type`),
  CONSTRAINT `fk_camera_group` FOREIGN KEY (`hierarchy_qry_idx`) REFERENCES `hierarchy` (`query_idx`),
  CONSTRAINT `fk_camera_kind` FOREIGN KEY (`type`) REFERENCES `layer_kind` (`id`)
) ENGINE=InnoDB;

-- Data exporting was unselected.


-- Zrzut struktury tabela essential.camera_geom
CREATE TABLE IF NOT EXISTS `camera_geom` (
  `gid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_map` int(11) unsigned NOT NULL,
  `id_attr` int(11) unsigned DEFAULT NULL,
  `geom` point NOT NULL,
  `rot` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `scale` decimal(10,4) NOT NULL DEFAULT '1.0000',
  `kind` int(10) unsigned DEFAULT NULL,
  `geomshp` polygon DEFAULT NULL,
  PRIMARY KEY (`gid`),
  KEY `fk_attr_camera_geom` (`id_attr`),
  CONSTRAINT `fk_attr_camera_geom` FOREIGN KEY (`id_attr`) REFERENCES `camera` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Data exporting was unselected.


-- Zrzut struktury tabela essential.datasource
CREATE TABLE IF NOT EXISTS `datasource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `pluginname` varchar(50) DEFAULT NULL,
  `version` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB;

-- Data exporting was unselected.


-- Zrzut struktury tabela essential.hierarchy
CREATE TABLE IF NOT EXISTS `hierarchy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) DEFAULT '1',
  `name` varchar(150) DEFAULT NULL,
  `id_map` int(10) unsigned DEFAULT NULL COMMENT 'Default map for tree',
  `query_idx` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_hierarchy_query_idx` (`query_idx`),
  KEY `fk_integrahierarchy_parent` (`id_parent`)
) ENGINE=InnoDB;

-- Data exporting was unselected.


-- Zrzut struktury tabela essential.layer_kind
CREATE TABLE IF NOT EXISTS `layer_kind` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `layer_code` varchar(50) NOT NULL,
  `img` blob NOT NULL,
  `isautoreg` tinyint(4) NOT NULL DEFAULT '0',
  `isdefault` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_layer_kind_layer_code_name` (`layer_code`,`name`)
) ENGINE=InnoDB;

-- Data exporting was unselected.


-- Zrzut struktury tabela essential.map
CREATE TABLE IF NOT EXISTS `map` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `hierarchy_qry_idx` varchar(100) NOT NULL,
  `id_parent` int(10) DEFAULT NULL,
  `sizex` int(11) NOT NULL,
  `sizey` int(11) NOT NULL,
  `background` mediumblob,
  `bckgrnd_x` int(11) DEFAULT NULL,
  `bckgrnd_y` int(11) DEFAULT NULL,
  `bckgrnd_sx` int(11) unsigned DEFAULT NULL,
  `bckgrnd_sy` int(11) unsigned DEFAULT NULL,
  `bckgrnd_col` int(10) unsigned DEFAULT '4294967295',
  `revd` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lockedby` int(11) DEFAULT NULL,
  `hidden` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pk_map` (`id`),
  KEY `fk_hierarchy_map` (`hierarchy_qry_idx`),
  CONSTRAINT `fk_hierarchy_map` FOREIGN KEY (`hierarchy_qry_idx`) REFERENCES `hierarchy` (`query_idx`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Data exporting was unselected.


-- Zrzut struktury tabela essential.map_geom
CREATE TABLE IF NOT EXISTS `map_geom` (
  `gid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `geom` polygon NOT NULL,
  `id_map` int(11) unsigned NOT NULL,
  `id_attr` int(11) unsigned NULL DEFAULT NULL,
  `color` INT UNSIGNED NULL,
  PRIMARY KEY (`gid`),
  INDEX `map_geom_map_idx` (`id_attr`),
  CONSTRAINT `fk_map_geom_map` FOREIGN KEY (`id_attr`) REFERENCES `map` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- Data exporting was unselected.


-- Zrzut struktury tabela essential.map_layer
CREATE TABLE IF NOT EXISTS `map_layer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_map` int(11) unsigned NOT NULL,
  `layer_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_map_layer_map` (`id_map`),
  CONSTRAINT `fk_map_layer_map` FOREIGN KEY (`id_map`) REFERENCES `map` (`id`)
) ENGINE=InnoDB;

-- Data exporting was unselected.


CREATE TABLE `text_geom` (
	`gid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_map` INT(11) UNSIGNED NOT NULL,
	`txt` VARCHAR(250) NOT NULL DEFAULT '',
	`geom` LINESTRING NOT NULL,
	`rot` DECIMAL(10,4) NOT NULL DEFAULT '0.0000',
	`scale` DECIMAL(10,4) NOT NULL DEFAULT '1.0000',
	`fontfamily` VARCHAR(250) NOT NULL,
	`color` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
	`bold` TINYINT(4) NOT NULL DEFAULT '0',
	`italic` TINYINT(4) NOT NULL DEFAULT '0',
	PRIMARY KEY (`gid`),
	INDEX `fk_map_text_geom` (`id_map`),
	CONSTRAINT `fk_map_text_geom` FOREIGN KEY (`id_map`) REFERENCES `map` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB
AUTO_INCREMENT=1;

-- Zrzut struktury tabela essential.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_key` varchar(50) NOT NULL,
  `property_value` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3;

-- Data exporting was unselected.


-- Zrzut struktury wyzwalacz essential.hierarchy_before_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `hierarchy_before_insert` BEFORE INSERT ON `hierarchy` FOR EACH ROW begin
if new.query_idx is null or new.query_idx = '' then 
set new.query_idx=concat('1.',new.id);
end if;
end//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
notee 