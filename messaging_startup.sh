#!/bin/bash

# Set the server you want to connect to
SERVER="mohit@172.25.214.177"

# Set the service you want to check and start
SERVICE="rabbitmq-server"

# Check if the service is running on the remote server
ssh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

if [ $? -eq 0 ]; then
    echo "Service is running"
else
    echo "Service is not running"

    # Start the service on the remote server
    ssh -t -t -o "BatchMode yes" $SERVER "sudo systemctl start $SERVICE.service"

    # Check if the service started successfully
    ssh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

    if [ $? -eq 0 ]; then
        echo "Service started successfully"
    else
        echo "Failed to start service"
    fi
fi