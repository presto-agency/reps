# REPS



### Installation

After cloning the repository сreate `.env` file from `.env.example` and set needed configuration data.
Run the following commands
```sh
$ composer install 
$ php artisan key:generate 
$ php artisan config:cache
$ php artisan voyager:install
$ composer dump-autoload

