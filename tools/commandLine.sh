composer require mateusjunges/laravel-acl
composer require maatwebsite/excel
composer require phpoffice/phpspreadsheet
composer require orangehill/iseed --dev
composer require pestphp/pest --dev
composer require pestphp/pest-plugin-laravel --dev
composer require reliese/laravel --dev

php artisan acl:install
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
php artisan vendor:publish --tag=reliese-models
./vendor/bin/pest --init