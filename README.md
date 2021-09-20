235
## About Lease board

<p>Application brief description</p>

- [Vue](https://vuejs.org/) and [Vuex](https://vuex.vuejs.org/)
- [ElementUI](https://element.eleme.io/#/) and [Bulma](https://bulma.io/)
- [VueRouter](https://router.vuejs.org/) and [VueAuth](https://github.com/websanova/vue-auth)
- [JWT for token based authorization](https://github.com/tymondesigns/jwt-auth)

## Running Lease board from source

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

- Authentication API implemented


**[Version 0.0.0]() (20 Sep 2021)**

- Database migrations test
- Implement subdomain routes for api endpoints
- telescope implemented for debugging




