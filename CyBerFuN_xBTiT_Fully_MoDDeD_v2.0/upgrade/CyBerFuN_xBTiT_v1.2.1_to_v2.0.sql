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
ALTER TABLE `{$db_prefix}bonus` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `{$db_prefix}files` ADD `gen` VARCHAR( 32 ) NOT NULL;
ALTER TABLE `{$db_prefix}users` ADD `rank_switch` ENUM( 'yes', 'no' ) NOT NULL DEFAULT 'no';
ALTER TABLE `{$db_prefix}users` ADD `old_rank` varchar(12) NOT NULL DEFAULT '3';
ALTER TABLE `{$db_prefix}users` ADD `timed_rank` datetime NOT NULL default '0000-00-00 00:00:00';

INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES
('secsui_quarantine_dir', ''), 
('secsui_quarantine_search_terms', '<?php,base64_decode,base64_encode,eval,phpinfo,fopen,fread,fwrite,file_get_contents'), 
('secsui_cookie_name', ''), 
('secsui_quarantine_pm', '2'), 
('secsui_pass_type', '1'), 
('secsui_ss', ''), 
('secsui_cookie_type', '1'), 
('secsui_cookie_exp1', '1'), 
('secsui_cookie_exp2', '3'), 
('secsui_cookie_path', ''), 
('secsui_cookie_domain', ''), 
('secsui_cookie_items', '1-0,2-0,3-0,4-0,5-0,6-0,7-0,8-0[+]0'),
('secsui_pass_min_req', '4,0,0,0,0') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;

ALTER TABLE `{$db_prefix}users`
ADD `salt` VARCHAR(20) NOT NULL DEFAULT '' AFTER `password`,
ADD `pass_type` ENUM('1','2','3','4','5','6','7') NOT NULL DEFAULT '1' AFTER `salt`,
ADD `dupe_hash` VARCHAR(20) NOT NULL DEFAULT '' AFTER `pass_type`;
ALTER TABLE `{$db_prefix}language` ADD INDEX (`language_url`);
ALTER TABLE `{$db_prefix}language` ADD UNIQUE (`language_url`);
INSERT INTO `{$db_prefix}language` (`id`, `language`, `language_url`) VALUES (NULL, 'Danish', 'language/danish') ON DUPLICATE KEY UPDATE language=language, language_url=language_url;
INSERT INTO `{$db_prefix}language` (`id`, `language`, `language_url`) VALUES (NULL, 'Swedish', 'language/swedish') ON DUPLICATE KEY UPDATE language=language, language_url=language_url;
INSERT INTO `{$db_prefix}language` (`id`, `language`, `language_url`) VALUES (NULL, 'Arabic', 'language/arabic') ON DUPLICATE KEY UPDATE language=language, language_url=language_url;
INSERT INTO `{$db_prefix}language` (`id`, `language`, `language_url`) VALUES (NULL, 'Chinese-Simplified', 'language/chinese') ON DUPLICATE KEY UPDATE language=language, language_url=language_url;
INSERT INTO `{$db_prefix}language` (`id`, `language`, `language_url`) VALUES (NULL, 'Bengali', 'language/bangla') ON DUPLICATE KEY UPDATE language=language, language_url=language_url;
ALTER TABLE `{$db_prefix}blocks` ADD UNIQUE (`content`);
UPDATE `{$db_prefix}settings` SET  `value` =  '<?php,base64_decode,base64_encode,eval(,phpinfo,fopen,fread,fwrite,file_get_contents' WHERE  `{$db_prefix}settings`.`key` = 'secsui_quarantine_search_terms';

INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES
('ipb_autoposter', '0');

ALTER TABLE `{$db_prefix}users`
ADD `ipb_fid` int(10) NOT NULL default '0',
ADD INDEX (`ipb_fid`);

ALTER TABLE `{$db_prefix}users_level`
ADD `smf_group_mirror` int(11) NOT NULL default '0',
ADD `ipb_group_mirror` int(11) NOT NULL default '0',
ADD INDEX (`smf_group_mirror`),
ADD INDEX (`ipb_group_mirror`);
