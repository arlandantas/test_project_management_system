#! /bin/bash

echo "Starting log reading..."
echo "Log limpo com sucesso!" > ./storage/logs/laravel.log
tail -f ./storage/logs/laravel.log &

if [[ -z "$LOCAL" ]]; then
    echo "Starting production octane..."
    php artisan octane:frankenphp --port=80 --workers=4 --host=0.0.0.0 --admin-port=8081 --max-requests=100
else
    echo "Starting local octane..."
    php artisan octane:frankenphp --port=81 --workers=4 --host=0.0.0.0 --admin-port=8081 --max-requests=1 --watch
fi
