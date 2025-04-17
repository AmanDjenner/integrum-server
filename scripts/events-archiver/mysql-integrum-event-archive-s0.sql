use integrum;

SELECT UNIX_TIMESTAMP() into @tstamp;

CREATE TABLE `integra_event_new` AS SELECT * FROM `integra_event` WHERE 1=0;
ALTER TABLE `integra_event_new` ENGINE=MyISAM, ADD PRIMARY KEY (`id`), AUTO_INCREMENT=1;
CREATE TABLE `integra_event_comment_new` AS SELECT * FROM `integra_event_comment` WHERE 1=0;
ALTER TABLE `integra_event_comment_new` ADD PRIMARY KEY (`id`), AUTO_INCREMENT=1;

select concat('ALTER TABLE `integra_event_new` ADD INDEX `fk_integra_event', @tstamp, '` (`id_integra`)') into @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;
select concat('ALTER TABLE `integra_event_new` ADD INDEX `fk_integra_event_user', @tstamp, '` (`id_user`)') into @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;
select concat('ALTER TABLE `integra_event_new` ADD INDEX `uk_integra_event_address', @tstamp, '` (`id_integra`, `address_cycle`, `address`)') into @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;
select concat('ALTER TABLE `integra_event_new` ADD INDEX `fk_integra_event_hierarchy', @tstamp, '` (hierarchy_qry_idx)') into @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;

select concat('ALTER TABLE `integra_event_comment_new` ADD INDEX `fk_integra_event', @tstamp, '` (`id_event`)') into @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;

select concat('ALTER TABLE `integra_event_comment_new` ADD CONSTRAINT `integr_event_commend_user_id', @tstamp, '` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)  ON UPDATE CASCADE') into @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;
