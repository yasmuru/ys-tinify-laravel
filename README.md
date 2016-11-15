# ysTinify-laravel
Tinify API support with laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yasmuru/ys-tinify-laravel.svg?style=flat-square)](https://packagist.org/packages/yasmuru/ys-tinify-laravel)

## Install

``` bash
$ composer require yasmuru/ys-tinify-laravel
```

Add this to your config/app.php, 

under "providers":
```php
        yasmuru\LaravelTinify\LaravelTinifyServiceProvider::class,
```
uder "aliases":

```php
        'Tinify' => yasmuru\LaravelTinify\Facades\Tinify::class
```


And set a env variable `TINIFY_APIKEY`