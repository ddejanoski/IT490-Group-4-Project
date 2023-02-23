#!/bin/bash

# Set the server you want to connect to
SERVER="damjandejanoski@172.25.153.116"

# Set the service you want to check and start
SERVICE="mysql"

# Check if the service is running on the remote server
rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

if [ $? -eq 0 ]; then
    echo $SERVICE "is running"
else
    echo $SERVICE "is not running"

    # Start the service on the remote server
    rsh -t -t -o "BatchMode yes" $SERVER "sudo systemctl start $SERVICE.service"

    # Check if the service started successfully
    rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

    if [ $? -eq 0 ]; then
        echo $SERVICE " started successfully"
    else
        echo $SERVICE " failed to start service"
    fi
fi

# Set the server you want to connect to
SERVER="nicole@172.25.68.221"

# Set the service you want to check and start
SERVICE="apache2"

# Check if the service is running on the remote server
rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

if [ $? -eq 0 ]; then
    echo $SERVICE" is running"
else
    echo $SERVICE" is not running"

    # Start the service on the remote server
    rsh -t -t -o "BatchMode yes" $SERVER "sudo systemctl start $SERVICE.service"

    # Check if the service started successfully
    rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

    if [ $? -eq 0 ]; then
        echo $SERVICE" started successfully"
    else
        echo $SERVICE" failed to start service"
    fi
fi

#!/bin/bash

# Set the server you want to connect to
SERVER="mohit@172.25.214.177"

# Set the service you want to check and start
SERVICE="rabbitmq-server"

# Check if the service is running on the remote server
rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

if [ $? -eq 0 ]; then
    echo $SERVICE" is running"
else
    echo $SERVICE" is not running"

    # Start the service on the remote server
    rsh -t -t -o "BatchMode yes" $SERVER "sudo systemctl start $SERVICE.service"

    # Check if the service started successfully
    rsh -q -o "BatchMode yes" $SERVER "systemctl is-active $SERVICE.service"

    if [ $? -eq 0 ]; then
        echo $SERVICE" started successfully"
    else
        echo $SERVICE" Failed to start service"
    fi
fi

