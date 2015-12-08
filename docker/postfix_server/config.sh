#!/bin/bash

echo "Configuring Postfix..."

echo "localhost" > /etc/mailname

echo "Add users..."
useradd alexandre -g mail
useradd vincent -g mail

exit 0