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


//


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
