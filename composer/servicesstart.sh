#!/bin/bash
isUp=$(sudo systemctl is-active apache2.service)
apacheVersion=$(sudo apache2 -v)

if [ $isUp = "active" ] ; then
	echo "Apache is up and running"
	echo "Version running: "
	echo $apacheVersion
else
	echo "Apache is not running, starting now..."
	sudo systemctl start apache2
	echo "Apache status: "
	isUp=$(sudo systemctl is-active apache2.service)
	echo $isUp
	echo "Version running: "
	echo $apacheVersion
fi

# Set the server you want to connect to
SERVER="damjandejanoski@172.25.153.116"

# Set the service you want to check and start
SERVICE="mysql"

# Check if the service is running on the remote server
rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

if [ $? -eq 0 ]; then
    echo "mysql Service is running"
else
    echo "mysql Service is not running"

    # Start the service on the remote server
    rsh -t -t -o "BatchMode yes" $SERVER "sudo systemctl start $SERVICE.service"

    # Check if the service started successfully
    rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

    if [ $? -eq 0 ]; then
        echo "mysql Service started successfully"
    else
        echo "Failed to start mysql service"
    fi
fi

# Set the server you want to connect to
SERVER="mohit@172.25.214.177"

# Set the service you want to check and start
SERVICE="rabbitmq-server"

# Check if the service is running on the remote server
rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

if [ $? -eq 0 ]; then
    echo "rabbitmq Service is running"
else
    echo "rabbitmq Service is not running"

    # Start the service on the remote server
    rsh -t -t -o "BatchMode yes" $SERVER "sudo systemctl start $SERVICE.service"

    # Check if the service started successfully
    rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

    if [ $? -eq 0 ]; then
        echo "rabbitmq Service started successfully"
    else
        echo "Failed to start rabbitmq service"
    fi
fi

# Set the server you want to connect to
SERVER="brian@172.25.217.136"

# Set the service you want to check and start
SERVICE="php8.1-fpm"

# Check if the service is running on the remote server
rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

if [ $? -eq 0 ]; then
    echo "php Service is running"
else
    echo "php Service is not running"

    # Start the service on the remote server
    rsh -t -t -o "BatchMode yes" $SERVER "sudo systemctl start $SERVICE.service"

    # Check if the service started successfully
    rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

    if [ $? -eq 0 ]; then
        echo "php Service started successfully"
    else
        echo "Failed to start php service"
    fi
fi