#!/bin/bash

touch initial-script-output.txt

# vendors
composer update >> initial-script-output.txt 2>&1
composer dump-autoload >> initial-script-output.txt 2>&1

# fresh migration
php artisan migrate:fresh --seed >> initial-script-output.txt 2>&1

npm install >> initial-script-output.txt 2>&1

npm run >> initial-script-output.txt 2>&1

rm initial-script-output.txt

exit 0
