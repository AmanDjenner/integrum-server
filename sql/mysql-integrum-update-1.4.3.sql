tee mysql-integrum-update-1.4.3.txt
USE `integrum`;

ALTER TABLE `license`
	CHANGE COLUMN `license` `license` TEXT NOT NULL AFTER `mac`;

DROP TRIGGER `integra_user_after_update`;
DROP TRIGGER `integra_user_after_insert`;
DROP TABLE `integra_user_partition`;
    
REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES
	(1, 'db_version', '1.4.3');

notee
exit
