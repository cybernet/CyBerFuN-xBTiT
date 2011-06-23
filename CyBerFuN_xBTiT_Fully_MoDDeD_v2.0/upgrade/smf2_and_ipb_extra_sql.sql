
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
