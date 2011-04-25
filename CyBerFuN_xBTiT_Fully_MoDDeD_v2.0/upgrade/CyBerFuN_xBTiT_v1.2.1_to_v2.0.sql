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
CREATE TABLE `{$db_prefix}donors` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `userid` varchar(20) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `payers_email` varchar(255) NOT NULL,
  `mc_gross` decimal(5,2) NOT NULL,
  `date` datetime default '0000-00-00 00:00:00',
  `country` varchar(255) NOT NULL,
  `item` varchar(20) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `{$db_prefix}paypal_settings` (
  `id` varchar(60) NOT NULL default '',
  `test` enum('true','false') NOT NULL default 'true',
  `paypal_email` varchar(60) NOT NULL default '',
  `sandbox_email` varchar(60) NOT NULL default '',
  `vip_days` varchar(60) NOT NULL default '',
  `vip_rank` varchar(60) NOT NULL default '',
  `needed` varchar(60) NOT NULL default '',
  `due_date` varchar(60) NOT NULL default '',
  `num_block` varchar(60) NOT NULL default '',
  `received` varchar(60) NOT NULL default '',
  `donation_block` enum('true','false') NOT NULL default 'true',
  `scrol_tekst` varchar(255) NOT NULL default '',
  `units` enum('true','false') NOT NULL default 'true',
  `historie` enum('true','false') NOT NULL default 'true',
  `don_star` enum('true','false') NOT NULL default 'true',
  `gb` varchar(60) NOT NULL default '',
  `smf` varchar(60) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}paypal_settings` (`id`, `test`, `paypal_email`, `sandbox_email`, `vip_days`, `vip_rank`, `needed`, `due_date`, `num_block`, `received`, `donation_block`, `scrol_tekst`, `units`, `historie`, `don_star`, `gb`, `smf`) VALUES
('1', 'true', 'email', 'email', '1', '1', '1', '10/09/09', '1', '1', 'true', 'tekst', 'true', 'true', 'true', '1', '1');
