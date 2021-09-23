## About Hello Drip

<p>Message automation application</p>

- [Laravel](https://laravel.com/docs) and [Vue JS](https://v3.vuejs.org/)
- [Laravel sanctum token authorization](ps://laravel.com/docs/8.x/sanctum)

## Run Hello Drip from source

After you clone this preoject, do the following:
```bash
# go into the project
cd hellodrip

# create a .env file
cp .env.example .env

# install composer dependencies
composer install

# install npm dependencies
npm install

# generate a key for your application
php artisan key:generate

# Input MySQL database information in .env file

# run migration files to generate the schema file
php artisan migrate

#start server with 
php artisan serve

```
**Note**
If you are using a Mac with MAMP PRO for mysql server, you are more likely to run into a **connection refused** error. to fix this error:
- Add `DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock` to your `.env` file.
- Open `leaseboard_pro/config/database.php` and add `'unix_socket' => env('DB_SOCKET', '')` to the mysql connections array options
- restart laravel server


## Change Log

**[Version 0.7.0]() (20 Sep 2021)**

- Authentication API implemented with Laravel Sanctum
- Implement  user management


**[Version 0.0.0]() (20 Sep 2021)**

- Database migrations test
- Implement subdomain routes for api endpoints
- telescope implemented for debugging




