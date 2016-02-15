#!/bin/bash

# Launch services
echo "[START] Starting services (postfix & syslog)"
service rsyslog start > /dev/null 2>&1
service postfix start
echo "[END] Starting services"

tail -f /var/log/syslog