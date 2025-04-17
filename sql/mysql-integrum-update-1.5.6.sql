tee mysql-integrum-update-1.5.6.txt

USE `integrum`;

ALTER TABLE `integra_output_geom` ADD COLUMN `kind` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `scale`;
ALTER TABLE `integra_zone_geom` ADD COLUMN `kind` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `scale`;

ALTER TABLE `integra_output_geom` DROP INDEX `uk_attr_integra_output_geom`;
ALTER TABLE `integra_partition_geom` DROP INDEX `uk_attr_integra_partition_geom`;
ALTER TABLE `integra_zone_geom` DROP INDEX `uk_attr_integra_zone_geom`;

USE `essential`;

ALTER TABLE `camera_geom` ADD COLUMN `kind` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `scale`;

ALTER TABLE `map_geom` DROP INDEX `uk_attr_map_geom`;
ALTER TABLE `camera_geom` DROP INDEX `uk_attr_camera_geom`;

USE `integrum`;

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES (1, 'db_version', '1.5.6');

notee
exit
