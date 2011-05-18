INSERT INTO `{$db_prefix}language` (
`id` ,
`language` ,
`language_url`
)
VALUES (
NULL ,  'Swedish',  'language/swedish'
);
INSERT INTO `{$db_prefix}language` (
`id` ,
`language` ,
`language_url`
)
VALUES (
NULL ,  'Arabic',  'language/arabic'
);

ALTER TABLE `{$db_prefix}files` ADD INDEX ( `image` );
ALTER TABLE `{$db_prefix}files` ADD INDEX ( `screen1` );
ALTER TABLE `{$db_prefix}files` ADD INDEX ( `screen2` );
ALTER TABLE `{$db_prefix}files` ADD INDEX ( `screen3` );
ALTER TABLE `{$db_prefix}settings` ADD INDEX ( `value` );
ALTER TABLE `{$db_prefix}files` ADD INDEX ( `sticky` );
ALTER TABLE `{$db_prefix}users` ADD INDEX ( `invitations` );
ALTER TABLE `{$db_prefix}files` ADD INDEX ( `gold` );
ALTER TABLE `{$db_prefix}users` CHANGE  `custom_title`  `custom_title` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `{$db_prefix}online` ADD INDEX ( `warn` );
ALTER TABLE `{$db_prefix}users` ADD INDEX ( `warn` );
