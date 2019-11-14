Deploy:

```$xslt
composer install
```
Update data in .env file

Run:
```
php artisan migrate
php artisan storage:link
php artisan key:generate
php artisan config:cache

npm run dev
composer dump-autoload
```

Setting Chat:
- устрановка і запуск Redis сервера:
```
sudo apt install redis-server
redis-cli
```
- в .env: 
```
BROADCAST_DRIVER=redis
REDIS_PREFIX=null
```
```
php artisan config:cache
npm install -g laravel-echo-server
laravel-echo-server init
laravel-echo-server start
```