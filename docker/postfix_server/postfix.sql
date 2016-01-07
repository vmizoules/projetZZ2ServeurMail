USE postfix;
CREATE TABLE `alias` (
	`address` varchar(255) NOT NULL default '',
	`user_id` int(11) NOT NULL,
	`site` varchar(255),
	`url` varchar(255),
	`created` datetime NOT NULL default '0000-00-00 00:00:00',
	`modified` datetime NOT NULL default '0000-00-00 00:00:00',
	`enabled` tinyint(1) NOT NULL default '1',
	PRIMARY KEY (`address`),
	FOREIGN KEY (`user_id`) REFERENCES fos_user(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=MyISAM COMMENT='Postfix Admin - Virtual Aliases';

/* Create user noe */
INSERT INTO `fos_user` (
	`id`,
	`username`,
	`username_canonical`,
	`email`,
	`email_canonical`,
	`enabled`,
	`salt`,
	`password`,
	`last_login`,
	`locked`,
	`expired`,
	`expires_at`,
	`confirmation_token`,
	`password_requested_at`,
	`roles`,
	`credentials_expired`,
	`credentials_expire_at`)
VALUES (
	1,
	'noe',
	'noe',
	'vincent@localhost',
	'vincent@localhost',
	1,
	'2vjjpacc0jac8owo0k0owg00o0cskgo',
	'$2y$13$oAB3Bs2HHuSpnB2nT3VeEeFkSuSShOErwEv9DhBiX6ERHYkIrIFSG',
	'2016-01-07 16:09:50',
	0,
	0,
	NULL,
	NULL,
	NULL,
	'a:0:{}',
	0,
	NULL
);

/* Create alias for user noe (id=1) with alias address noe@mymailserver */
INSERT INTO alias (address,user_id) VALUES ('noe@mymailserver', 1);

