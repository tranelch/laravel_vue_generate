composer create-project laravel/laravel demo
cd demo
composer require laravel/jetstream
php artisan jetstream:install inertia
#php artisan jetstream:install inertia --ssr
git init

git add .
git commit -m "Laravel install"
npm install
npm i lodash.debounce
npm run build

# Set up db in .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=demo
DB_USERNAME=root
DB_PASSWORD=root

MAIL_DRIVER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=default@earthlinginteractive.com
MAIL_FROM_NAME="${APP_NAME}"


php artisan migrate
#Import app-specific dump

# Compatibility fix for reliese/laravel
composer require carbonphp/carbon-doctrine-types:^2
# Install packages
composer require mateusjunges/laravel-acl
composer require maatwebsite/excel
composer require phpoffice/phpspreadsheet
composer require lab404/laravel-impersonate
composer require orangehill/iseed --dev
composer require pestphp/pest --dev
composer require pestphp/pest-plugin-laravel --dev
composer require reliese/laravel --dev

php artisan acl:install
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
php artisan vendor:publish --provider="Junges\ACL\Providers\ACLServiceProvider"
php artisan vendor:publish --provider="Lab404\Impersonate\ImpersonateServiceProvider"
php artisan vendor:publish --tag=reliese-models
./vendor/bin/pest --init

# Generate and copy code from generator
config: must update acl tables and models
Find and replace section placeholders (before or after copy)

php artisan migrate

# Generate models from db:
php artisan code:models

# Copy model snippets from generator (config must be before migration, and model snippets after model generation)

# make directory accessible
valet link