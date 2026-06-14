# Laravel Tinify

Modern Laravel package for TinyPNG/TinyJPG image compression API. Compress and optimize your images with ease.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yasmuru/ys-tinify-laravel.svg?style=flat-square)](https://packagist.org/packages/yasmuru/ys-tinify-laravel)
[![Tests](https://img.shields.io/github/actions/workflow/status/yasmuru/ys-tinify-laravel/tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/yasmuru/ys-tinify-laravel/actions/workflows/tests.yml)
[![Code Quality](https://img.shields.io/github/actions/workflow/status/yasmuru/ys-tinify-laravel/lint.yml?branch=master&label=code%20quality&style=flat-square)](https://github.com/yasmuru/ys-tinify-laravel/actions/workflows/lint.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/yasmuru/ys-tinify-laravel.svg?style=flat-square)](https://packagist.org/packages/yasmuru/ys-tinify-laravel)

## Requirements

- PHP 8.2, 8.3, or 8.4
- Laravel 11.x, 12.x, or 13.x

## Installation

Install the package via Composer:

```bash
composer require yasmuru/ys-tinify-laravel
```

### Configuration

The package will automatically register itself (Laravel auto-discovery).

Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag=tinify-config
```

Add your TinyPNG API key to your `.env` file:

```env
TINIFY_APIKEY=your-api-key-here
```

You can get a free API key at [tinypng.com/developers](https://tinypng.com/developers).

### Optional: AWS S3 Configuration

If you want to directly upload compressed images to AWS S3, add these environment variables:

```env
S3_KEY=your-aws-access-key
S3_SECRET=your-aws-secret-key
S3_REGION=your-s3-region
```

The bucket name is passed as an argument to each upload call, not configured globally.

## Usage

### Basic Image Compression

```php
use yasmuru\LaravelTinify\Facades\Tinify;

// Compress from file
$result = Tinify::fromFile('/path/to/image.jpg');

// Compress from buffer/string
$result = Tinify::fromBuffer($imageData);

// Compress from URL
$result = Tinify::fromUrl('https://example.com/image.jpg');

// Save compressed image to file
$result->toFile('/path/to/compressed-image.jpg');

// Get compressed image as buffer
$compressedData = $result->toBuffer();
```

### Direct Upload to AWS S3

Upload compressed images directly to S3 without saving locally:

```php
use yasmuru\LaravelTinify\Facades\Tinify;

// Compress file and upload to S3
$s3Result = Tinify::fileToS3(
    '/path/to/image.jpg',
    'my-bucket',
    '/images/compressed-image.jpg'
);

// Compress buffer and upload to S3
$s3Result = Tinify::bufferToS3(
    $imageData,
    'my-bucket',
    '/images/compressed-image.jpg'
);

// Compress URL and upload to S3
$s3Result = Tinify::urlToS3(
    'https://example.com/image.jpg',
    'my-bucket',
    '/images/compressed-image.jpg'
);

// Get S3 image details
$imageUrl = $s3Result->location();
$imageWidth = $s3Result->width();
$imageHeight = $s3Result->height();
```

### Advanced Features

```php
use yasmuru\LaravelTinify\Facades\Tinify;

// Check compression count (free tier has 500 compressions/month).
// compressionCount() is an alias for getCompressionCount().
$count = Tinify::getCompressionCount();

// Set custom API key at runtime
Tinify::setKey('your-custom-api-key');

// Set app identifier
Tinify::setAppIdentifier('My Application');

// Validate the API key. Returns true only if the key is accepted by Tinify;
// returns false for an invalid key or any network/server failure.
$isValid = Tinify::validate();
```

### Resizing Images

You can combine compression with resizing using the Tinify SDK methods:

```php
$result = Tinify::fromFile('/path/to/image.jpg')
    ->resize([
        'method' => 'fit',
        'width' => 150,
        'height' => 100
    ]);

$result->toFile('/path/to/resized-image.jpg');
```

## Important Notes

- **S3 Permissions**: Images uploaded directly to S3 are publicly readable by default. Configure your S3 bucket permissions according to your privacy requirements.
- **API Limits**: The free TinyPNG API tier allows 500 compressions per month. Monitor your usage with `getCompressionCount()`.
- **Supported Formats**: PNG, JPEG, and WebP formats are supported.

## Testing

```bash
composer install
composer check   # runs PHPStan (level 8) + PHPUnit
# or individually:
composer analyse
composer test
```

CI runs the suite against PHP 8.2/8.3/8.4 × Laravel 11/12/13.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- [yasmuru](https://github.com/yasmuru)
- [All Contributors](../../contributors)
