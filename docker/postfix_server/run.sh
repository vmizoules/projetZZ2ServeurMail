#!/bin/bash

service rsyslog start
service postfix start
sleep 2

tail -f /var/log/mail.log
