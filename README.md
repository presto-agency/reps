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
