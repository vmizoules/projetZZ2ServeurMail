#!/bin/bash

# wait database 
sleep 10
# configure symfony
cd /var/www/html
chmod 777 -R var/cache var/logs

# run apache2
source /etc/apache2/envvars
touch /var/log/apache2/error.log
tail -f /var/log/apache2/error.log &
exec apache2 -D FOREGROUND
