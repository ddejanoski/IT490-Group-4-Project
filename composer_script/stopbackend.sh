#!/bin/bash

    systemctl stop php8.1-fpm
    echo "Status..."
    systemctl status php8.1-fpm
    exit   
fi
