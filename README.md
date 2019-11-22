1.Deploy:

```$xslt
composer install
```
2.Update data in .env file

Run:
```
php artisan migrate
php artisan storage:link
php artisan key:generate
php artisan config:cache

npm run dev
composer dump-autoload
```

3.Transfer data from old database:
```
1)You need to run a database dump on the server;
2)Configure connection in .env
DB_HOST2=
DB_PORT2=
DB_DATABASE2=
DB_USERNAME2=
DB_PASSWORD2=
3)php artisan config:cache
4)php artisan db:seed
```

4.Setting Chat:
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
5.Cache settings info
```
This application uses the cache given to reduce queries to the database.
The default is the 'file' cache driver.
```
```
For production, it is recommended to change the driver to 'memcached' or 'redis
1.You need install memcached on server;
2.Change .env CACHE_DRIVER=;
3.php artisan  config:cache;
```