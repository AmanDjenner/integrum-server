tee mysql-integrum-update-2.0.0.txt

USE `integrum`;

ALTER TABLE `integra`
	ADD COLUMN `online` TINYINT(1) NOT NULL DEFAULT '0' AFTER `id_ethm`;

ALTER TABLE `integra_ethm_state` CHANGE COLUMN `mac` `mac` VARCHAR(20) NULL DEFAULT NULL AFTER `version_date`;
ALTER TABLE `license` CHANGE COLUMN `mac` `mac` VARCHAR(20) NOT NULL FIRST;
ALTER TABLE `integra_ethm`
	ADD COLUMN `mac` VARCHAR(20) NULL DEFAULT NULL AFTER `port`,
	CHANGE COLUMN `address` `address` VARCHAR(255) NULL DEFAULT NULL AFTER `name`;
ALTER TABLE `integra_ethm`
	CHANGE COLUMN `port` `port` SMALLINT(6) UNSIGNED NULL DEFAULT NULL AFTER `address`;
ALTER TABLE `integra_ethm`	
	ADD UNIQUE INDEX `uk_integra_ethm_mac` (`mac`);

update integra i join integra_state s on (s.id_integra=i.id) set i.online = 0 where s.is_online<0;
update integra i join integra_state s on (s.id_integra=i.id) set i.online = 1 where s.is_online>-1;
update integra_state set is_online = 0 where is_online<0;

ALTER TABLE `user_application`
	DROP FOREIGN KEY `fk_users_application_user`;
ALTER TABLE `user_application_role`
	DROP FOREIGN KEY `user_application_role_ibfk_1`;
ALTER TABLE `user_contact`
	DROP FOREIGN KEY `fk_users_contact_user`;
ALTER TABLE `user_photo`
	DROP FOREIGN KEY `fk_users_photo_user`;
ALTER TABLE `integra_user`
	DROP FOREIGN KEY `fk_integra_users_user`;
ALTER TABLE `users_integrum`
	DROP FOREIGN KEY `fk_users_integrum_users_id`;

ALTER TABLE `user_application`
	ADD CONSTRAINT `fk_users_application_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `user_contact`
	ADD CONSTRAINT `fk_users_contact_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `user_photo`
	ADD CONSTRAINT `fk_users_photo_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `integra_user`
	ADD CONSTRAINT `fk_integra_users_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL;
ALTER TABLE `users_integrum`
	ADD CONSTRAINT `fk_users_integrum_users_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `user_application_role`
	ADD CONSTRAINT `user_application_role_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user_application` (`id_user`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `user_application_role`
	ADD COLUMN `grp` INT(11) UNSIGNED NOT NULL AFTER `id_user`;
ALTER TABLE `user_application_role`
	DROP INDEX `user_application_role_uk`;
ALTER TABLE `user_application_role`
	ADD UNIQUE INDEX `user_application_role_uk` (`id_user`, `grp`, `id_role`);
ALTER TABLE `user_application_settings`
	ADD INDEX `fk_users_appliaction_settings` (`id_user`);
ALTER TABLE `user_application_settings`
	DROP PRIMARY KEY;
ALTER TABLE `user_application_settings`
	ADD COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT FIRST,
	ADD COLUMN `grp` INT(11) UNSIGNED NOT NULL AFTER `id_user`,
	ADD PRIMARY KEY (`id`);
ALTER TABLE `user_application_settings`
	ADD UNIQUE INDEX `user_application_setgs_hierarchy_uk` (`id_user`, `grp`, `access_hierarchy_qry_idx`);

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES (1, 'db_version', '2.0.0');

notee
exit
