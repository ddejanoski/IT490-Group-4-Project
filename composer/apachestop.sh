#!/bin/bash
isUp=$(sudo systemctl is-active apache2.service)
apacheVersion=$(sudo apache2 -v)

if [ $isUp != "active" ] ; then
	echo "Apache is already off"
else
	echo "Shutting down Apache..."
	sudo service apache2 stop
fi
