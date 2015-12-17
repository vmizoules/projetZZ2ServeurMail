#!/bin/bash

# Configuration
echo "Configuring Postfix..."

chown -R postfix /etc/postfix
chgrp -R postfix /etc/postfix
chmod -R ugo+rwx /etc/postfix

echo "Add users..."
useradd alexandre -g mail
useradd pierre -g mail
useradd vincent -g mail

echo "Update aliases..."
newaliases

echo "Read forward file..."
postmap /etc/postfix/virtual
postmap /etc/postfix/generic

sleep 9 #waiting for MySQL start
echo "Creating SQL entries..."
sleep 1
mysql -h database_1 -u root -prootpassword < /opt/postfix.sql

# Launch services

echo "Starting postfix..."
service rsyslog start > /dev/null 2>&1
service postfix start > /dev/null 2>&1
sleep 2 ; echo -e

# ----- Test ------

launch () {
	# print command
	echo -n "\$$1: "
	echo "$2"

	# exec command
	sudo -u $1 \
		-H sh -c \
		"$2"
}

# waiting for client mails
sleep 18

USER='vincent'
COMMAND='mail -p'
launch "$USER" "$COMMAND"

USER='root'
COMMAND='mail -p'
launch "$USER" "$COMMAND"

#tail -f /var/log/mail.log