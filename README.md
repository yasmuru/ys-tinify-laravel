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
under "aliases":

```php
        'Tinify' => yasmuru\LaravelTinify\Facades\Tinify::class
```


And set a env variable `TINIFY_APIKEY` with your tinypng api key.

If you want to directly upload the image to `aws s3`, you need set the env variables of following with your aws s3 credentials.

```php
    S3_KEY=
    S3_SECRET=
    S3_REGION=
    S3_BUCKET=
```
