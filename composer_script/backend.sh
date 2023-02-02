#!/bin/bash
if [ "$(systemctl is-active php8.1-fpm)" = "active" ]; then
    echo "PHP is running"
    php -v
else 
    echo "Starting PHP"
    systemctl start php8.1-fpm
    echo "Status..."
    systemctl status php8.1-fpm
    exit   
fi
