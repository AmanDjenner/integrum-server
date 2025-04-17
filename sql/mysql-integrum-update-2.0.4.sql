tee mysql-integrum-update-2.0.4.txt

USE `integrum`;

ALTER TABLE `perm_permission` ADD UNIQUE INDEX `perm_permission_uk` (`code`);

update integra_event e join integra_state s on (e.id_integra=s.id_integra)
set e.zone_name=
 replace(e.zone_name, concat('W:',(select name from integra_zone z where z.id_integra=e.id_integra and z.integra_idx=e.source_number)),
 concat('W:',(select name from integra_zone z where z.id_integra=e.id_integra and z.integra_idx=e.source_number+128)))
 , e.source_number=e.source_number+128, e.user_ctrl_number=0
where  s.type = 8
and instr(e.zone_name,'W:')>0 and source_number<129 and e.user_ctrl_number = 1;

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES (1, 'db_version', '2.0.4');

notee
exit
