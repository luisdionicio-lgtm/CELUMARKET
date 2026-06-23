#!/usr/bin/env sh
set -eu

echo "Running Laravel pre-deploy checks..."

if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY is not set. Add a Laravel APP_KEY in Railway variables."
    exit 1
fi

if [ "${DB_CONNECTION:-}" = "mysql" ]; then
    for name in DB_HOST DB_PORT DB_DATABASE DB_USERNAME DB_PASSWORD; do
        eval "value=\${$name:-}"
        if [ -z "$value" ]; then
            echo "ERROR: $name is not set. Check the MySQL variables in Railway."
            exit 1
        fi
    done
fi

php artisan optimize:clear

attempt=1
until php artisan migrate --force; do
    if [ "$attempt" -ge 5 ]; then
        echo "ERROR: Laravel migrations failed after $attempt attempts."
        exit 1
    fi

    echo "Migrations failed. Retrying in 5 seconds... ($attempt/5)"
    attempt=$((attempt + 1))
    sleep 5
done

php artisan storage:link || true
php artisan config:cache
php artisan view:cache
