#!/bin/bash

# -- run apache2 --
source /etc/apache2/envvars
touch /var/log/apache2/error.log

# if there is a previous apache -> should execute successfully:
LOCKFILE=/run/apache2/apache2.pid
if [ -f $LOCKFILE ]; then 
	echo "Apache2 already running"
	tail -f /var/log/apache2/error.log
else
	tail -f /var/log/apache2/error.log &
	exec apache2 -D FOREGROUND
fi
