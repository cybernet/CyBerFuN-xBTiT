ALTER TABLE `{$db_prefix}comments` CHANGE  `text`  `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `{$db_prefix}comments` CHANGE  `ori_text`  `ori_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `{$db_prefix}forums` CHANGE  `description`  `description` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `{$db_prefix}forums` CHANGE  `name`  `name` VARCHAR( 60 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '' ;
ALTER TABLE `{$db_prefix}posts`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}posts` CHANGE `body` `body` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `{$db_prefix}topics`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}topics` CHANGE `subject` `subject` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `{$db_prefix}topics` CHANGE `locked` `locked` ENUM( 'yes', 'no' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no' ;
ALTER TABLE `{$db_prefix}topics` CHANGE `sticky` `sticky` ENUM( 'yes', 'no' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no' ;
ALTER TABLE `{$db_prefix}logs` CHANGE `txt` `txt` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `{$db_prefix}messages`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}messages` CHANGE `subject` `subject` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'reason for making my database bigger' ;
ALTER TABLE `{$db_prefix}comments` CHANGE `text` `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `{$db_prefix}comments` CHANGE `ori_text` `ori_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `{$db_prefix}posts` CHANGE `body` `body` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `{$db_prefix}files` CHANGE  `comment`  `comment` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `{$db_prefix}files` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}bannedip` CHANGE  `comment`  `comment` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '' ;
ALTER TABLE `{$db_prefix}settings` CHANGE `key` `key` VARCHAR( 41 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;


---


ALTER TABLE `{$db_prefix}files` CHANGE `filename` `filename` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'torrent name' ;
ALTER TABLE `{$db_prefix}files` CHANGE `url` `url` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'where are you ?' ;
ALTER TABLE `{$db_prefix}files` CHANGE `info` `info` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ;
ALTER TABLE `{$db_prefix}files` CHANGE `announce_url` `announce_url` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ;
ALTER TABLE `{$db_prefix}files` COMMENT = 'torrents' ;
ALTER TABLE `{$db_prefix}chat` CHANGE `text` `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `{$db_prefix}chat` CHANGE `name` `name` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `{$db_prefix}polls` CHANGE `poll_question` `poll_question` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `{$db_prefix}polls` CHANGE `status` `status` ENUM( 'true', 'false' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false' ;
ALTER TABLE `{$db_prefix}polls` CHANGE `choices` `choices` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `{$db_prefix}polls` ADD INDEX ( `poll_question` ) ;
ALTER TABLE `{$db_prefix}polls` ADD INDEX ( `votes` ) ;
ALTER TABLE `{$db_prefix}polls` ADD INDEX ( `status` ) ;
ALTER TABLE `{$db_prefix}chat` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}categories` CHANGE `name` `name` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ;
ALTER TABLE `{$db_prefix}categories` ADD INDEX ( `image` ) ;
ALTER TABLE `{$db_prefix}categories` ADD INDEX ( `sort_index` ) ;
ALTER TABLE `{$db_prefix}categories` ADD INDEX ( `name` ) ;
ALTER TABLE `{$db_prefix}messages` CHANGE `msg` `msg` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `{$db_prefix}messages` CHANGE `readed` `readed` ENUM( 'yes', 'no' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no' ;
ALTER TABLE `{$db_prefix}news` CHANGE `title` `title` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ;
ALTER TABLE `{$db_prefix}news` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}news` ADD INDEX ( `title` ) ;
ALTER TABLE `{$db_prefix}news` ADD INDEX ( `user_id` ) ;
ALTER TABLE `{$db_prefix}style` CHANGE `style` `style` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ;
ALTER TABLE `{$db_prefix}style` CHANGE `style_url` `style_url` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ;
ALTER TABLE `{$db_prefix}style` ADD INDEX ( `style` ) ;
ALTER TABLE `{$db_prefix}style` ADD INDEX ( `style_url` ) ;
ALTER TABLE `{$db_prefix}style` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}language` CHANGE `language` `language` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ;
ALTER TABLE `{$db_prefix}language` ADD INDEX ( `language_url` ) ;
ALTER TABLE `{$db_prefix}language` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}modules` CHANGE `name` `name` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ;
ALTER TABLE `{$db_prefix}modules` ADD INDEX ( `activated` ) ;
ALTER TABLE `{$db_prefix}modules` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}online` ADD INDEX ( `prefixcolor` ) ;
ALTER TABLE `{$db_prefix}online` ADD INDEX ( `location` ) ;
ALTER TABLE `{$db_prefix}online` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}online` CHANGE `user_name` `user_name` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `{$db_prefix}online` CHANGE `user_group` `user_group` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `{$db_prefix}online` CHANGE `location` `location` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `{$db_prefix}history` ADD INDEX ( `agent` ) ;
ALTER TABLE `{$db_prefix}history` ADD INDEX ( `active` ) ;
ALTER TABLE `{$db_prefix}history` CHANGE `agent` `agent` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ;
ALTER TABLE `{$db_prefix}history` CHANGE `active` `active` ENUM( 'yes', 'no' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no' ;
ALTER TABLE `{$db_prefix}history` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `{$db_prefix}history` ADD INDEX ( `uploaded` ) ;
ALTER TABLE `{$db_prefix}history` ADD INDEX ( `downloaded` ) ;
ALTER TABLE `{$db_prefix}categories` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;


--- [BTITEAM HACK] Torrent Request and Vote hack

CREATE TABLE IF NOT EXISTS `{$db_prefix}addedrequests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `requestid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `requestid` (`requestid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_prune', '30') ;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_post', '1') ;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_post', '1') ;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_mb', '10000') ;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_rwon', 'true') ;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_sbmb', 'true') ;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_shout', 'true') ;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_max', '100') ;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_onoff', 'true') ;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_number', '5') ;
INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES ('req_maxon', 'true') ;
INSERT INTO `{$db_prefix}blocks` VALUES ('', 'request', 'c', 6, 1, 'BLOCK_REQUEST', 'no', 3, 8) ;
