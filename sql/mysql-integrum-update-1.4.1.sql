tee mysql-integrum-update-1.4.1.txt
USE `mapsatel`;
-- Dumping structure for trigger integrum.integra_ethm_after_insert

delete from map_geom where id_attr not in (select id from map);
delete from map_geom where id_map not in (select id from map);


ALTER TABLE `map_geom`
	ADD CONSTRAINT `fk_map_geom_map` FOREIGN KEY (`id_attr`) REFERENCES `map` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

USE `integrum`;
REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES
	(1, 'db_version', '1.4.1');

notee
exit
