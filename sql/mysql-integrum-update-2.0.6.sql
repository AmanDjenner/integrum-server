tee mysql-integrum-update-2.0.6.txt

USE `integrum`;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Zrzut struktury tabela integrum.integra_event_archive
CREATE TABLE IF NOT EXISTS `integra_event_archive` (
  `ARCHIVE_id` varchar(50) DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `id_integra` int(11) DEFAULT NULL,
  `date_` datetime DEFAULT NULL,
  `class_` int(11) unsigned DEFAULT NULL,
  `eventcode` int(10) DEFAULT NULL,
  `monitoring_state` tinyint(4) unsigned DEFAULT NULL,
  `partition_number` int(11) unsigned DEFAULT NULL,
  `object_number` int(11) unsigned DEFAULT NULL,
  `source_number` int(11) unsigned DEFAULT NULL,
  `is_restore` tinyint(4) unsigned DEFAULT NULL,
  `partition_name` varchar(50) DEFAULT NULL,
  `object_name` varchar(50) DEFAULT NULL,
  `zone_name` varchar(50) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_ctrl_number` tinyint(4) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `address_cycle` int(11) NOT NULL DEFAULT '0',
  `address` int(11) NOT NULL,
  `id_parent` int(11) unsigned DEFAULT NULL,
  `hierarchy_qry_idx` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Zrzut struktury tabela integrum.integra_event_comment_archive
CREATE TABLE IF NOT EXISTS `integra_event_comment_archive` (
  `archive_id` varchar(50) NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_event` bigint(20) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `event_comment` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 3` (`id_event`),
  KEY `integr_event_commend_user_id` (`id_user`),
  CONSTRAINT `integra_event_comment_archive_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

INSERT INTO `settings` (`id`, `key_`, `value_`) VALUES (2, 'archive_days_old', '90');

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES (1, 'db_version', '2.0.6');

notee
exit