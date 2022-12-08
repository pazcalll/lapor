<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## How to Run The App?

After cloning this github repository, it is necessary to run commands below in the right order:

```
composer install
```

```
npm install
```

```
php artisan key:generate
```

Last command to implement API secret key:

```
php artisan jwt:secret
```

In order to perform file upload into the system, execute command below:

```
php artisan storage:link
```

Finally:

```
php artisan serve
```

By default, now developer can access http://localhost:8000 or http://127.0.0.1:8000
