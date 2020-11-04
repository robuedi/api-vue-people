#!/bin/bash

# migrate
php artisan migrate

# fresh migration
php artisan migrate:fresh --seed

exit 0
