--- request hack

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

INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_prune', '30');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_page', '10');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_post', '1');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_sb', '10');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_mb', '10000');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_rwon', 'true');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_sbmb', 'true');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_shout', 'true');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_max', '100');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_onoff', 'true');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_number', '5');
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_maxon', 'true');
INSERT INTO `{$db_prefix}blocks` VALUES ('', 'request', 'c', 6, 1, 'BLOCK_REQUEST', 'no', 3, 8);

--- sticky hack

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

--- image upload hack

ALTER TABLE `{$db_prefix}files` ADD `image` VARCHAR( 255 ) NOT NULL DEFAULT '',
      ADD `screen1` VARCHAR( 255 ) NOT NULL DEFAULT '',
      ADD `screen2` VARCHAR( 255 ) NOT NULL DEFAULT '',
      ADD `screen3` VARCHAR( 255 ) NOT NULL DEFAULT '';
ALTER TABLE  `{$db_prefix}files` ADD INDEX (  `image` );
ALTER TABLE  `{$db_prefix}files` ADD INDEX (  `screen1` );
ALTER TABLE  `{$db_prefix}files` ADD INDEX (  `screen2` );
ALTER TABLE  `{$db_prefix}files` ADD INDEX (  `screen3` );
ALTER TABLE  `{$db_prefix}settings` ADD INDEX (  `value` );

INSERT INTO `{$db_prefix}settings` ( `key` , `value` ) VALUES ('imageon', 'true');
INSERT INTO `{$db_prefix}settings` ( `key` , `value` ) VALUES ('uploaddir', 'cyberfun_img/');
INSERT INTO `{$db_prefix}settings` ( `key` , `value` ) VALUES ('file_limit', '2048');
INSERT INTO `{$db_prefix}settings` ( `key` , `value` ) VALUES ('screenon', 'true');

--- torrent thanks ajax hack

CREATE TABLE IF NOT EXISTS `{$db_prefix}files_thanks` (
  `infohash` char(40) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  KEY `infohash` (`infohash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--- Invitations hack

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
('invitation_expires', '7');

--- gold / silver torrents hack

CREATE TABLE IF NOT EXISTS `{$db_prefix}gold` (
  `id` int(11) NOT NULL auto_increment,
  `level` int(11) NOT NULL default '4',
  `gold_picture` varchar(255) NOT NULL default 'gold.gif',
  `silver_picture` varchar(255) NOT NULL default 'silver.gif',
  `active` enum('-1','0','1') NOT NULL default '1',
  `date` date NOT NULL default '0000-00-00',
  `gold_description` text NOT NULL,
  `silver_description` text NOT NULL,
  `classic_description` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `{$db_prefix}gold` (`id`, `level`, `gold_picture`, `silver_picture`, `active`, `date`, `gold_description`, `silver_description`, `classic_description`) VALUES
(1, 3, 'gold.gif', 'silver.gif', '1', '0000-00-00', 'Gold torrent description', 'Silver torrent description', 'Classic torrent description');

ALTER TABLE `{$db_prefix}files` ADD `gold` ENUM( '0', '1', '2' ) NOT NULL DEFAULT '0';
ALTER TABLE `{$db_prefix}files` ADD INDEX ( `gold` );

--- Invalid Login System hack

CREATE TABLE IF NOT EXISTS `{$db_prefix}invalid_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` bigint(11) DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL DEFAULT '',
  `failed` int(3) unsigned NOT NULL DEFAULT '0',
  `remaining` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `{$db_prefix}settings` SET `key`='inv_login', `value`='false';
INSERT INTO `{$db_prefix}settings` SET `key`='att_login', `value`='99';

--- Blocks

INSERT INTO `{$db_prefix}blocks` (`blockid`, `content`, `position`, `sortid`, `status`, `title`, `cache`, `minclassview`, `maxclassview`) VALUES
(NULL, 'request', 'c', 6, 1, 'BLOCK_REQUEST', 'no', 3, 8),
(NULL, 'header', 't', 1, 1, 'BLOCK_CYBERNET_HEADER', 'no', 1, 8),
(NULL, 'login', 'c', 0, 1, 'BLOCK_LOGIN', 'no', 1, 1);