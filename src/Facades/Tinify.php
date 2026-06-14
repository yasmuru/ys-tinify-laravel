<?php

declare(strict_types=1);

namespace yasmuru\LaravelTinify\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Tinify\Source fromFile(string $path)
 * @method static \Tinify\Source fromBuffer(string $string)
 * @method static \Tinify\Source fromUrl(string $url)
 * @method static mixed fileToS3(string $source_path, string $bucket, string $destination_path)
 * @method static mixed bufferToS3(string $string, string $bucket, string $path)
 * @method static mixed urlToS3(string $url, string $bucket, string $path)
 * @method static void setKey(string $key)
 * @method static void setAppIdentifier(string $appIdentifier)
 * @method static int|null getCompressionCount()
 * @method static int|null compressionCount()
 * @method static bool validate()
 *
 * @see \yasmuru\LaravelTinify\Services\TinifyService
 */
class Tinify extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'tinify';
    }
}