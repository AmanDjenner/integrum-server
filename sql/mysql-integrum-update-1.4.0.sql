tee mysql-integrum-update-1.4.0.txt
USE `integrum`;
-- Dumping structure for trigger integrum.integra_ethm_after_insert

-- DROP TRIGGER `integra_ethm_after_insert`;


-- Dumping structure for trigger integrum.integra_ethm_after_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `integra_ethm_after_insert` AFTER INSERT ON `integra_ethm` FOR EACH ROW BEGIN
  INSERT INTO integra_ethm_state(id,version, version_date, version_notsupported,mac)
  VALUES(new.id, 0, null, 0, null);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for function integrum.has_partition
DELIMITER //
CREATE FUNCTION `has_partition`(`partition_idx` INT, `part` INT) RETURNS int(11)
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
  return case when substr(lpad(conv(partition_idx,10,2),32,0),32-part+1,1) ='0' then 0 else 1 end;
END//
DELIMITER ;

insert into integra_ethm_state(id,version, version_date, version_notsupported,mac)
select id,0,null,0,null from integra_ethm ie where ie.id not in (select id from integra_ethm_state);

update integra_user u 
set id_user=null
where u.modify_removed>0 and id_user is not null;

ALTER TABLE `integra_user`
	ADD COLUMN `uschema` TINYINT UNSIGNED NULL DEFAULT NULL AFTER `dallas`,
	ADD COLUMN `cnt` TINYINT UNSIGNED NULL DEFAULT NULL AFTER `uschema`;

update integra_crc set crc=0 where typ>=6 and typ<=14 and crc!=0;

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES
	(1, 'db_version', '1.4.0');

notee
exit