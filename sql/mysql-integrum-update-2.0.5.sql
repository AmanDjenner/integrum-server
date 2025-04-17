tee mysql-integrum-update-2.0.5.txt

USE `integrum`;

alter table integra_user modify column partition_idx bigint signed;

REPLACE INTO `settings` (`id`, `key_`, `value_`) VALUES (1, 'db_version', '2.0.5');

notee
exit
