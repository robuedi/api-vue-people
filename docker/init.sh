#!/bin/bash

# composer install vendors
composer dump-autoload
composer install --no-scripts
composer update

# migrate
php artisan migrate

# fresh migration
php artisan migrate:fresh --seed

npm install

npm run

exit 0
