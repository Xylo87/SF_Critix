#!/bin/sh

cd /var/www/html/project

echo quick fix to remove
chmod -R 777 ./var
chmod -R 777 ./public
echo wait sql
sleep 5 
echo "COMPOSER INSTALL"
if [ ! -d "/var/www/html/project/vendor" ]; then
    COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader --no-interaction --no-progress
else
    echo "VENDOR EXIST"
fi
composer dump-env prod
php bin/console importmap:install
php bin/console asset-map:compile
php bin/console doctrine:migrations:migrate
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
exec "$@"
