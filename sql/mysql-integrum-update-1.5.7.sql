tee mysql-integrum-update-1.5.7.txt

USE `integrum`;

ALTER TABLE `integra_object` ADD INDEX `integra_object_idx` (`id_integra`, `id`);

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES (1, 'db_version', '1.5.7');

notee
exit
