tee mysql-integrum-update-2.0.3.txt


USE `essential`;

ALTER TABLE `text_geom` CHANGE COLUMN `geom` `geom` GEOMETRY NOT NULL AFTER `txt`;
update text_geom set geom = linestring(Point(st_x(geom)-10,st_y(geom)),Point(st_x(geom)-10,st_y(geom))) where ST_GeometryType(geom) ='POINT';
ALTER TABLE `text_geom` CHANGE COLUMN `geom` `geom` LINESTRING NOT NULL AFTER `txt`;

USE `integrum`;

update integra_event e join integra_evnt_descr d on e.eventcode=d.code
left join integra_expander ex on ex.id_integra=e.id_integra and ex.integra_idx=e.partition_number+193
set e.zone_name = concat('M:', ex.name)
 where eventcode in (
select code from integra_evnt_descr where type1 in (6))
and (e.zone_name ='' or e.zone_name is null);

update integra_event e join integra_evnt_descr d on e.eventcode=d.code
left join integra_expander ex on ex.id_integra=e.id_integra and ex.integra_idx=e.source_number
set e.zone_name = concat('M:', ex.name)
 where eventcode in (
select code from integra_evnt_descr where type1 in (12,13))
and (e.zone_name ='' or e.zone_name is null);

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES (1, 'db_version', '2.0.3');

notee
exit
