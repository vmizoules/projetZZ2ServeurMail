#!/bin/bash

echo "Starting postfix..."
service rsyslog start > /dev/null 2>&1
service postfix start > /dev/null 2>&1
sleep 2

echo "Test mail..."
sudo -u alexandre echo "Bonjour Vincent"|mail -s "Bjr" vincent@localhost
echo '$alexandre: echo "Bonjour Vincent"|mail -s "Bjr" vincent@localhost'
sleep 1

echo -e
echo '$vincent: cat /var/mail/vincent'
sudo -u vincent cat /var/mail/vincent
