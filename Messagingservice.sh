#! /bin/bash

#function to check the status of rabbitmq services

check_status(){
 sudo systemctl status rabbitmq-server | grep 'active(running)' > /dev/null 2>&1
 return $?
}

#start the rabbitmqservice if it's not running
if ! check_status; then
 echo " Rabbitmq service is not running starting the services..."
 sudo systemctl start rabbitmq-server
fi 

# show the status  rabbitmqserver
sudo systemctl status rabbitmq-server


