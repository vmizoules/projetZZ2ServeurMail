USE postfix;
CREATE TABLE `alias` (
`address` varchar(255) NOT NULL default '',
`goto` text NOT NULL,
`domain` varchar(255) NOT NULL default '',
`created` datetime NOT NULL default '0000-00-00 00:00:00',
`modified` datetime NOT NULL default '0000-00-00 00:00:00',
`active` tinyint(1) NOT NULL default '1',
PRIMARY KEY  (address)
) ENGINE=MyISAM COMMENT='Postfix Admin - Virtual Aliases';

INSERT INTO alias (address,goto) VALUES ('noe@localhost', 'vincent@localhost');