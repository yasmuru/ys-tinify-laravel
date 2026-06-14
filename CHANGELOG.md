# Changelog

All notable changes to `ys-tinify-laravel` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

First modernization since 2018. Will be released as 2.0.0 — see breaking changes
below.

### Breaking changes

- Minimum PHP is now **8.2** (was 5.5).
- Minimum Laravel is now **11** (was 5.2). Laravel 10 is EOL since Feb 2025.
- S3 credentials are now read from `config('tinify.s3.*')` instead of `env()`
  inside the service. The `.env` keys (`S3_KEY`, `S3_SECRET`, `S3_REGION`) are
  unchanged; if you set them in `.env` it still works. If you wrote your own
  config override that bound the values differently, update it to the new
  `tinify.s3` shape.

### Added

- Laravel 11, 12, and 13 support (`illuminate/support: ^11.0|^12.0|^13.0`).
- PHP 8.2, 8.3, 8.4 support.
- `config/tinify.php` now exposes an `s3` block for the AWS credentials.
- PHPUnit test suite (10 tests) covering service registration, missing-apikey
  failure, and the S3 helpers' missing-credentials paths.
- PHPStan (Larastan) at level 8 in CI.
- GitHub Actions matrix: PHP 8.2/8.3/8.4 × Laravel 11/12/13.
- `composer check` script that runs PHPStan and PHPUnit in one shot.

### Fixed

- `TinifyService::validate()` previously caught `\Exception`, so an invalid API
  key (or any network/server failure) was reported as **valid**. It now only
  treats `\Tinify\ClientException` as success, matching upstream tinify-php.
- `TinifyService::__construct()` threw an opaque `TypeError` when
  `TINIFY_APIKEY` was unset, because of the typed property assignment. It now
  raises the intended `InvalidArgumentException` with a clear message.
- S3 helpers (`fileToS3`/`bufferToS3`/`urlToS3`) used `env()` inside the service
  constructor, which returns `null` once `php artisan config:cache` has run.
  Values are now resolved via `config()`, so they survive config caching.

### Changed

- Service provider modernized — `boot()`/`register()` split, singleton binding,
  `runningInConsole()` guard on config publishing.
- All source files use `declare(strict_types=1)` with property and return
  types throughout.
- `Tinify` facade documents all public methods via `@method` annotations for
  IDE autocomplete and static analysis.

## [1.0.2] - 2018-01-25

### Fixed

- Added a config file (`config/tinify.php`) so the API key works under
  `php artisan config:cache`. Fixes #1.

## [1.0.1] - 2016-11-16

### Added

- Direct upload to AWS S3 via `fileToS3`, `bufferToS3`, and `urlToS3`.

## [1.0] - 2016-11-15

### Added

- Initial release as `yasmuru/ys-tinify-laravel`. Wraps the `tinify/tinify`
  PHP SDK with a Laravel service provider and `Tinify` facade.
