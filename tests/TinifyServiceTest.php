<?php

declare(strict_types=1);

namespace yasmuru\LaravelTinify\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use yasmuru\LaravelTinify\Services\TinifyService;

class TinifyServiceTest extends TestCase
{
    #[Test]
    public function constructor_throws_when_apikey_is_missing(): void
    {
        config()->set('tinify.apikey', null);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('TINIFY_APIKEY');

        new TinifyService();
    }

    #[Test]
    public function file_to_s3_throws_when_s3_config_is_missing(): void
    {
        $service = $this->app->make('tinify');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('S3_KEY, S3_SECRET, and S3_REGION');

        $service->fileToS3('/tmp/source.png', 'bucket', '/dest.png');
    }

    #[Test]
    public function buffer_to_s3_throws_when_s3_config_is_missing(): void
    {
        $service = $this->app->make('tinify');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('S3_KEY, S3_SECRET, and S3_REGION');

        $service->bufferToS3('payload', 'bucket', '/dest.png');
    }

    #[Test]
    public function url_to_s3_throws_when_s3_config_is_missing(): void
    {
        $service = $this->app->make('tinify');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('S3_KEY, S3_SECRET, and S3_REGION');

        $service->urlToS3('https://example.com/a.png', 'bucket', '/dest.png');
    }

    #[Test]
    public function s3_to_s3_helpers_throw_when_only_some_credentials_are_set(): void
    {
        config()->set('tinify.s3.key', 'AKIA-test');
        config()->set('tinify.s3.secret', null);
        config()->set('tinify.s3.region', 'us-east-1');

        $this->app->forgetInstance('tinify');
        $service = $this->app->make('tinify');

        $this->expectException(InvalidArgumentException::class);

        $service->fileToS3('/tmp/source.png', 'bucket', '/dest.png');
    }

    #[Test]
    public function compression_count_aliases_match(): void
    {
        $service = $this->app->make('tinify');

        $this->assertSame(
            $service->getCompressionCount(),
            $service->compressionCount(),
        );
    }
}
