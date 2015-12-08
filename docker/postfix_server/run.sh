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

# Launch services

echo "Starting postfix..."
service rsyslog start > /dev/null 2>&1
service postfix start > /dev/null 2>&1
sleep 2 ; echo -e

# Test

echo "-- Test --"
sudo -u alexandre echo "Bonjour Vincent"|mail -s "Bjr" pierre@localhost
echo '$alexandre: echo "Bonjour Vincent"|mail -s "Bjr" pierre@localhost'
sleep 1

echo -e
echo '$alexandre: cat /var/mail/alexandre'
sudo -u alexandre cat /var/mail/alexandre

echo -e
echo '$pierre: cat /var/mail/pierre'
sudo -u pierre cat /var/mail/pierre

echo -e
echo '$vincent: cat /var/mail/vincent'
sudo -u vincent cat /var/mail/vincent
