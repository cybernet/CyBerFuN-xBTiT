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
INSERT INTO `{$db_prefix}blocks` VALUES ('', 'request', 'c', 6, 1, 'BLOCK_REQUEST', 'no', 3, 8)

ALTER TABLE  `{$db_prefix}files` ADD `sticky` ENUM( '0', '1' ) NOT NULL DEFAULT '0';

CREATE TABLE IF NOT EXISTS `{$db_prefix}sticky` (
  `id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#bce1ac;',
  `level` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `{$db_prefix}sticky`
--

INSERT INTO `{$db_prefix}sticky` (`id`, `color`, `level`) VALUES
(1, '#bce1ac;', 3);

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

CREATE TABLE IF NOT EXISTS `{$db_prefix}files_thanks` (
  `infohash` char(40) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  KEY `infohash` (`infohash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;