#!/usr/bin/env sh
set -x

echo "===== Laravel Init ====="

rm -f public/hot

echo "APP_KEY: ${APP_KEY:+SET}"
echo "DB_CONNECTION: ${DB_CONNECTION}"

php artisan optimize:clear || echo "optimize:clear FAILED"

if [ ! -f public/build/manifest.json ]; then
    echo "ERROR: public/build/manifest.json is missing. The Vite production build did not run."
    exit 1
fi

if ! grep -q "resources/css/app.css" public/build/manifest.json; then
    echo "ERROR: The Vite manifest does not include resources/css/app.css."
    exit 1
fi

php artisan migrate --force || echo "migrate FAILED"

php artisan storage:link || echo "storage:link FAILED"

php artisan config:cache || echo "config:cache FAILED"

php artisan view:cache || echo "view:cache FAILED"

echo "===== FINISHED ====="
