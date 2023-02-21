#!/usr/bin/env bash

front_server=("172.25.68.221" "apache2")           # 
rabbit_server=("172.25.214.177" "rabbitmq-server") # 
back_server=("172.25.217.136" "apache2")           # 
database_server=("172.25.153.116" "mysql-server")    # 
start_services_user="start-services-user"

ssh -l ${start_services_user} ${front_server[0]} "ps cax | grep ${front_server[1]} > /dev/null"
if [ $? -eq 0 ]; then
    echo "${database_server[1]} is running."
else
    echo "${front_server[1]} is not running."
    ssh -l ${start_services_user} ${front_server[0]} "sudo hamachi login;
    sudo hamachi join 52b337794fb6cddd;
    sudo service ${front_server[1]} start
    && echo '[start-rabbit] ${front_server[1]} started'
    || echo '[start-rabbit] ${front_server[1]} startup failed';
    exit"
fi

ssh -l ${start_services_user} ${rabbit_server[0]} "ps cax | grep ${rabbit_server[1]} > /dev/null"
if [ $? -eq 0 ]; then
    echo "${rabbit_server[1]} is running."
else
    echo "${rabbit_server[1]} is not running."
    ssh -l ${start_services_user} ${rabbit_server[0]} "sudo hamachi login;
    sudo hamachi join 52b337794fb6cddd;
    sudo service ${rabbit_server[1]} start
    && echo '[start-rabbit] ${rabbit_server[1]} started'
    || echo '[start-rabbit] ${rabbit_server[1]} startup failed';
    exit"
fi

ssh -l ${start_services_user} ${back_server[0]} "ps cax | grep ${back_server[1]} > /dev/null"
if [ $? -eq 0 ]; then
    echo "${back_server[1]} is running."
else
    echo "${database_server[1]} is not running."
    ssh -l ${start_services_user} ${back_server[0]} "sudo hamachi login;
    sudo hamachi join 52b337794fb6cddd;
    sudo service ${back_server[1]} start
    && echo '[start-rabbit] ${back_server[1]} started'
    || echo '[start-rabbit] ${back_server[1]} startup failed';
    exit"
fi

ssh -l ${start_services_user} ${database_server[0]} "ps cax | grep ${database_server[1]} > /dev/null"
if [ $? -eq 0 ]; then
    echo "${database_server[1]} is running."
else
    echo "${database_server[1]} is not running."
    ssh -l ${start_services_user} ${database_server[0]} "sudo hamachi login;
    sudo hamachi join 52b337794fb6cddd;
    sudo service ${database_server[1]} start
    && echo '[start-rabbit] ${database_server[1]} started'
    || echo '[start-rabbit] ${database_server[1]} startup failed';
    exit"