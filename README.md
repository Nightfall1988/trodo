<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Instructions to setup

To setup this project open a terminal window in Trodo directory.

1. Enter commands to download all dependencies:
    - composer install
    - npm install

2. Rename the file ".env.example" to just ".env" and create a database named "trodo". Use these commands to clear the cache.
    - php artisan config:clear
    - php artisan cache:clear

3. Make database migrations with  this command:
    - php artisan migrate:fresh

4. Make currency import with this command:
    - php artisan currencies:update

5. Enter command to start the server:
    - php artisan serve

The project should be set up at this point.
The scheduler is set up so that the currency updates are happening in 23:59, but this can easily be changed.
