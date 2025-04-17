tee mysql-integrum-update-1.5.1.txt

USE `integrum`;

DELETE FROM `perm_role_permission`;
DELETE FROM `perm_permission`;
ALTER TABLE `perm_permission`
	CHANGE COLUMN `group` `group_` VARCHAR(15) NOT NULL AFTER `code`;
-- Dumping data for table integrum.perm_permission: ~27 rows (approximately)
/*!40000 ALTER TABLE `perm_permission` DISABLE KEYS */;
REPLACE INTO `perm_permission` (`id`, `code`, `group_`) VALUES
	(1, 'MANREGION', '09REGION'),
	(4, 'SELUSER', '05USER'),
	(5, 'CREUSER', '05USER'),
	(6, 'EDTUSER', '05USER'),
	(7, 'MANPROFILE', '07PROFILE'), 
	(8, 'SELUSERINTEGRA', '04USERINTEGRA'),
	(10, 'MANUSERAPPL', '06USERAPPL'),
	(13, 'CREUSERINTEGRA', '04USERINTEGRA'), 
	(14, 'EDTUSERINTEGRA', '04USERINTEGRA'), 
	(15, 'NOPROFILE', '04USERINTEGRA'), 
	(16, 'DELUSERINTEGRA', '04USERINTEGRA'), 
	(17, 'SELINTEGRA', '03INTEGRA'),
	(18, 'CREINTEGRA', '03INTEGRA'),
	(19, 'EDTINTEGRA', '03INTEGRA'),
	(20, 'DELINTEGRA', '03INTEGRA'),
	(21, 'MANINTEGRA', '03INTEGRA'),
	(22, 'EXPINTEGRA', '03INTEGRA'),
	(23, 'RAPINTEGRA', '03INTEGRA'), ##MODKKC_HERE
	(24, 'SELEVENTS', '02EVENTS'),
	(25, 'COMLATEREVENTS', '02EVENTS'),
	(26, 'SELDASHBOARD', '01DASHBOARD'), 
	(27, 'ACTDASHBOARD', '01DASHBOARD'), 
	(28, 'LICMANAGE', '08LICENSE'),
	(29, 'COMEVENTS', '01DASHBOARD'), 
	(30, 'DELUSER', '05USER'),
	(31, 'EDTMAP', '01DASHBOARD'), 
	(32, 'MANROLES', '10ROLES');
/*!40000 ALTER TABLE `perm_permission` ENABLE KEYS */;

-- Dumping data for table integrum.perm_role_permission: ~34 rows (approximately)
/*!40000 ALTER TABLE `perm_role_permission` DISABLE KEYS */;
REPLACE INTO `perm_role_permission` (`id`, `id_role`, `id_permission`) VALUES
	(1, 1, 1),
	(80, 1, 4),
	(4, 1, 5),
	(5, 1, 6),
	(7, 1, 7), 
	(16, 1, 8),
	(107, 1, 10),
	(13, 1, 13), 
	(14, 1, 14), 
	(138, 1, 15), 
	(15, 1, 16), 
	(20, 1, 17),
	(17, 1, 18),
	(18, 1, 19),
	(19, 1, 20),
	(23, 1, 21),
	(21, 1, 22),
	(22, 1, 23), ##MODKKC_HERE
	(24, 1, 24),
	(25, 1, 25),
	(27, 1, 26), 
	(81, 1, 27), 
	(28, 1, 28),
	(6, 1, 30),
	(29, 1, 31), 
	(84, 1, 32),
	(112, 2, 4),
	(111, 2, 8),
	(108, 2, 17),
	(109, 2, 21),
	(110, 2, 23), ##MODKKC_HERE
	(126, 2, 24),
	(127, 2, 25),
	(124, 2, 26), 
	(125, 2, 27), 
	(113, 3, 4),
	(66, 3, 8),
	(67, 3, 17),
	(69, 3, 23), ##MODKKC_HERE
	(71, 3, 24),
	(74, 3, 26), 
	(106, 4, 29), 
	(123, 4, 26), 
	(105, 4, 25);
/*!40000 ALTER TABLE `perm_role_permission` ENABLE KEYS */;
ALTER TABLE `perm_role_permission`
	AUTO_INCREMENT=201;

DROP TABLE `authority`;
ALTER TABLE `authority_profile`
ALTER `authority_level` DROP DEFAULT;
ALTER TABLE `authority_profile`
	CHANGE COLUMN `authority_level` `authority_level` BIGINT UNSIGNED NOT NULL AFTER `usertype`;


REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES
	(1, 'db_version', '1.5.1');

notee
exit
