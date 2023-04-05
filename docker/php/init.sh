#!/bin/sh

echo "Running migrations"
php artisan migrate

exec "$@"