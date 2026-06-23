#!/usr/bin/env sh
set -x

echo "===== Laravel Init ====="

echo "APP_KEY: ${APP_KEY:+SET}"
echo "DB_CONNECTION: ${DB_CONNECTION}"

php artisan optimize:clear || echo "optimize:clear FAILED"

php artisan migrate --force || echo "migrate FAILED"

php artisan storage:link || echo "storage:link FAILED"

php artisan config:cache || echo "config:cache FAILED"

php artisan view:cache || echo "view:cache FAILED"

echo "===== FINISHED ====="