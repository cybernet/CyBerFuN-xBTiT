UPDATE `{$db_prefix}hacks` SET `version` = '3.1.1' WHERE `{$db_prefix}hacks`.`id` =1;
ALTER TABLE `{$db_prefix}users` ADD INDEX ( `smf_fid` );
UPDATE `{$db_prefix}users_level` SET `prefixcolor` = '<span style=''color:#000000''>' WHERE `{$db_prefix}users_level`.`id` =3;
UPDATE `{$db_prefix}users_level` SET `prefixcolor` = '<span style=''color:#428D67''>' WHERE `{$db_prefix}users_level`.`id` =6;
UPDATE `{$db_prefix}users_level` SET `prefixcolor` = '<span style=''color:#FF8000''>' WHERE `{$db_prefix}users_level`.`id` =7;
