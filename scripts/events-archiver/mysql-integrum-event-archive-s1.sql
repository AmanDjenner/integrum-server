use integrum;

SELECT UNIX_TIMESTAMP() into @tstamp;
insert INTO settings (key_, value_) VALUES ('evnt_arch',  @tstamp);
commit;

SELECT CONCAT('integra_event_archive_',@tstamp)
, CONCAT('rename table integra_event to `integra_event_archive_',@tstamp,'`')
, CONCAT('rename table integra_event_comment to `integra_event_comment_archive_',@tstamp,'`')
 INTO @tname, @evsql, @evsql1;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;
PREPARE evstmt1 FROM @evsql1;
EXECUTE evstmt1;

rename table `integra_event_new` to `integra_event`;
rename table `integra_event_comment_new` to `integra_event_comment`;

SELECT `AUTO_INCREMENT`
, CONCAT('ALTER TABLE `integra_event` AUTO_INCREMENT=',IFNULL(`AUTO_INCREMENT`,1)) 
, 'ALTER TABLE `integra_event` CHANGE COLUMN `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT FIRST'
INTO @aincval, @evsql, @evsql1 
FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'integrum' AND   TABLE_NAME   = @tname;
SELECT @evsql, @evsql1;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;
PREPARE evstmt1 FROM @evsql1;
EXECUTE evstmt1;

SELECT `AUTO_INCREMENT`
, CONCAT('ALTER TABLE `integra_event_comment` AUTO_INCREMENT=',IFNULL(`AUTO_INCREMENT`,1)) 
, 'ALTER TABLE `integra_event_comment` CHANGE COLUMN `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT FIRST'
INTO @aincval, @evsql, @evsql1 
FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'integrum' AND TABLE_NAME   = CONCAT('integra_event_comment_archive_',@tstamp);
SELECT @evsql, @evsql1;
PREPARE evstmt FROM @evsql;
EXECUTE evstmt;
DEALLOCATE PREPARE evstmt;
PREPARE evstmt1 FROM @evsql1;
EXECUTE evstmt1;
