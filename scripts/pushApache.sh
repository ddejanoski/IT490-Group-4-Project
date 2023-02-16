#!/bin/bash
echo "Copying files to Apache..."
cp -R /home/nicole/Documents/IT490/website /var/www/html/professor-in-space
echo "Files copied, restarting Apache..."

sudo systemctl restart apache2
sudo systemctl reload apache2

isUp=$(sudo systemctl is-active apache2.service)

if [ $isUp = "active" ] ; then
	echo "Apache has been restarted"
else
	echo "Apache is not running, error has occurred"
fi