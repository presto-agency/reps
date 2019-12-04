1.Deploy:

```$xslt
composer install
sudo apt-get install php-imagick
```
2.Update data in .env file

Run:
```
php artisan migrate
php artisan storage:link
php artisan key:generate
php artisan config:clear
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
apt-get install php-redis -y
sudo systemctl start redis-server
redis-cli
```
```
composer require predis/predis
```

- в .env: 
```
BROADCAST_DRIVER=redis
REDIS_PREFIX=reps
```
```
php artisan config:cache
npm install -g laravel-echo-server
laravel-echo-server init
- Development mode: no or yes
- Port: 6001
- Host: enter your host
- http or https
- Generate client key for HTTP API: no
- access API: no

laravel-echo-server start
```
5.Cache settings info
```
This application uses the cache given to reduce queries to the database.
The default is the 'file' cache driver.
```
```
For production, it is recommended to change the driver to 'memcached'
1.You need install memcached on server;
2.Change .env CACHE_DRIVER=;
3.php artisan config:clear
4.php artisan config:cache
```
6.Mail settings info
```
In the .emn file you need configure the email sending configuration
```
```
1.Set urs settings:
MAIL_FROM_ADDRESS=info@reps.ru
MAIL_FROM_NAME=Reps.ru
MAIL_DRIVER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
2.php artisan config:clear;
3.php artisan config:cache;
```

6.Task Manager info
```
The project has tasks. To complete them, you need to configure the task scheduler on the server.
exemple:* * * * * php /path/to/artisan schedule:run >>/dev/null 2>&1
```