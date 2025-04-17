tee mysql-integrum-update-2.0.2.txt


USE `integrum`;

drop table integra_zone_state;
drop table integra_partition_state;
drop table integra_output_state;

update integra_user set code=null,id_user=null where modify_removed>0;

ALTER TABLE `integra_expander`
	CHANGE COLUMN `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT FIRST;

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

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES (1, 'db_version', '2.0.2');

notee
exit
