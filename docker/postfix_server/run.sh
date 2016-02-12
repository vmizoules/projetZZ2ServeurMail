#!/bin/bash

# ---- Configuration ----

echo "[START] Configuring Postfix..."

chown -R postfix /etc/postfix
chgrp -R postfix /etc/postfix
chmod -R ugo+rwx /etc/postfix

echo "    Update aliases..."
newaliases

echo "    Read forward file..."
postmap /etc/postfix/virtual
postmap /etc/postfix/generic

echo "[END] Configuring Postfix..."

# Insert Mysql entries

echo "[START] Waiting for MySQL start"
sleep 12
echo "[END] Waiting for MySQL start"

# Launch services

echo "[START] Starting services (postfix & syslog)"
service rsyslog start > /dev/null 2>&1
service postfix start > /dev/null 2>&1
echo "[END] Starting services"
touch /var/log/mail.log
tail -f /var/log/mail.log