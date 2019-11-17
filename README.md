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
Transfer data from old database:
```
1)You need to run a database dump on the server;
2)Configure connection in .env
DB_HOST2=
DB_PORT2=
DB_DATABASE2=
DB_USERNAME2=
DB_PASSWORD2=
3)Run: php artisan db:seed
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
