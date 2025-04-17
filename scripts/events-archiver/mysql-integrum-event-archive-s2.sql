use integrum;

SELECT TABLE_NAME, SUBSTR(TABLE_NAME,23)
INTO @tname, @tstamp
FROM information_schema.TABLES WHERE table_schema = 'integrum' AND TABLE_NAME LIKE 'integra_event_archive_%' ORDER BY create_time LIMIT 1;
SELECT @tname, @tstamp;
SELECT CAST( CAST(DATE_SUB(NOW(), INTERVAL IFNULL((select value_ from settings WHERE key_='archive_days_old'),90) DAY) as date) as datetime)  INTO @archive_day;
SELECT @archive_day;

select concat('SELECT ifnull(min(id),pow(2,64)-1) INTO @archive_id FROM `',@tname,'` t WHERE t.date_ > @archive_day') into @evsql;
SELECT @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;
SELECT @archive_id ;

select concat('INSERT INTO integra_event(`id`,`id_integra`,`date_`,`class_`,`eventcode`,`monitoring_state`,`partition_number`,`object_number`,`source_number`,`is_restore`,
`partition_name`,`object_name`,`zone_name`,`user_name`,`user_ctrl_number`,`id_user`,`address_cycle`,`address`,`id_parent`,`hierarchy_qry_idx`)
SELECT `id`,`id_integra`,`date_`,`class_`,`eventcode`,`monitoring_state`,`partition_number`,`object_number`,`source_number`,`is_restore`,
`partition_name`,`object_name`,`zone_name`,`user_name`,`user_ctrl_number`,`id_user`,`address_cycle`,`address`,`id_parent`,`hierarchy_qry_idx`
FROM `', @tname, '` WHERE id>= ', @archive_id) into @evsql;
SELECT @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;

select concat('insert into integra_event_comment(`id`, `id_event`, `date`, `id_user`, `event_comment`) 
SELECT `id`, `id_event`, `date`, `id_user`, `event_comment` FROM `integra_event_comment_archive_', @tstamp, '` WHERE id_event in (select id from integra_event)') into @evsql;
SELECT @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;

select concat('INSERT INTO integra_event_archive(`archive_id`,`id`,`id_integra`,`date_`,`class_`,`eventcode`,`monitoring_state`,`partition_number`,`object_number`,`source_number`,`is_restore`,
`partition_name`,`object_name`,`zone_name`,`user_name`,`user_ctrl_number`,`id_user`,`address_cycle`,`address`,`id_parent`,`hierarchy_qry_idx`)
SELECT ''', @tstamp,''', `id`,`id_integra`,`date_`,`class_`,`eventcode`,`monitoring_state`,`partition_number`,`object_number`,`source_number`,`is_restore`,
`partition_name`,`object_name`,`zone_name`,`user_name`,`user_ctrl_number`,`id_user`,`address_cycle`,`address`,`id_parent`,`hierarchy_qry_idx`
FROM `', @tname, '` WHERE id< ', @archive_id) into @evsql;
SELECT @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;

select concat('insert into integra_event_comment_archive(`archive_id`,`id`, `id_event`, `date`, `id_user`, `event_comment`) 
SELECT ''', @tstamp,''',`id`, `id_event`, `date`, `id_user`, `event_comment` FROM `integra_event_comment_archive_', @tstamp, '` WHERE id_event not in (select id from integra_event)') into @evsql;
SELECT @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;

select concat('DROP TABLE `', @tname,'`') into @evsql;
SELECT @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;

select concat('DROP TABLE `integra_event_comment_archive_', @tstamp, '`') into @evsql;
SELECT @evsql;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;

delete from  settings where key_ = 'evnt_arch' and value_= @tstamp;
