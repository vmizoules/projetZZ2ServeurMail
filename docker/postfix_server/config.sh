#!/bin/bash

echo "Configuring Postfix..."

echo "Update mailname"
echo "localhost" > /etc/mailname

echo "Add users..."
useradd alexandre -g mail
useradd vincent -g mail

echo "Update aliases..."
newaliases

exit 0