#!/bin/bash
isUp=$(sudo systemctl is-active apache2.service)
apacheVersion=$(sudo apache2 -v)

if [ $isUp = "active" ] ; then
	echo "Apache is up and running"
	echo "Version running: "
	echo $apacheVersion
else
	echo "Apache is not running, starting now..."
	systemctl start apache2
	echo "Apache status: "
	isUp=$(sudo systemctl is-active apache2.service)
	echo $isUp
	echo "Version running: "
	echo $apacheVersion
fi
