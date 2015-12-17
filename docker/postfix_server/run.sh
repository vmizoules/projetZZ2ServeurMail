#!/bin/bash

# functions
launch () {
	# print command
	echo -e
	echo -n "\$$1: "
	echo "$2"

	# exec command
	sudo -u $1 \
		-H sh -c \
		"$2"
}

# ---- Configuration ----

echo "[START] Configuring Postfix..."

chown -R postfix /etc/postfix
chgrp -R postfix /etc/postfix
chmod -R ugo+rwx /etc/postfix

echo "    Add users..."
useradd alexandre -g mail
useradd pierre -g mail
useradd vincent -g mail

echo "    Update aliases..."
newaliases

echo "    Read forward file..."
postmap /etc/postfix/virtual
postmap /etc/postfix/generic

echo "[END] Configuring Postfix..."

# Insert Mysql entries

echo "[START] Waiting for MySQL start"
sleep 10
echo "[END] Waiting for MySQL start"
mysql -h database_1 -u root -prootpassword < /opt/postfix.sql

# Launch services

echo "[START] Starting services (postfix & syslog)"
service rsyslog start > /dev/null 2>&1
service postfix start > /dev/null 2>&1
echo "[END] Starting services"
sleep 2 # wait for postfix start

# ---- Test ----

# Waiting for client send mails
sleep 6

USER='vincent'
COMMAND='mail -p'
launch "$USER" "$COMMAND"

USER='pierre'
COMMAND='mail -p'
launch "$USER" "$COMMAND"

USER='alexandre'
COMMAND='mail -p'
launch "$USER" "$COMMAND"

USER='root'
COMMAND='mail -p'
launch "$USER" "$COMMAND"

#tail -f /var/log/mail.log