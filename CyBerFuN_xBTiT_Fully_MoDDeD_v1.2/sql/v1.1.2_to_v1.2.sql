ALTER TABLE `{$db_prefix}users` ADD INDEX ( `smf_fid` );
UPDATE `{$db_prefix}users_level` SET `prefixcolor` = '<span style=''color:#428D67''>' WHERE `{$db_prefix}users_level`.`id` =6;
UPDATE `{$db_prefix}users_level` SET `prefixcolor` = '<span style=''color:#FF8000''>' WHERE `{$db_prefix}users_level`.`id` =7;
