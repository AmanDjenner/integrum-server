tee mysql-integrum-update-2.0.1.txt

USE `essential`;

CREATE TABLE `text_geom` (
	`gid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_map` INT(11) UNSIGNED NOT NULL,
	`txt` VARCHAR(250) NOT NULL DEFAULT '',
	`geom` POINT NOT NULL,
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


REPLACE INTO `settings` (`id`, `property_key`, `property_value`) VALUES (1, 'db_version', '2.00.000');

USE `integrum`;

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES (1, 'db_version', '2.0.1');

notee
exit
