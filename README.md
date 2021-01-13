1.Deploy:

```$xslt
npm install
composer install
php artisan sleepingowl:install

sudo apt-get install php-imagick
```
2.Update data in .env file

Run:
```
php artisan key:generate
php artisan storage:link
php artisan optimize:clear
php artisan optimize
php artisan view:cache
php artisan event:cache
php artisan migrate

npm run dev
(for pdor version)
npm run prod
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
For production, it is recommended to change the driver to 'redis'
1.Change .env CACHE_DRIVER=;
2.php artisan config:clear
3.php artisan config:cache
```
6.Mail settings info
```
In the .emn file you need configure the email sending configuration
```
```
0.Server:(
        sudo apt-get install php-mail
        sudo apt-get install sendmail
        sudo sendmailconfig
        php.ini  -> sendmail_path =  /usr/sbin/sendmail -t -i
)

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

7.Add Root for project
```
cd /var/www/
chmod -R 755 reps/
chown -R www-data:www-data reps/
```

.Server Supervisor:
```
#laravel-worker
1)sudo apt-get install supervisor 
2)sudo -i
3)mc got to path /etc/supervisor/conf.d
4)and create file "reps-echo-server.conf" 
5)add content in file.
[program:reps-echo-server]
#process_name=%(program_name)s_%(process_num)02d
directory=/var/www/reps/
command=laravel-echo-server start
autostart=true
autorestart=true
user=root #ubunto-user
redirect_stderr=true
numprocs=1
stdout_logfile=/var/www/reps/storage/logs/echoserver.log

6)run next commands:

sudo supervisorctl reread
sudo supervisorctl update
.hellper:
ps as | grep artisan
sudo supervisorctl status 
sudo supervisorctl stop reps-echo-server
sudo supervisorctl start reps-echo-server
```

.Server Starting The Scheduler:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
