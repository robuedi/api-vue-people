#!/bin/bash

# migrate
php artisan migrate

# fresh migration
php artisan migrate:fresh --seed

npm install

npm run

exit 0
