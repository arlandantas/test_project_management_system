#! /bin/bash

php artisan migrate

if [[ -n "$PRODUCTION" ]]; then
    echo "Starting production octane..."
    php artisan octane:frankenphp --port=80 --workers=4 --host=0.0.0.0 --admin-port=8081 --max-requests=100
else
    if [ ! -f /app/.seeded ]; then
        php artisan db:seed && touch /app/.seeded
    fi

    echo "Starting local octane..."
    php artisan octane:frankenphp --port=80 --workers=4 --host=0.0.0.0 --admin-port=8081 --max-requests=1 --watch
fi
