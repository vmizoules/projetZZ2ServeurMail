#!/bin/bash

# Configuration

echo "Configuring Postfix..."

chown -R postfix /etc/postfix
chgrp -R postfix /etc/postfix
chmod -R ugo+rwx /etc/postfix

echo "localhost" > /etc/mailname

echo "Add users..."
useradd alexandre -g mail
useradd pierre -g mail
useradd vincent -g mail

echo "Update aliases..."
newaliases

echo "Read forward file..."
postmap /etc/postfix/virtual
postmap /etc/postfix/generic

# create vmail
groupadd -g 5000 vmail
useradd -g vmail -u 5000 vmail -d /home/vmail -m

sleep 10
mysql -h database_1 -u root -prootpassword < /opt/postfix.sql

# Launch services

echo "Starting postfix..."
service rsyslog start > /dev/null 2>&1
service postfix start > /dev/null 2>&1
sleep 2 ; echo -e


tail -f /var/log/mail.log