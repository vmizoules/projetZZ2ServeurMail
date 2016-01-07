USE postfix;
CREATE TABLE `alias` (
`address` varchar(255) NOT NULL default '',
`goto` text NOT NULL,
`created` datetime NOT NULL default '0000-00-00 00:00:00',
`modified` datetime NOT NULL default '0000-00-00 00:00:00',
`enabled` tinyint(1) NOT NULL default '1',
PRIMARY KEY  (address)
) ENGINE=MyISAM COMMENT='Postfix Admin - Virtual Aliases';

INSERT INTO alias (address,goto) VALUES ('noe@localhost', 'vincent@localhost');
INSERT INTO alias (address,goto) VALUES ('noe@mymailserver', 'vincent@localhost');
