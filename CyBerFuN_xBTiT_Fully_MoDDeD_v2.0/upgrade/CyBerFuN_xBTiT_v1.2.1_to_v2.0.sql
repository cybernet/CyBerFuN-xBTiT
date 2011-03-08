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
CREATE TABLE IF NOT EXISTS `{$db_prefix}files_thanks` (
  `infohash` char(40) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  KEY `infohash` (`infohash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;