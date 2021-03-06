-- Request hack

CREATE TABLE IF NOT EXISTS `{$db_prefix}addedrequests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `requestid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `requestid` (`requestid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `{$db_prefix}requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `request` varchar(225) DEFAULT NULL,
  `descr` text NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fulfilled` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `cat` int(10) unsigned NOT NULL DEFAULT '0',
  `filled` varchar(255) DEFAULT NULL,
  `filledby` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_prune', '30') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_page', '10') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_post', '1') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_sb', '10') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_mb', '10000') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_rwon', 'true') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_sbmb', 'true') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_shout', 'true') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_max', '100') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_onoff', 'true') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_number', '5') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_maxon', 'true') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}blocks` (`blockid`, `content`, `position`, `sortid`, `status`, `title`, `cache`, `minclassview`, `maxclassview`) VALUES (NULL, 'request', 'c', 6, 1, 'BLOCK_REQUEST', 'no', 3, 8) ON DUPLICATE KEY UPDATE `blockid`=`blockid`, `content`=`content`, `position`=`position`, `sortid`=`sortid`, `status`=`status`, `title`=`title`, `cache`=`cache`, `minclassview`=`minclassview`, `maxclassview`=`maxclassview`;

-- Sticky hack

CREATE TABLE IF NOT EXISTS `{$db_prefix}sticky` (
  `id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#bce1ac;',
  `level` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}sticky` (`id`, `color`, `level`) VALUES
(1, '#bce1ac;', 3);

ALTER TABLE `{$db_prefix}files` ADD `sticky` ENUM( '0', '1' ) NOT NULL DEFAULT '0';
ALTER TABLE `{$db_prefix}files` ADD INDEX ( `sticky` );

-- iMage upload hack

ALTER TABLE `{$db_prefix}files` ADD `image` VARCHAR( 255 ) NOT NULL DEFAULT '',
      ADD `screen1` VARCHAR( 255 ) NOT NULL DEFAULT '',
      ADD `screen2` VARCHAR( 255 ) NOT NULL DEFAULT '',
      ADD `screen3` VARCHAR( 255 ) NOT NULL DEFAULT '';
ALTER TABLE  `{$db_prefix}files` ADD INDEX (  `image` );
ALTER TABLE  `{$db_prefix}files` ADD INDEX (  `screen1` );
ALTER TABLE  `{$db_prefix}files` ADD INDEX (  `screen2` );
ALTER TABLE  `{$db_prefix}files` ADD INDEX (  `screen3` );
ALTER TABLE  `{$db_prefix}settings` ADD INDEX (  `value` );

INSERT INTO `{$db_prefix}settings` ( `key` , `value` ) VALUES ('imageon', 'true') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` ( `key` , `value` ) VALUES ('uploaddir', 'cyberfun_img/') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` ( `key` , `value` ) VALUES ('file_limit', '2048') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` ( `key` , `value` ) VALUES ('screenon', 'true') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;

-- torrent thanks ajax hack

CREATE TABLE IF NOT EXISTS `{$db_prefix}files_thanks` (
  `infohash` char(40) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  KEY `infohash` (`infohash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- iNvitations hack

CREATE TABLE IF NOT EXISTS `{$db_prefix}invitations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inviter` int(10) unsigned NOT NULL DEFAULT '0',
  `invitee` varchar(80) NOT NULL DEFAULT '',
  `hash` varchar(32) NOT NULL DEFAULT '',
  `time_invited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `confirmed` enum('true','false') NOT NULL DEFAULT 'false',
  KEY `inviter` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `{$db_prefix}users` 
ADD `invitations` int(10) NOT NULL default '0',
ADD `invited_by` int(10) NOT NULL default '0',
ADD `invitedate` datetime NOT NULL default '0000-00-00 00:00:00';
ALTER TABLE `{$db_prefix}users` ADD INDEX ( `invitations` );

DELETE FROM `{$db_prefix}settings`
WHERE `key` LIKE 'invitation_%';

INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES 
('invitation_only', 'true'), 
('invitation_reqvalid', 'false'),
('invitation_expires', '7') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;

-- gold / silver torrents hack

CREATE TABLE IF NOT EXISTS `{$db_prefix}gold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL DEFAULT '4',
  `gold_picture` varchar(255) NOT NULL DEFAULT 'gold.gif',
  `silver_picture` varchar(255) NOT NULL DEFAULT 'silver.gif',
  `active` enum('-1','0','1') NOT NULL DEFAULT '1',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `gold_description` text NOT NULL,
  `silver_description` text NOT NULL,
  `classic_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `{$db_prefix}gold` (`id`, `level`, `gold_picture`, `silver_picture`, `active`, `date`, `gold_description`, `silver_description`, `classic_description`) VALUES
(NULL, 3, 'gold.gif', 'silver.gif', '1', CURDATE(), 'Gold torrent description', 'Silver torrent description', 'Classic torrent description');

ALTER TABLE `{$db_prefix}files` ADD `gold` ENUM( '0', '1', '2' ) NOT NULL DEFAULT '0';
ALTER TABLE `{$db_prefix}files` ADD INDEX ( `gold` );

-- iNvalid Login System hack

-- Disabled by default

CREATE TABLE IF NOT EXISTS `{$db_prefix}invalid_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` bigint(11) DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL DEFAULT '',
  `failed` int(3) unsigned NOT NULL DEFAULT '0',
  `remaining` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `{$db_prefix}settings` (`key` ,`value`) VALUES ('inv_login',  'false') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key` ,`value`) VALUES ('att_login',  '5') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;

-- Blocks

INSERT INTO `{$db_prefix}blocks` (`blockid`, `content`, `position`, `sortid`, `status`, `title`, `cache`, `minclassview`, `maxclassview`) VALUES
(NULL, 'request', 'c', 6, 1, 'BLOCK_REQUEST', 'no', 3, 8),
(NULL, 'header', 't', 1, 1, 'BLOCK_CYBERNET_HEADER', 'no', 1, 8),
(NULL, 'login', 'c', 0, 1, 'BLOCK_LOGIN', 'no', 1, 1);

-- Custom Title

ALTER TABLE `{$db_prefix}users` ADD `custom_title` VARCHAR( 100 ) NULL;

-- Warn System

ALTER TABLE `{$db_prefix}online` ADD `warn` enum('yes','no') NOT NULL default 'no';
ALTER TABLE `{$db_prefix}users` ADD `warn` enum('yes','no') NOT NULL default 'no';
ALTER TABLE `{$db_prefix}users` ADD `warnreason` varchar(255) NOT NULL;
ALTER TABLE `{$db_prefix}users` ADD `warnadded` datetime NOT NULL default '0000-00-00 00:00:00';
ALTER TABLE `{$db_prefix}users` ADD `warns` bigint(20) default '0';
ALTER TABLE `{$db_prefix}users` ADD `warnaddedby` varchar(255) NOT NULL;
ALTER TABLE `{$db_prefix}online` ADD INDEX ( `warn` );
ALTER TABLE `{$db_prefix}users` ADD INDEX ( `warn` );

-- SeedBonus System

CREATE TABLE IF NOT EXISTS `{$db_prefix}bonus` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `points` decimal(4,1) NOT NULL DEFAULT '0.0',
  `traffic` bigint(20) unsigned NOT NULL DEFAULT '0',
  `gb` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `{$db_prefix}bonus` (`id`, `name`, `points`, `traffic`, `gb`) VALUES
(NULL, '1', '30.0', 1073741824, 1),
(NULL, '2', '50.0', 2147483648, 2),
(NULL, '3', '100.0', 5368709120, 5);

INSERT INTO `{$db_prefix}modules` (`id`, `name`, `activated`, `type`, `changed`, `created`) VALUES
(NULL, 'seedbonus', 'yes', 'misc', NOW(), NOW());

INSERT INTO `{$db_prefix}settings` (`key` ,`value`) VALUES ('bonus',  '1') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key` ,`value`) VALUES ('price_vip',  '750') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key` ,`value`) VALUES ('price_ct',  '200') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
INSERT INTO `{$db_prefix}settings` (`key` ,`value`) VALUES ('price_name',  '500') ON DUPLICATE KEY UPDATE `key`=`key`, `value`=`value`;
ALTER TABLE `{$db_prefix}users` ADD `seedbonus` DECIMAL( 12,6 ) NOT NULL DEFAULT '0';

-- Torrent Genre v1.1

ALTER TABLE `{$db_prefix}files` ADD `gen` VARCHAR( 32 ) NOT NULL;

-- TimeD ranks

ALTER TABLE `{$db_prefix}users` ADD `rank_switch` ENUM( 'yes', 'no' ) NOT NULL DEFAULT 'no';
ALTER TABLE `{$db_prefix}users` ADD `old_rank` varchar(12) NOT NULL DEFAULT '3';
ALTER TABLE `{$db_prefix}users` ADD `timed_rank` datetime NOT NULL default '0000-00-00 00:00:00';

-- Language

ALTER TABLE `{$db_prefix}language` ADD INDEX (`language_url`);
ALTER TABLE `{$db_prefix}language` ADD UNIQUE (`language_url`);
INSERT INTO `{$db_prefix}language` (`id`, `language`, `language_url`) VALUES (NULL, 'Danish', 'language/danish') ON DUPLICATE KEY UPDATE language=language, language_url=language_url;
INSERT INTO `{$db_prefix}language` (`id`, `language`, `language_url`) VALUES (NULL, 'Chinese-Simplified', 'language/chinese') ON DUPLICATE KEY UPDATE language=language, language_url=language_url;
INSERT INTO `{$db_prefix}language` (`id`, `language`, `language_url`) VALUES (NULL, 'Bengali', 'language/bangla') ON DUPLICATE KEY UPDATE language=language, language_url=language_url;

-- i

ALTER TABLE `{$db_prefix}blocks` ADD UNIQUE (`content`);
UPDATE `{$db_prefix}settings` SET  `value` =  '<?php,base64_decode,base64_encode,eval(,phpinfo,fopen,fread,fwrite,file_get_contents' WHERE  `{$db_prefix}settings`.`key` = 'secsui_quarantine_search_terms';
