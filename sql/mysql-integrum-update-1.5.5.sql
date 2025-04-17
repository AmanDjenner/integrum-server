tee mysql-integrum-update-1.5.5.txt

USE `integrum`;

ALTER TABLE `integra_zone_state`
	DROP FOREIGN KEY `fk_integra_detail_state_zone`;

ALTER TABLE `integra_zone_state`
	DROP INDEX `fk_integra_detail_state_zone`;

DELETE z.* FROM `integra_zone_state` z where z.id_zone is null; 
create temporary table temp
select max(id) as delid from integra_zone_state
group by id_zone
having count(*)>1;
delete from integra_zone_state where id in (select delid from temp);
drop  temporary table temp;

ALTER TABLE `integra_zone_state`
	ADD UNIQUE INDEX `fk_integra_detail_state_zone` (`id_zone`);
ALTER TABLE `integra_zone_state`
	ADD CONSTRAINT `fk_integra_detail_state_zone` FOREIGN KEY (`id_zone`) REFERENCES `integra_zone` (`id`);


ALTER TABLE `integra_partition_state`
	DROP FOREIGN KEY `fk_integra_detail_state_partition`;
ALTER TABLE `integra_partition_state`
	DROP INDEX `uk_integra_partition_state`;
ALTER TABLE `integra_partition_state`
	DROP INDEX `fk_integra_partition_state`;
	
DELETE z.* FROM `integra_partition_state` z where z.id_partition is null; 
create temporary table temp
select max(id) as delid from integra_partition_state
group by id_partition
having count(*)>1;
delete from integra_partition_state where id in (select delid from temp);
drop  temporary table temp;
	
ALTER TABLE `integra_partition_state`
	ADD UNIQUE INDEX `fk_integra_partition_state` (`id_partition`);
ALTER TABLE `integra_partition_state`
	ADD CONSTRAINT `fk_integra_detail_state_partition` FOREIGN KEY (`id_partition`) REFERENCES `integra_partition` (`id`);


ALTER TABLE `integra_state`
	DROP FOREIGN KEY `fk_integra_state_integra`;
ALTER TABLE `integra_state`
	DROP INDEX `fk_integra_state_integra`;
	

DELETE z.* FROM `integra_state` z where z.id_integra is null; 
create temporary table temp
select max(id_integra) as delid from integra_state
group by id_integra
having count(*)>1;
delete from integra_state where id_integra in (select delid from temp);
drop  temporary table temp;
	
ALTER TABLE `integra_state`
	ADD UNIQUE INDEX `fk_integra_state_integra` (`id_integra`);
ALTER TABLE `integra_state`
	ADD CONSTRAINT `fk_integra_state_integra` FOREIGN KEY (`id_integra`) REFERENCES `integra` (`id`);

ALTER TABLE `integra_output_state`
	DROP FOREIGN KEY `fk_integra_detail_state_output`;

ALTER TABLE `integra_output_state`
	DROP INDEX `fk_integra_detail_state_output`;

DELETE z.* FROM `integra_output_state` z where z.id_output is null; 
create temporary table temp
select max(id) as delid from integra_output_state
group by id_output
having count(*)>1;
delete from integra_output_state where id in (select delid from temp);
drop  temporary table temp;

ALTER TABLE `integra_output_state`
	ADD UNIQUE INDEX `fk_integra_detail_state_output` (`id_output`);
ALTER TABLE `integra_output_state`
	ADD CONSTRAINT `fk_integra_detail_state_output` FOREIGN KEY (`id_output`) REFERENCES `integra_output` (`id`);

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES
	(1, 'db_version', '1.5.5');

notee
exit
