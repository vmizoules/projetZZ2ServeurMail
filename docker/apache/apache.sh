#!/bin/bash

# configure symfony
cd /var/www/html
chmod 777 -R var/cache var/logs
# install project dependencies & assets
if [ $INSTALL_DEPENDENCIES = "true" ]; then
	# setted in docker-compose.yml -> container -> environment
	php composer.phar install
	php bin/console assets:install web
fi
if [ $INSTALL_DATABASE = "true" ]; then
	sleep 15
	php bin/console doctrine:schema:update --force
fi

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
