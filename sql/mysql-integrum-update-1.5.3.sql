tee mysql-integrum-update-1.5.1.txt

USE `integrum`;

update `integra_zone_geom` set scale=0.3*scale;

ALTER TABLE `integra_output_geom`
	CHANGE COLUMN `geom` `geom` POINT NOT NULL AFTER `id_attr`;

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES
	(1, 'db_version', '1.5.3');

notee
exit
